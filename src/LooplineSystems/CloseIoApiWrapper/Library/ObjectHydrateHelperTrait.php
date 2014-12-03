<?php
/**
* Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
*
* @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
* @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
* @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
*/

namespace LooplineSystems\CloseIoApiWrapper\Library;

use Zend\Filter\Word\UnderscoreToCamelCase;

trait ObjectHydrateHelperTrait
{

    /**
     * @param array $data
     * @param array $nested_objects
     * @param array $method_mapper
     */
    public function hydrate(array $data, array $nested_objects = [], array $method_mapper = [])
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $nested_objects)) {
                // get setter method for each key in data
                $filter = new UnderscoreToCamelCase();
                $setter = 'set' . $filter->filter($key);
                if (method_exists($this, $setter)) {
                    $this->$setter($value);
                } else {
                    // check if setter method exists that doesn't match Zend filter format
                    if (in_array($setter, array_keys($method_mapper))) {
                        $this->$method_mapper[$setter]($value);
                    }
                }
            }
        }
    }
}
