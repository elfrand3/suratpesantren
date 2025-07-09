<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Shared\Html;

class WordEditorController extends Controller
{
    public function uploadForm()
    {
        return view('word.upload');
    }

    public function handleUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:doc,docx',
        ]);

        $file = $request->file('file');
        $path = $file->storeAs('public/word', $file->getClientOriginalName());

        // Baca file Word
        $phpWord = IOFactory::load(storage_path('app/' . $path));
        $writer = IOFactory::createWriter($phpWord, 'HTML');

        ob_start();
        $writer->save('php://output');
        $htmlContent = ob_get_clean();

        return view('word.editor', ['htmlContent' => $htmlContent]);
    }

    public function saveEdited(Request $request)
    {
        $request->validate([
            'isi_surat' => 'required|string',
        ]);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        Html::addHtml($section, $request->isi_surat);

        $filename = 'hasil-' . time() . '.docx';
        $path = storage_path("app/public/word/{$filename}");

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($path);

        return response()->download($path)->deleteFileAfterSend();
    }
}
