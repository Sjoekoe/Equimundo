<?php
namespace EQM\Models\Advertising\Contacts;

class EloquentAdvertisingContactRepository implements AdvertisingContactRepository
{
    /**
     * @var \EQM\Models\Advertising\Contacts\EloquentAdvertisingContact
     */
    private $advertisingContact;

    public function __construct(EloquentAdvertisingContact $advertisingContact)
    {
        $this->advertisingContact = $advertisingContact;
    }

    /**
     * @param array $values
     * @return \EQM\Models\Advertising\Contacts\AdvertisingContact
     */
    public function create(array $values)
    {
        $contact = new EloquentAdvertisingContact([
            'first_name' => $values['first_name'],
            'last_name' => $values['last_name'],
            'telephone' => $values['telephone'],
            'email' => $values['email'],
        ]);

        $contact->save();

        return $contact;
    }

    /**
     * @param \EQM\Models\Advertising\Contacts\AdvertisingContact $advertisingContact
     * @param array $values
     * @return \EQM\Models\Advertising\Contacts\AdvertisingContact
     */
    public function update(AdvertisingContact $advertisingContact, array $values)
    {
        $advertisingContact->first_name = $values['first_name'];
        $advertisingContact->last_name = $values['last_name'];
        $advertisingContact->email = $values['email'];
        $advertisingContact->telephone = $values['telephone'];

        $advertisingContact->save();

        return $advertisingContact;
    }

    /**
     * @param \EQM\Models\Advertising\Contacts\AdvertisingContact $advertisingContact
     */
    public function delete(AdvertisingContact $advertisingContact)
    {
        $advertisingContact->delete();
    }

    /**
     * @param $id
     * @return \EQM\Models\Advertising\Contacts\AdvertisingContact|null
     */
    public function findById($id)
    {
        return $this->advertisingContact->where('id', $id)->first();
    }

    public function findAllPaginated($limit = 10)
    {
        return $this->advertisingContact->paginate($limit);
    }
}
