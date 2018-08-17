<?php declare(strict_types=1);
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
    const JSON_ERROR_DEPTH_MESSAGE = 'The maximum stack depth has been exceeded';
    const JSON_ERROR_STATE_MISMATCH_MESSAGE = 'Invalid or malformed JSON';
    const JSON_ERROR_CTRL_CHAR_MESSAGE = 'Control character error, possibly incorrectly encoded';
    const JSON_ERROR_UTF8_MESSAGE = 'Malformed UTF-8 characters, possibly incorrectly encoded';
    const JSON_ERROR_SYNTAX_MESSAGE = 'JSON syntax is malformed';
    const JSON_ERROR_DEFAULT_MESSAGE = 'Syntax error';

    /**
     * @param int|string $code
     * @param \Exception $previous
     */
    public function __construct($code = JSON_ERROR_NONE, \Exception $previous = null)
    {
        switch ($code) {
            case JSON_ERROR_DEPTH:
                $message = self::JSON_ERROR_DEPTH_MESSAGE;
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $message = self::JSON_ERROR_STATE_MISMATCH_MESSAGE;
                break;
            case JSON_ERROR_CTRL_CHAR:
                $message = self::JSON_ERROR_CTRL_CHAR_MESSAGE;
                break;
            case JSON_ERROR_UTF8:
                $message = self::JSON_ERROR_UTF8_MESSAGE;
                break;
            case JSON_ERROR_SYNTAX:
                $message = self::JSON_ERROR_SYNTAX_MESSAGE;
                break;
            default:
                $message = self::JSON_ERROR_DEFAULT_MESSAGE;
        }
        parent::__construct($message, $code, $previous);
    }
}
