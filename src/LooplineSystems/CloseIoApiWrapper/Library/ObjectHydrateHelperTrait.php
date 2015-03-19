<?php
/**
* Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
*
* @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
* @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
* @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
*/

namespace LooplineSystems\CloseIoApiWrapper\Library;

use Doctrine\Common\Inflector\Inflector;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\UndefinedMethodException;
use Zend\Filter\Word\UnderscoreToCamelCase;

trait ObjectHydrateHelperTrait
{

    /**
     * @param array $data
     * @param array $nestedObjects
     * @param array $method_mapper
     * @throws InvalidParamException
     * @throws UndefinedMethodException
     */
    public function hydrate(array $data, array $nestedObjects = [], array $method_mapper = [])
    {
        foreach ($data as $key => $value) {

            if (!$value) {
                continue;
            }

            if (!in_array($key, $nestedObjects)) {
                // get setter method for each key in data
                $filter = new UnderscoreToCamelCase();
                $setter = 'set' . $filter->filter($key);
                if (method_exists($this, $setter)) {
                    $this->$setter($value);
                } else {
                    // check if setter method exists that doesn't match Zend filter format
                    if (in_array($setter, array_keys($method_mapper))) {
                        $this->$method_mapper[$setter]($value);
                    } else {
                        // trying to set a value for a non-property
                        throw new UndefinedMethodException($setter);
                    }
                }
            } else {
                // try to hydrate the nested objects
                foreach ($nestedObjects as $currentNestedObject) {
                    // if empty then ignore
                    if (!empty($data[$currentNestedObject])) {
                        // if is not array then throw exception
                        if (is_array($data[$currentNestedObject])) {
                            // rename for clarity
                            $nestedObject = $data[$currentNestedObject];
                            $NestedObjectCollection = array();
                            foreach ($nestedObject as $nestedObjectArguments) {
                                $className = str_replace('Library', 'Model', __NAMESPACE__) . '\\' . ucwords($this::singularize($currentNestedObject));
                                $reflection = new \ReflectionClass($className);
                                $nestedObjectClass = $reflection->newInstanceArgs(array($nestedObjectArguments));
                                $NestedObjectCollection[] = $nestedObjectClass;
                            }
                            $setter = 'set' . ucwords($currentNestedObject);
                            $this->$setter($NestedObjectCollection);
                        } else {
                            throw new InvalidParamException($currentNestedObject . ' must be an array');
                        }
                    }
                }
            }
        }
    }

    /**
     * @param string $plural
     * @return string
     * @description very simple function to return single form of word
     */
    public static function singularize($plural)
    {
        return Inflector::singularize($plural);
    }
}
