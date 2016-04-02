<?php
namespace EQM\Api\Http\Controllers\Admin;

use EQM\Api\Advertising\AdvertisingContactTransformer;
use EQM\Api\Advertising\Requests\StoreAdvertisingContactRequest;
use EQM\Api\Advertising\Requests\UpdateAdvertisingContactRequest;
use EQM\Api\Http\Controller;
use EQM\Models\Advertising\Contacts\AdvertisingContact;
use EQM\Models\Advertising\Contacts\AdvertisingContactRepository;
use Input;

class ContactController extends Controller
{
    /**
     * @var \EQM\Models\Advertising\Contacts\AdvertisingContactRepository
     */
    private $advertisingContacts;

    public function __construct(AdvertisingContactRepository $advertisingContacts)
    {
        $this->advertisingContacts = $advertisingContacts;
    }

    public function index()
    {
        $contacts = $this->advertisingContacts->findAllPaginated(Input::get('limit', 10));

        return $this->response()->paginator($contacts, new AdvertisingContactTransformer());
    }

    public function store(StoreAdvertisingContactRequest $request)
    {
        $contact = $this->advertisingContacts->create($request->all());

        return $this->response()->item($contact, new AdvertisingContactTransformer());
    }

    public function show(AdvertisingContact $advertisingContact)
    {
        return $this->response()->item($advertisingContact, new AdvertisingContactTransformer());
    }

    public function update(UpdateAdvertisingContactRequest $request, AdvertisingContact $advertisingContact)
    {
        $contact = $this->advertisingContacts->update($advertisingContact, $request->all());

        return $this->response()->item($contact, new AdvertisingContactTransformer());
    }

    public function delete(AdvertisingContact $advertisingContact)
    {
        $this->advertisingContacts->delete($advertisingContact);

        return $this->response()->noContent();
    }
}
