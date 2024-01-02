<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use NumberFormatter;

class Helper
{
    // function for file upload  in public directory
    static function fileUpload($fileName, $path)
    {
        $file = $fileName;
        $filename = $file->getClientOriginalName();
        $file->move(public_path($path), $filename);
        return $dataImage = $filename;
    }
    // function for file upload  in storage directory
    public static function uploadsFile($file, $path)
    {
        if ($file) {
            $fileName  = $file->getClientOriginalName();
            Storage::disk('public')->put($path . $fileName, File::get($file));
            $file_name  = $file->getClientOriginalName();
            $file_type  = $file->getClientOriginalExtension();
            return $filePath   = $path . $fileName;
        }
    }

    // function for date format in controller
    public function dateFormat($requestedDate)
    {
        return date('Y-m-d', strtotime($requestedDate));
    }

    // convert number to word
    function numberToWords($number)
    {
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        return $formatter->format($number);
    }
}
