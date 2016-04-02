<?php
namespace EQM\Models\Addresses;

use Illuminate\Database\Eloquent\Model;

class EloquentAddress extends Model implements Address
{
    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['addres_line_1', 'city', 'state', 'zip', 'country', 'latitude', 'longitude'];

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function street()
    {
        return $this->address_line_1;
    }

    /**
     * @return string
     */
    public function city()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function state()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function zip()
    {
        return $this->zip;
    }

    /**
     * @return string
     */
    public function country()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function longitude()
    {
        return $this->longitude;
    }

    /**
     * @return string
     */
    public function latitude()
    {
        return $this->latitude;
    }
}
