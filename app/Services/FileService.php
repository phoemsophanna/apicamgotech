<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class FileService
{
    public static function save(string $destination, UploadedFile $imageFile, string $temperatureFile = null)
    {
        if ($imageFile != null) {
            $path = public_path('uploads') . $destination;
            $name = $imageFile->hashName();
            $fileName = "CamGoTech_" . $name;

            if ($imageFile->move($path, $fileName)) {
                FileService::delete($temperatureFile);
                return "$destination/$fileName";
            }

            return null;
        }
    }

    public static function delete(string $temperatureFile = null)
    {
        $tmp = public_path() . '/uploads' . $temperatureFile;
        if ($temperatureFile != null) {
            File::delete($tmp);
            Log::info("Delete file $tmp successfully");
        }
    }
}
