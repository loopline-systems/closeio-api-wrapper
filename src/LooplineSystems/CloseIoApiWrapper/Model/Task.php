<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Model;

use LooplineSystems\CloseIoApiWrapper\Library\ObjectHydrateHelperTrait;
use LooplineSystems\CloseIoApiWrapper\Library\JsonSerializableHelperTrait;

class Task implements \JsonSerializable
{
    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

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
     * @param array $data
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
     * @param $assigned_to
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
     * @param $due_date
     * @return $this
     */
    public function setDueDate($due_date)
    {
        $this->due_date = $due_date;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isCompleted()
    {
        return $this->completed;
    }

    /**
     * @param $is_complete
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
     * @param $lead_name
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
     * @param $text
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
     * @param $assigned_to_name
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
     * @param $created_by
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
     * @param $created_by_name
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
     * @param $date_updated
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
     * @param $id
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
     * @param $lead_id
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
     * @param $organization_id
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
     * @param $updated_by
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
     * @param $updated_by_name
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
     * @param $date_created
     * @return $this
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;

        return $this;
    }
}
