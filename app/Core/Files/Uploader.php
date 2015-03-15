<?php 
namespace HorseStories\Core\Files;

use File;
use HorseStories\Models\Pictures\Picture;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Image;

class Uploader
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Factory
     */
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param \HorseStories\Models\Horses\Horse $horse
     * @param bool $profile
     */
    public function uploadPicture($file, $horse, $profile = false)
    {
        $extension  = $file->getClientOriginalExtension();
        $path       = '/uploads/pictures/' . $horse->id;
        $fileName   = str_random(12);
        $pathToFile = public_path() . $path . '/' . $fileName . '.' . $extension;


        if ( ! file_exists(public_path() . $path) ) {
            File::makeDirectory(public_path() . $path, 0755);
        }

        Image::make($file->getrealpath())->resize(null, 350, function ($constraints) {
            $constraints->aspectRatio();
        })->save($pathToFile);

        $picture = new Picture();
        $picture->path = $fileName . '.' . $extension;
        $picture->horse_id = $horse->id;
        $picture->profile_pic = $profile;

        $picture->save();
    }
}