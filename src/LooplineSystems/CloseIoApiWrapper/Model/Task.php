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
    private $is_complete;

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
     * */

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
            $this->hydrate($data);
        }
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
     */
    public function setAssignedTo($assigned_to)
    {
        $this->assigned_to = $assigned_to;
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
     */
    public function setDueDate($due_date)
    {
        $this->due_date = $due_date;
    }

    /**
     * @return boolean
     */
    public function isComplete()
    {
        return $this->is_complete;
    }

    /**
     * @param boolean $is_complete
     */
    public function setIsComplete($is_complete)
    {
        $this->is_complete = $is_complete;
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
     */
    public function setLeadName($lead_name)
    {
        $this->lead_name = $lead_name;
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
     */
    public function setText($text)
    {
        $this->text = $text;
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
     */
    public function setAssignedToName($assigned_to_name)
    {
        $this->assigned_to_name = $assigned_to_name;
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
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
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
     */
    public function setCreatedByName($created_by_name)
    {
        $this->created_by_name = $created_by_name;
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
     */
    public function setDateUpdated($date_updated)
    {
        $this->date_updated = $date_updated;
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
     */
    public function setId($id)
    {
        $this->id = $id;
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
     */
    public function setLeadId($lead_id)
    {
        $this->lead_id = $lead_id;
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
     */
    public function setOrganizationId($organization_id)
    {
        $this->organization_id = $organization_id;
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
     */
    public function setUpdatedBy($updated_by)
    {
        $this->updated_by = $updated_by;
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
     */
    public function setUpdatedByName($updated_by_name)
    {
        $this->updated_by_name = $updated_by_name;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param mixed $date_created
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
    }
}
