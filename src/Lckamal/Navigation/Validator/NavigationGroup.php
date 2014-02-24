<?php namespace Lckamal\Navigation\Validator;

use Orchestra\Support\Validator;

class NavigationGroup extends Validator
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = array(
        'title'   => array('required'),
        'abbrev'    => array('required'),
    );

}
