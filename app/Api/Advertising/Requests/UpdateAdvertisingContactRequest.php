<?php
namespace EQM\Api\Advertising\Requests;

use EQM\Http\Requests\Request;
use EQM\Models\Advertising\Contacts\AdvertisingContact;

class UpdateAdvertisingContactRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $contact = $this->route('advertising_contact');

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required|unique:' . AdvertisingContact::TABLE . ',id,' . $contact->id(),
        ];
    }
}
