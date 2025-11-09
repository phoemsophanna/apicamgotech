<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileStorageController extends Controller
{
    public function uploadImage(Request $request, $dir)
    {
        $image = FileService::save("/$dir", $request->file("file"));
        return $image;
    }

    public function deleteImage(Request $request, $dir)
    {
        // $fileName = strip_tags(file_get_contents("php://input"));
        // FileService::delete($fileName);
        return "success";
    }

    public function previewImage(Request $request, $dir)
    {
        return response()->file(
            public_path("uploads" . $request->load),
            [
                "Access-Control-Expose-Headers" =>  "Content-Disposition, Content-Length, X-Content-Transfer-Id",
                'Content-Type' => 'image/jpeg',
                'Content-Length' => '3965123',
                'Content-Disposition' => 'inline; filename="my-file.jpg"',
                'X-Content-Transfer-Id' => $request->load
            ]
        );
    }

    public function createFileObject($url)
    {

        $path_parts = pathinfo($url);

        $newPath = $path_parts['dirname'] . '/tmp-files/';
        if (!is_dir($newPath)) {
            mkdir($newPath, 0777);
        }

        $newUrl = $newPath . $path_parts['basename'];
        copy($url, $newUrl);
        $imgInfo = getimagesize($newUrl);

        $file = new UploadedFile(
            $newUrl,
            $path_parts['basename'],
            $imgInfo['mime'],
            filesize($url),
            true,
            TRUE
        );

        return $file;
    }
    public function uploadContent(Request $request)
    {
        if ($request->hasFile('file')) {
            $image = FileService::save('/content', $request->file('file'), null);
            return response()->json(['location' => asset('uploads' . $image)]);
        }
        return '';
    }
}
