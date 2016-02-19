<?php
namespace EQM\Http\Validators;

use EQM\Http\ProtocolPrepender;
use Illuminate\Contracts\Validation\Validator;

class UrlHostValidator
{
    const NAME = 'url_host';

    /**
     * @var \EQM\Http\ProtocolPrepender
     */
    private $protocolPrepender;

    /**
     * @param \EQM\Http\ProtocolPrepender $protocolPrepender
     */
    public function __construct(ProtocolPrepender $protocolPrepender)
    {
        $this->protocolPrepender = $protocolPrepender;
    }
    /**
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return bool
     */
    public function validate($attribute, $value, array $parameters = [], Validator $validator = null)
    {
        if (! $this->isValidUrlString($value)) {
            return false;
        }

        $value = $this->protocolPrepender->prepend($value);

        return filter_var($value, FILTER_VALIDATE_URL) == true;
    }
    /**
     * @param string $value
     * @return bool
     */
    private function isValidUrlString($value)
    {
        return str_contains($value, '.');
    }
}
