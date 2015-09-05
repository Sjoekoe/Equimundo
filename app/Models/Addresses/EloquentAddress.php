<?php
namespace EQM\Models\Addresses;

use Illuminate\Database\Eloquent\Model;

class EloquentAddress extends Model implements Address
{
    /**
     * @var string
     */
    protected $table = 'addresses';

    /**
     * @var array
     */
    protected $fillable = ['addres_line_1', 'address_line_2', 'city', 'state', 'zip', 'country'];

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
    public function addressLine2()
    {
        return $this->address_line_2;
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
}
