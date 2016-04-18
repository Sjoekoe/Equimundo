<?php
namespace EQM\Models\Pictures;

use EQM\Models\Companies\Company;
use EQM\Models\Horses\Horse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface PictureRepository
{
    /**
     * @param int $id
     * @return \EQM\Models\Pictures\Picture
     */
    public function findById($id);

    /**
     * @param string $path
     * @return \EQM\Models\Pictures\Picture
     */
    public function findByPath($path);

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param \EQM\Models\Horses\Horse|null $horse
     * @param bool $profile
     * @param string $filename
     * @param string $extension
     * @return \EQM\Models\Pictures\Picture
     */
    public function create(UploadedFile $file, Horse $horse = null, $profile, $filename, $extension);

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param \EQM\Models\Horses\Horse $horse
     * @param string $filename
     * @param string $extension
     * @return \EQM\Models\Pictures\Picture
     */
    public function createVideo(UploadedFile $file, Horse $horse, $filename, $extension);

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param \EQM\Models\Companies\Company $company
     * @param string $fileName
     * @param string $extension
     * @return \EQM\Models\Pictures\Picture
     */
    public function createForCompany(UploadedFile $file, Company $company, $fileName, $extension);

    /**
     * @param \EQM\Models\Pictures\Picture $picture
     */
    public function delete(Picture $picture);

    /**
     * @return int
     */
    public function count();
}
