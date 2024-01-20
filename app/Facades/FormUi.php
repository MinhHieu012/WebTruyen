<?php

namespace App\Facades;

use App\Helpers\FormHelper;
use Illuminate\Support\Facades\Facade;

class FormUi extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FormHelper::class;
    }
}
