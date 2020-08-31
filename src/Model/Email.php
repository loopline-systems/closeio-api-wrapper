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

namespace LooplineSystems\CloseIoApiWrapper\Model;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Library\JsonSerializableHelperTrait;
use LooplineSystems\CloseIoApiWrapper\Library\ObjectHydrateHelperTrait;

class Email implements \JsonSerializable
{
    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

    const EMAIL_TYPE_HOME = 'home';
    const EMAIL_TYPE_OFFICE = 'office';
    const EMAIL_TYPE_DIRECT = 'direct';

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $type;

    /**
     * @var object
     */
    private $validator;

    /**
     * @var object
     */
    private $validation;

    /**
     * @param array $data
     *
     * @throws InvalidParamException
     */
    public function __construct(array $data = null)
    {
        if ($data) {
            $this->hydrate($data);
        }
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     *
     * @throws InvalidParamException
     */
    public function setEmail($email)
    {
        if (!$this->_getValidator()->isValid($email, $this->_getValidation())) {
            throw new InvalidParamException('Invalid email format: "' . $email . '"');
        } else {
            $this->email = $email;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    private function _getValidator()
    {
        if (is_null($this->validator))
            $this->validator = new EmailValidator();

        return $this->validator;
    }

    private function _getValidation()
    {
        if (is_null($this->validation))
            $this->validation = new RFCValidation();

        return $this->validation;
    }
}

