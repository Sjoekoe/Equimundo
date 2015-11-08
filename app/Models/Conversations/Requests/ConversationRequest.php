<?php namespace EQM\Models\Conversations\Requests;

use EQM\Http\Requests\Request;
use Illuminate\Auth\AuthManager;

class ConversationRequest extends Request {
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @param \Illuminate\Auth\AuthManager $auth
     */
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        if ($this->auth->user()->id == $this->get('contact_id')) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'required',
            'message' => 'required',
        ];
    }

}
