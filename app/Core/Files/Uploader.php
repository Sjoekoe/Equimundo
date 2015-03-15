<?php 
namespace HorseStories\Core\Files;

use File;
use HorseStories\Models\Pictures\Picture;
use Illuminate\Contracts\Filesystem\Filesystem;
use Image;

class Uploader
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    private $file;

    /**
     * @param \Illuminate\Contracts\Filesystem\Filesystem $file
     */
    public function __construct(Filesystem $file)
    {
        $this->file = $file;
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
            $this->file->makeDirectory(public_path() . $path, 0755);
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