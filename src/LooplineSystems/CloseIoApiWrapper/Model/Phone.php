<?php
/**
* Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
*
* @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
* @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
* @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
*/

namespace LooplineSystems\CloseIoApiWrapper\Model;

use LooplineSystems\CloseIoApiWrapper\Library\JsonSerializableHelperTrait;
use LooplineSystems\CloseIoApiWrapper\Library\ObjectHydrateHelperTrait;

class Phone implements \JsonSerializable
{
    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

    const PHONE_TYPE_HOME = 'Home';
    const PHONE_TYPE_OFFICE = 'Office';
    const PHONE_TYPE_MOBILE = 'Mobile';
    const PHONE_TYPE_DIRECT = 'Direct';
    const PHONE_TYPE_FAX = 'Fax';

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $phone_formatted;

    /**
     * @var string
     */
    private $type;

    /**
     * @param array $data
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
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

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
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneFormatted()
    {
        return $this->phone_formatted;
    }

    /**
     * @param $phone_formatted
     * @return $this
     */
    public function setPhoneFormatted($phone_formatted)
    {
        $this->phone_formatted = $phone_formatted;

        return $this;
    }
}
