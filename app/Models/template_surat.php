<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class template_surat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'template_surats';
    
    protected $fillable = [
        'nama_template',
        'jenis_surat',
        'deskripsi',
        'file_name',
        'content_html',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the file URL for download
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_path && Storage::disk('private')->exists($this->file_path)) {
            return route('admin.template.download', $this->id);
        }
        return null;
    }

    /**
     * Get the file size in human readable format
     */
    public function getFileSizeHumanAttribute()
    {
        if (!$this->file_size) {
            return null;
        }

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Store uploaded file
     */
    public function storeFile($file)
    {
        if (!$file) {
            return false;
        }

        // Delete old file if exists
        if ($this->file_path && Storage::disk('private')->exists($this->file_path)) {
            Storage::disk('private')->delete($this->file_path);
        }

        // Generate unique filename
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $jenisSuratSlug = Str::slug($this->jenis_surat ?? 'umum');
        $path = 'template/' . $jenisSuratSlug . '/template/' . $filename;

        // Store file in private disk
        if (Storage::disk('private')->put($path, file_get_contents($file))) {
            $this->update([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
            ]);
            return true;
        }

        return false;
    }

    /**
     * Delete file from storage
     */
    public function deleteFile()
    {
        if ($this->file_path && Storage::disk('private')->exists($this->file_path)) {
            Storage::disk('private')->delete($this->file_path);
            $this->update([
                'file_path' => null,
                'file_name' => null,
                'file_size' => null,
                'file_type' => null,
            ]);
            return true;
        }
        return false;
    }

    /**
     * Scope for active templates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for templates by jenis surat
     */
    public function scopeByJenisSurat($query, $jenisSurat)
    {
        return $query->where('jenis_surat', $jenisSurat);
    }
}
