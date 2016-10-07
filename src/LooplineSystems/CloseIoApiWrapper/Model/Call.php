<?php

namespace LooplineSystems\CloseIoApiWrapper\Model;

use LooplineSystems\CloseIoApiWrapper\Library\JsonSerializableHelperTrait;
use LooplineSystems\CloseIoApiWrapper\Library\ObjectHydrateHelperTrait;

class Call implements \JsonSerializable
{
    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

    /**
     * @var string
     */
    private $lead_id;

    /**
     * @var string
     */
    private $contact_id;

    /**
     * @var string
     */
    private $created_by;

    /**
     * @var string
     */
    private $user_id;

    /**
     * @var string
     */
    private $direction;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $note;

    /**
     * @var int
     */
    private $duration;

    /**
     * @var string
     */
    private $phone;

    /**
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        if ($data) {
            $this->hydrate($data, []);
        }
    }

    /**
     * @return string
     */
    public function getLeadId()
    {
        return $this->lead_id;
    }

    /**
     * @param string $lead_id
     *
     * @return Call
     */
    public function setLeadId($lead_id)
    {
        $this->lead_id = $lead_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getContactId()
    {
        return $this->contact_id;
    }

    /**
     * @param string $contact_id
     *
     * @return Call
     */
    public function setContactId($contact_id)
    {
        $this->contact_id = $contact_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param string $created_by
     *
     * @return Call
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param string $user_id
     *
     * @return Call
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     *
     * @return Call
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Call
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     *
     * @return Call
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     *
     * @return Call
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return Call
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }
}
