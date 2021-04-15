<?php

namespace LooplineSystems\CloseIoApiWrapper\Library\Doctrine;

use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Inflector;

final class InflectorSingleton
{
    /**
     * @var Inflector
     */
    private static $instance;

    private function __construct() {}

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
