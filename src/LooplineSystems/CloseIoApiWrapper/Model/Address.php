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

use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Library\JsonSerializableHelperTrait;
use LooplineSystems\CloseIoApiWrapper\Library\ObjectHydrateHelperTrait;

class Address implements \JsonSerializable
{
    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $zipcode;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $address_1;

    /**
     * @var string
     */
    private $address_2;

    /**
     * @param array $data
     *
     * @throws InvalidParamException
     */
    public function __construct(array $data = null)
    {
        if ($data) {
            $this->hydrate($data, [], ['setAddress_1' => 'setAddress1', 'setAddress_2' => 'setAddress2']);
        }
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address_1;
    }

    /**
     * @param string $address_1
     *
     * @return $this
     */
    public function setAddress1($address_1)
    {
        $this->address_1 = $address_1;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address_2;
    }

    /**
     * @param string $address_2
     *
     * @return $this
     */
    public function setAddress2($address_2)
    {
        $this->address_2 = $address_2;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param string $zipcode
     *
     * @return $this
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }
}
