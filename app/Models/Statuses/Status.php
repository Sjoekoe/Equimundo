<?php
namespace EQM\Models\Statuses;

use EQM\Models\Pictures\Picture;
use EQM\Models\Users\User;

interface Status
{
    const PREFIX_PALMARES = 1;
    const PREFIX_JOINED_COMPANY = 2;
    const TABLE = 'statuses';

    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function body();

    /**
     * @return int
     */
    public function prefix();

    /**
     * @return \EQM\Models\Users\User
     */
    public function user();

    /**
     * @return \EQM\Models\Comments\Comment[]
     */
    public function comments();

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function likes();

    /**
     * @return \EQM\Models\Palmares\Palmares
     */
    public function palmares();

    /**
     * @return \EQM\Models\Pictures\Picture
     */
    public function pictures();

    /**
     * @param \EQM\Models\Pictures\Picture $picture
     */
    public function setPicture(Picture $picture);

    /**
     * @return bool
     */
    public function hasPicture();

    /**
     * @return \EQM\Models\Pictures\Picture
     */
    public function getPicture();

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt();

    /**
     * @param \EQM\Models\Users\User $user
     * @return bool
     */
    public function isLikedByUser(User $user);
}
