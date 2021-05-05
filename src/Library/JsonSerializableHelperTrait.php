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

trait JsonSerializableHelperTrait
{
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $objectVars = get_object_vars($this);

        // The `custom` object is deprecated and doesn't supports setting
        // `null` values to unset a field from a lead, so when serializing
        // to JSON we flat the pair or field name/field value in the root
        // object using as name of the field `custom.<field ID>`
        if (isset($objectVars['custom'])) {
            foreach ($objectVars['custom'] as $fieldName => $fieldValue) {
                $objectVars['custom.' . $fieldName] = $fieldValue;
            }
        }

        unset($objectVars['custom']);

        $objectVars = array_filter($objectVars, static function ($value, $key): bool {
            if (strpos($key, 'custom.') === 0) {
                return true;
            }

            return (bool) $value;
        }, \ARRAY_FILTER_USE_BOTH);

        return $objectVars;
    }
}
