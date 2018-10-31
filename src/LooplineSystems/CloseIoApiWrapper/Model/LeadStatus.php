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

class LeadStatus implements \JsonSerializable
{
    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $organizationId;

    /**
     * LeadStatus constructor.
     *
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
     * @param string $label
     *
     * @return LeadStatus
     */
    public function setLabel($label)
    {
        $this->label = $label;

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
     * @param string $id
     *
     * @return LeadStatus
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $organizationId
     *
     * @return LeadStatus
     */
    public function setOrganizationId($organizationId)
    {
        $this->organizationId = $organizationId;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrganizationId()
    {
        return $this->organizationId;
    }
}
