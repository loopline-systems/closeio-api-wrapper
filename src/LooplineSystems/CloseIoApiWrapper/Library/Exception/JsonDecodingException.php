<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Library\Exception;

class JsonDecodingException extends \RuntimeException
{
    /**
     * @param int|string $code
     * @param \Exception $previous
     */
    public function __construct($code = JSON_ERROR_NONE, \Exception $previous = null)
    {
        switch ($code) {
            case JSON_ERROR_DEPTH:
                $message = 'The maximum stack depth has been exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $message = 'Invalid or malformed JSON';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $message = 'Control character error, possibly incorrectly encoded';
                break;
            case JSON_ERROR_UTF8:
                $message = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            case JSON_ERROR_SYNTAX:
                $message = 'JSON syntax is malformed';
                break;
            default:
                $message = 'Syntax error';
        }
        parent::__construct($message, $code, $previous);
    }
}
