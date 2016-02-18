<?php
namespace EQM\Core\Files;

use EQM\Core\Movies\EQMWistia;
use EQM\Models\Horses\Horse;
use EQM\Models\Pictures\PictureRepository;
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
     * @var \EQM\Models\Pictures\PictureRepository
     */
    private $pictures;

    /**
     * @param \Illuminate\Contracts\Filesystem\Factory $file
     * @param \Intervention\Image\ImageManager $image
     * @param \EQM\Models\Pictures\PictureRepository $pictures
     */
    public function __construct(Filesystem $file, ImageManager $image, PictureRepository $pictures)
    {
        $this->file = $file;
        $this->image = $image;
        $this->pictures = $pictures;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param \EQM\Models\Horses\Horse $horse
     * @param bool $profile
     * @return \EQM\Models\Pictures\Picture
     */
    public function uploadPicture($file, Horse $horse, $profile = false)
    {
        $extension  = $file->getClientOriginalExtension();
        $path       = '/uploads/pictures/' . $horse->id();
        $fileName   = str_random(12);
        $pathToFile = storage_path() . '/app' . $path . '/' . $fileName . '.' . $extension;

        $picture = $this->pictures->create($file, $horse, $profile, $fileName, $extension);

        if ( ! file_exists(storage_path() . $path) ) {
            $this->file->makeDirectory($path);
        }

        $this->image->make($file->getrealpath())->orientate()->save($pathToFile);

        return $picture;
    }

    public function uploadMovie($file, Horse $horse)
    {
        if (! $horse->hasWistiaKey()) {
            $wistiaKey = (new EQMWistia(env('WISTIA_API')))->createProject(['name' => $horse->slug()]);

            $horse->wistia_project_id = $wistiaKey->hashedId;
            $horse->save();
        }

        $extension  = $file->getClientOriginalExtension();
        $uploadedFile = (new EQMWistia(env('WISTIA_API')))->uploadVideo($file, $horse->wistiaKey());
        $fileName = $uploadedFile->hashed_id;

        $movie = $this->pictures->createVideo($file, $horse, $fileName, $extension);

        return $movie;
    }
}
