<?php
namespace EQM\Api\Pictures;

use EQM\Models\Pictures\Picture;
use League\Fractal\TransformerAbstract;

class PictureTransformer extends TransformerAbstract
{
    public function transform(Picture $picture)
    {
        return [
            'id' => $picture->id(),
            'is_image' => (bool) $picture->isImage(),
            'is_movie' => (bool) $picture->isMovie(),
            'path' => $picture->path(),
            'is_profile_picture' => (bool) $picture->profilePicture(),
            'is_header_image' => (bool) $picture->headerImage(),
            'mime' => $picture->mime(),
        ];
    }
}
