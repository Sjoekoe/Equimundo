<?php
namespace EQM\Core\Files;

use EQM\Core\Movies\EQMWistia;
use EQM\Models\Advertising\Advertisements\Advertisement;
use EQM\Models\Companies\Company;
use EQM\Models\Horses\Horse;
use EQM\Models\Pictures\PictureRepository;
use Illuminate\Contracts\Filesystem\Factory as Filesystem;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @param bool $headerImage
     * @return \EQM\Models\Pictures\Picture
     */
    public function uploadPicture($file, Horse $horse, $profile = false, $headerImage = false)
    {
        $extension = $file->getClientOriginalExtension();
        $path = '/uploads/pictures/' . $horse->id();
        $fileName = str_random(12);
        $pathToFile = $path . '/' . $fileName . '.' . $extension;
        $width = $headerImage ? 1500 : 460;

        $picture = $this->pictures->create($file, $horse, $profile, $fileName, $extension);

        if (!file_exists(storage_path() . $path)) {
            $this->file->makeDirectory($path);
        }

        $image = $this->image->make($file->getrealpath())->resize(null, $width, function ($constraint) {
            $constraint->aspectRatio();
        })->orientate();

        $this->file->disk()->put($pathToFile, $image->stream()->__toString());

        return $picture;
    }
    
    public function uploadForCompany($file, Company $company)
    {
        $extension = $file->getClientOriginalExtension();
        $path = '/uploads/companies/' . $company->id();
        $fileName = str_random(12);
        $pathToFile = $path . '/' . $fileName . '.' . $extension;
        $width = 460;

        $picture = $this->pictures->createForCompany($file, $company, false, $fileName, $extension);

        if (!file_exists(storage_path() . $path)) {
            $this->file->makeDirectory($path);
        }

        $image = $this->image->make($file->getrealpath())->resize(null, $width, function ($constraint) {
            $constraint->aspectRatio();
        })->orientate();

        $this->file->disk()->put($pathToFile, $image->stream()->__toString());

        return $picture;
    }

    public function uploadMovie($file, Horse $horse)
    {
        if (!$horse->hasWistiaKey()) {
            $wistiaKey = (new EQMWistia(env('WISTIA_API')))->createProject(['name' => $horse->slug()]);

            $horse->wistia_project_id = $wistiaKey->hashedId;
            $horse->save();
        }

        $extension = $file->getClientOriginalExtension();
        $uploadedFile = (new EQMWistia(env('WISTIA_API')))->uploadVideo($file, $horse->wistiaKey());
        $fileName = $uploadedFile->hashed_id;

        $movie = $this->pictures->createVideo($file, $horse, $fileName, $extension);

        return $movie;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param \EQM\Models\Advertising\Advertisements\Advertisement $advertisement
     * @return \EQM\Models\Pictures\Picture
     */
    public function uploadAdvertisement(UploadedFile $file, Advertisement $advertisement)
    {
        $extension = $file->getClientOriginalExtension();
        $path = '/uploads/advertisements';
        $fileName = str_random(12);
        $pathToFile = $path . '/' . $fileName . '.' . $extension;

        $picture = $this->pictures->create($file, null, false, $fileName, $extension);

        if (!file_exists(storage_path() . $path)) {
            $this->file->makeDirectory($path);
        }

        $image = $this->image->make($file->getrealpath())->resize($advertisement->width(), $advertisement->height(), function (Constraint $constraint) {
            $constraint->aspectRatio();
        })->orientate();

        $this->file->disk()->put($pathToFile, $image->stream()->__toString());

        return $picture;
    }
}
