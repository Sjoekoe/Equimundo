<?php
namespace EQM\Http;

use EQM\Core\Validation\ExtendsValidator;
use EQM\Http\Validators\UrlHostValidator;
use Illuminate\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{
    use ExtendsValidator;

    protected $rules = [
        UrlHostValidator::class,
    ];

    public function register()
    {
    }
}
