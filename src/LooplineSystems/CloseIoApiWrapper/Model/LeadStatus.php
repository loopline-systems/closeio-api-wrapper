<?php

namespace LooplineSystems\CloseIoApiWrapper\Model;


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
     * @param array $data
     */
    public function __construct(array $data)
    {
        if ($data) {
            $this->hydrate($data);
        }
    }

    /**
     * @param $label
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
     * @param $id
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
