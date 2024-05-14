<?php 

namespace App\Services;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage; 
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
// use App\Services\ImageService;

class ImageService
{
    public static function upload($imageFile,$folderName){
        $fileName = uniqid(rand().'_');
            $extension = $imageFile->extension();
            $fileNameToStore = $fileName.'.'.$extension;
            $resizedImage = Image::read($imageFile)->resize(1920, 1080)->encode();
            Storage::put('public/'.$folderName.'/'.$fileNameToStore,$resizedImage);
        
        return $fileNameToStore;
    }
}