<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\QRTemplateModel;
use ZipArchive;

class QRTemplateController extends Controller
{

    protected $imagePath = 'qr-template/';

    public function fetch(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|integer|exists:companies,id',
        ]);

        $restaurantId = $request->restaurant_id;
        $images = QRTemplateModel::where('restaurant_id', $restaurantId)->paginate(10);

        $folder = $this->imagePath . $restaurantId;

        $formattedImages = $images->items();

        $formattedImages = array_map(function ($image) use ($restaurantId) {
            return [
                'id' => $image->id,
                'url' => asset('uploads/' . $this->imagePath . $restaurantId . '/' . $image->path),
            ];
        }, $formattedImages);

        return response()->json([
            'images' => $formattedImages,
            'pagination' => $images->links()
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'restaurant_id' => 'required|integer|exists:companies,id',
        ]);

        try {
            $restaurantId = $request->input('restaurant_id');
            $folder = $this->imagePath . $restaurantId;
            $path = $request->file('image')->store($folder, 'public_uploads_qrtemplate');
            $image = QRTemplateModel::create([
                'restaurant_id' => $restaurantId,
                'path' => basename($path),
            ]);

            return response()->json([
                'message' => 'Image uploaded successfully!',
                'image' => [
                    'id' => $image->id,
                    'url' => asset('storage/' . $folder . '/' . basename($path)),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Upload failed!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:qr_template,id',
            'restaurant_id' => 'required|integer|exists:companies,id',
        ]);

        $restaurantId = $request->restaurant_id;

        $image = QRTemplateModel::where('id', $request->id)
            ->where('restaurant_id', $restaurantId)
            ->firstOrFail();

        Storage::disk('public_uploads_qrtemplate')->delete($this->imagePath . $restaurantId . '/' . $image->path);
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully!']);
    }

    public function zipImages($restaurant_id)
    {
        $folderPath = public_path("uploads/qr-template/{$restaurant_id}");

        $zipPath = public_path("uploads/qr-template/qrtemplate_{$restaurant_id}.zip");

        if (!file_exists($folderPath)) {
            return response()->json(['message' => 'No images found to zip.'], 404);
        }

        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) !== true) {
            return response()->json(['message' => 'Failed to create zip file.'], 500);
        }

        $files = glob("{$folderPath}/*");
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }

        $zip->close();

        return response()->json(['message' => 'Zip created successfully.']);
    }
}
