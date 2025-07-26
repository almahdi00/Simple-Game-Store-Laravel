<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ExtractZip
{
    public static function extract($zipPath, $extractPath)
    {
        $zip = new ZipArchive;
        if ($zip->open(Storage::disk('public')->path($zipPath)) === TRUE) {
            $zip->extractTo(Storage::disk('public')->path($extractPath));
            $zip->close();
            return true;
        }
        return false;
    }
}