<?php
namespace EQM\Models\Pictures;

class PictureRepository
{
    /**
     * @var \EQM\Models\Pictures\Picture
     */
    private $picture;

    /**
     * @param \EQM\Models\Pictures\Picture $picture
     */
    public function __construct(Picture $picture)
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
}
