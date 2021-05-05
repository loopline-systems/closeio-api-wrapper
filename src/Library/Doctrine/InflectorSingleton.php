<?php

namespace LooplineSystems\CloseIoApiWrapper\Library\Doctrine;

use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;

final class InflectorSingleton
{
    /**
     * @var Inflector
     */
    private static $instance;

    private function __construct()
    {
    }

    /**
     * @return Inflector
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = InflectorFactory::create()->build();
        }

        return self::$instance;
    }
}
