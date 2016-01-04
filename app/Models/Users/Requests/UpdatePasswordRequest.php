<?php
namespace EQM\Models\Users\Requests;

use EQM\Http\Requests\Request;

class UpdatePasswordRequest extends Request
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ];

    }
}
