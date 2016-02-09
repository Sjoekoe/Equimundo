<?php
namespace EQM\Models\Pictures;

use EQM\Models\Horses\Horse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EloquentPictureRepository implements PictureRepository
{
    /**
     * @var \EQM\Models\Pictures\EloquentPicture
     */
    private $picture;

    /**
     * @param \EQM\Models\Pictures\EloquentPicture $picture
     */
    public function __construct(EloquentPicture $picture)
    {

        $this->picture = $picture;
    }

    /**
     * @param int $id
     * @return \EQM\Models\Pictures\Picture
     */
    public function findById($id)
    {
        return $this->picture->where('id', $id)->first();
    }

    /**
     * @param string $path
     * @return \EQM\Models\Pictures\Picture
     */
    public function findByPath($path)
    {
        return $this->picture->where('path', $path)->firstOrFail();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param \EQM\Models\Horses\Horse $horse
     * @param bool $profile
     * @param string $fileName
     * @param string $extension
     * @return \EQM\Models\Pictures\Picture
     */
    public function create(UploadedFile $file, Horse $horse, $profile, $fileName, $extension)
    {
        $picture = new EloquentPicture();
        $picture->path = $fileName . '.' . $extension;
        $picture->horse_id = $horse->id();
        $picture->mime = $file->getClientMimeType();
        $picture->original_name = $file->getClientOriginalName();
        $picture->profile_pic = $profile;

        $picture->save();

        return $picture;
    }

    /**
     * @param \EQM\Models\Pictures\Picture $picture
     */
    public function delete(Picture $picture)
    {
        $picture->delete();
    }
}
