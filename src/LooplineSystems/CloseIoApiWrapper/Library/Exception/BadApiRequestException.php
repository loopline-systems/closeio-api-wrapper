<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Library\Exception;

class BadApiRequestException extends \Exception {

    /**
     * {@inheritdoc}
     */
    public function __construct(array $allErrors)
    {
        $output = '';
        foreach ($allErrors as $type => $errorsByType){
            if (! empty ($errorsByType)) {
                if (is_array($errorsByType)) {
                    $output .= $type . ' : ' .PHP_EOL . implode(PHP_EOL, $errorsByType);
                } else {
                    $output .= $type . ' : ' . $errorsByType;
                }
            }
        }
        parent::__construct('Api request returned errors. ' . PHP_EOL . $output);
    }
} 
