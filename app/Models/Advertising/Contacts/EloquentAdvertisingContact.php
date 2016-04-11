<?php
namespace EQM\Models\Advertising\Contacts;

use EQM\Models\UsesTimeStamps;
use Illuminate\Database\Eloquent\Model;

class EloquentAdvertisingContact extends Model implements AdvertisingContact
{
    use UsesTimeStamps;

    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'telephone'];

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
    public function firstName()
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function lastName()
    {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function telephone()
    {
        return $this->telephone;
    }
}
