<?php

namespace src;


class Application
{
    const VERSION = '1.0.0';

    protected $basePath;

    protected $environmentFile = '.env';

    public function __construct($basePath = null)
    {
        if ( ! empty($basePath)) {
            $this->setBasePath($basePath);
        }
echo time();
    }

    public function version()
    {
        return static::VERSION;
    }
}