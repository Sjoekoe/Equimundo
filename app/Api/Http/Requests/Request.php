<?php
namespace EQM\Api\Http\Requests;

use Dingo\Api\Http\FormRequest;

abstract class Request extends FormRequest
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
        return [];
    }

    /**
     * @param string|null $guard
     * @return \EQM\Models\Users\User|null
     */
    public function user($guard = null)
    {
        return parent::user($guard);
    }
}
