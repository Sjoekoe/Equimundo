<?php
namespace EQM\Models\Advertising\Companies;

use Illuminate\Database\Eloquent\Collection;

class EloquentAdvertisingCompanyRepository implements AdvertisingCompanyRepository
{
    /**
     * @var \EQM\Models\Advertising\Companies\AdvertisingCompany
     */
    private $advertisingCompany;

    public function __construct(AdvertisingCompany $advertisingCompany)
    {
        $this->advertisingCompany = $advertisingCompany;
    }

    public function create(array $values)
    {
        $advertisingCompany = new EloquentAdvertisingCompany([
            'name' => $values['name'],
            'tax' => array_get($values, 'tax'),
            'telephone' => array_get($values, 'telephone'),
            'email' => array_get($values, 'email'),
            'adv_contact_id' => $values['adv_contact_id'],
            'address_id' => array_get($values, 'address_id'),
        ]);

        $advertisingCompany->save();

        return $advertisingCompany;
    }

    /**
     * @param \EQM\Models\Advertising\Companies\AdvertisingCompany $advertisingCompany
     * @param array $values
     * @return \EQM\Models\Advertising\Companies\AdvertisingCompany
     */
    public function update(AdvertisingCompany $advertisingCompany, array $values)
    {
        $advertisingCompany->name = $values['name'];
        $advertisingCompany->email = array_get($values, 'email');
        $advertisingCompany->tax = array_get($values, 'tax');
        $advertisingCompany->telephone = array_get($values, 'telephone');

        $advertisingCompany->save();

        return $advertisingCompany;
    }

    /**
     * @param \EQM\Models\Advertising\Companies\AdvertisingCompany $advertisingCompany
     */
    public function delete(AdvertisingCompany $advertisingCompany)
    {
        $advertisingCompany->delete();
    }

    /**
     * @param $id
     * @return \EQM\Models\Advertising\Companies\AdvertisingCompany|null
     */
    public function findById($id)
    {
        return $this->advertisingCompany->where('id', $id)->first();
    }

    /**
     * @return \EQM\Models\Advertising\Companies\AdvertisingCompany[]
     */
    public function findAll()
    {
        $companies = $this->advertisingCompany->all();

        return new Collection($companies);
    }

    public function findAllPaginated($limit = 10)
    {
        return $this->advertisingCompany->paginate($limit);
    }
}
