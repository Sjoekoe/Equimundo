<?php
namespace HorseStories\Models\Addresses;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['addres_line_1', 'address_line_2', 'city', 'state', 'zip', 'country'];
}
