<?php
namespace EQM\Core\Validation;

trait ExtendsValidator
{
    public function boot()
    {
        $this->extendValidator();
    }
    protected function extendValidator()
    {
        foreach ($this->rules as $rule) {
            $this->app['validator']->extend($rule::NAME, "$rule@validate");
        }
    }
}
