<?php

namespace App\Utilities;

use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

class ImageHelper
{

    public $destinationFolder;
    public $destinationThumbnail;
    public $extension;
    public $file;
    public $imageDefaults;
    public $imageName;
    public $imagePath;
    public $thumbHeight;
    public $thumbSuffix;
    public $thumbnailPath;
    public $thumbWidth;


    public function __construct($imageTypeKey)
    {

        $this->setImageDefaultsFromConfig($imageTypeKey);


    }

    /**
     * @param $modelImage
     * hand in the model
     */

    public function deleteExistingImages($modelImage)
    {
        // delete old images before saving new

        $this->deleteImage($modelImage, $this->destinationFolder);

        $this->deleteThumbnail($modelImage, $this->destinationThumbnail);

    }

    public function deleteImage($modelImage, $destination)
    {
        File::delete(public_path($destination)
                     . $modelImage->image_name
                     . '.'
                     . $modelImage->image_extension);

    }

    public function deleteThumbnail($modelImage, $destination)
    {

        File::delete(public_path($destination)
                     . $modelImage->image_name
                     . $this->thumbSuffix
                     .'.'
                     . $modelImage->image_extension);

    }

    public function formatImageName($name)
    {

        return kebab_case(strtolower($name));

    }



    public function getUploadedFile()
    {

        return  $file = Input::file('image');

    }

    public function makeImageAndThumbnail()
    {
        //create instance of image from temp upload

        $image = Image::make($this->file->getRealPath());

        //save image with thumbnail

        $image->save(public_path() . $this->destinationFolder
                                   . $this->imageName
                                   . '.'
                                   . $this->extension)
              ->resize($this->thumbWidth, $this->thumbHeight)

            // ->greyscale()

            ->save(public_path() . $this->destinationThumbnail
                                 . $this->imageName
                                 . $this->thumbSuffix
                                 . '.'
                                 . $this->extension);

    }

    /**
     * @return bool
     */

    public function newFileIsUploaded()
    {

        return !empty(Input::file('image'));

    }

    public function saveImageFiles(UploadedFile $file, $model)
    {
        $this->setImageFile($file);
        $this->setFileAttributes($model);
        $this->makeImageAndThumbnail();

    }

    public function setImageDefaultsFromConfig($imageTypeKey)
    {
        $imageType = 'image-defaults.' . $imageTypeKey;
        $this->imageDefaults = Config::get($imageType);
        $this->setImageProperties();

    }

    public function setFileAttributes($model)
    {

        $this->imageName = $model->image_name;
        $this->extension = $model->image_extension;

    }

    public function setImageProperties()
    {

        foreach ($this->imageDefaults as $propertyName => $propertyValue){

            if ( property_exists( $this , $propertyName) ){

                $this->$propertyName = $propertyValue;

            }

        }

    }

    public function setImageFile(UploadedFile $file)
    {

        $this->file = $file;

    }

}