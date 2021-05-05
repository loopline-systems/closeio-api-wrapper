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

class Task implements \JsonSerializable
{
    use JsonSerializableHelperTrait;
    use ObjectHydrateHelperTrait;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $due_date;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $assigned_to;

    /**
     * @var bool
     */
    private $completed;

    /**
     * @var string
     * */
    private $lead_name;

    /**
     * @var string
     * */
    private $updated_by;

    /**
     * @var string
     * */
    private $date_updated;

    /**
     * @var string
     * */
    private $created_by;

    /**
     * @var string
     * */
    private $organization_id;

    /**
     * @var string
     * */
    private $updated_by_name;

    /**
     * @var string
     * */
    private $assigned_to_name;

    /**
     * @var string
     * */
    private $created_by_name;

    /**
     * @var string
     * */
    private $id;

    /**
     * @var string
     */
    private $lead_id;

    /**
     * @var string
     */
    private $date_created;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $view;

    /**
     * @param array $data
     *
     * @throws InvalidParamException
     */
    public function __construct($data = null)
    {
        if ($data) {
            $this->hydrate($data, [], ['setIsComplete' => 'setCompleted']);
        }
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

    /**
     * @return string
     */
    public function getAssignedTo()
    {
        return $this->assigned_to;
    }

    /**
     * @param string $assigned_to
     *
     * @return $this
     */
    public function setAssignedTo($assigned_to)
    {
        $this->assigned_to = $assigned_to;

        return $this;
    }

    /**
     * @return string
     */
    public function getDueDate()
    {
        return $this->due_date;
    }

    /**
     * @param string $due_date
     *
     * @return $this
     */
    public function setDueDate($due_date)
    {
        $this->due_date = $due_date;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCompleted()
    {
        return $this->completed;
    }

    /**
     * @param bool $is_complete
     *
     * @return $this
     */
    public function setCompleted($is_complete)
    {
        $this->completed = $is_complete;

        return $this;
    }

    /**
     * @return string
     */
    public function getLeadName()
    {
        return $this->lead_name;
    }

    /**
     * @param string $lead_name
     *
     * @return $this
     */
    public function setLeadName($lead_name)
    {
        $this->lead_name = $lead_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getAssignedToName()
    {
        return $this->assigned_to_name;
    }

    /**
     * @param string $assigned_to_name
     *
     * @return $this
     */
    public function setAssignedToName($assigned_to_name)
    {
        $this->assigned_to_name = $assigned_to_name;

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
     * @return $this
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedByName()
    {
        return $this->created_by_name;
    }

    /**
     * @param string $created_by_name
     *
     * @return $this
     */
    public function setCreatedByName($created_by_name)
    {
        $this->created_by_name = $created_by_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }

    /**
     * @param string $date_updated
     *
     * @return $this
     */
    public function setDateUpdated($date_updated)
    {
        $this->date_updated = $date_updated;

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
     * @param string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return $this
     */
    public function setLeadId($lead_id)
    {
        $this->lead_id = $lead_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrganizationId()
    {
        return $this->organization_id;
    }

    /**
     * @param string $organization_id
     *
     * @return $this
     */
    public function setOrganizationId($organization_id)
    {
        $this->organization_id = $organization_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * @param string $updated_by
     *
     * @return $this
     */
    public function setUpdatedBy($updated_by)
    {
        $this->updated_by = $updated_by;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedByName()
    {
        return $this->updated_by_name;
    }

    /**
     * @param string $updated_by_name
     *
     * @return $this
     */
    public function setUpdatedByName($updated_by_name)
    {
        $this->updated_by_name = $updated_by_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param string $date_created
     *
     * @return $this
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;

        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     *
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param string $view
     *
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }
}
