<?php
namespace EQM\Core\Files;

use EQM\Models\Pictures\Picture;
use Illuminate\Contracts\Filesystem\Factory as Filesystem;
use Intervention\Image\ImageManager;

class Uploader
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Factory
     */
    private $file;

    /**
     * @var \Intervention\Image\ImageManager
     */
    private $image;

    /**
     * @param \Illuminate\Contracts\Filesystem\Factory $file
     * @param \Intervention\Image\ImageManager $image
     */
    public function __construct(Filesystem $file, ImageManager $image)
    {
        $this->file = $file;
        $this->image = $image;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param \EQM\Models\Horses\Horse $horse
     * @param bool $profile
     * @return \EQM\Models\Pictures\Picture
     */
    public function uploadPicture($file, $horse, $profile = false)
    {
        $extension  = $file->getClientOriginalExtension();
        $path       = '/uploads/pictures/' . $horse->id;
        $fileName   = str_random(12);
        $pathToFile = storage_path() . '/app' . $path . '/' . $fileName . '.' . $extension;

        $picture = new Picture();
        $picture->path = $fileName . '.' . $extension;
        $picture->horse_id = $horse->id;
        $picture->mime = $file->getClientMimeType();
        $picture->original_name = $file->getClientOriginalName();
        $picture->profile_pic = $profile;

        $picture->save();

        if ( ! file_exists(storage_path() . $path) ) {
            $this->file->makeDirectory($path);
        }

        $this->image->make($file->getrealpath())->resize(null, 350, function ($constraints) {
            $constraints->aspectRatio();
        })->save($pathToFile);

        return $picture;
    }
}
