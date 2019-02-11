<?php

/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems.
 *
 * @see      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 *
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

declare(strict_types=1);

namespace LooplineSystems\CloseIoApiWrapper\Library;

use Doctrine\Common\Inflector\Inflector;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;

trait ObjectHydrateHelperTrait
{
    /**
     * @param array $data
     * @param array $nestedObjects
     * @param array $method_mapper
     *
     * @throws InvalidParamException
     */
    public function hydrate(array $data, array $nestedObjects = [], array $method_mapper = [])
    {
        foreach ($data as $key => $value) {
            if (!$value) {
                continue;
            }

            if (!\in_array($key, $nestedObjects)) {
                // get setter method for each key in data
                $setter = 'set' . Inflector::classify($key);
                if (method_exists($this, $setter)) {
                    $this->$setter($value);
                } else {
                    // check if setter method exists that doesn't match inflected filter format
                    if (\in_array($setter, array_keys($method_mapper))) {
                        $this->{$method_mapper[$setter]}($value);
                    } else {
                        // value is not set - Entities should be extended if needed
                    }
                }
            } else {
                // try to hydrate the nested objects
                foreach ($nestedObjects as $currentNestedObject) {
                    // if empty then ignore
                    if (!empty($data[$currentNestedObject])) {
                        // if is not array then throw exception
                        if (\is_array($data[$currentNestedObject])) {
                            // rename for clarity
                            $nestedObject = $data[$currentNestedObject];
                            $NestedObjectCollection = [];
                            foreach ($nestedObject as $nestedObjectArguments) {
                                $singluarizedName = Inflector::singularize($currentNestedObject);
                                $className = Inflector::classify($singluarizedName);
                                $classNameWithFQDN = str_replace('Library', 'Model', __NAMESPACE__) . '\\' . $className;
                                $reflection = new \ReflectionClass($classNameWithFQDN);
                                $nestedObjectClass = $reflection->newInstanceArgs([$nestedObjectArguments]);
                                $NestedObjectCollection[] = $nestedObjectClass;
                            }
                            $setter = 'set' . ucwords($currentNestedObject);
                            $this->$setter($NestedObjectCollection);
                        } else {
                            throw new InvalidParamException(sprintf('%s must be an array', $currentNestedObject));
                        }
                    }
                }
            }
        }
    }
}
