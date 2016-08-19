<?php

class BaseLibrary
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }
}
