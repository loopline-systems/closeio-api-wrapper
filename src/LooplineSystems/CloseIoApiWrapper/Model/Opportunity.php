<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Model;

use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Library\JsonSerializableHelperTrait;
use LooplineSystems\CloseIoApiWrapper\Library\ObjectHydrateHelperTrait;

class Opportunity implements \JsonSerializable
{

    const OPPORTUNITY_FREQUENCY_ONE_OFF = 'one_time';
    const OPPORTUNITY_FREQUENCY_MONTHLY = 'monthly';
    const OPPORTUNITY_FREQUENCY_ANNUAL = 'annual';

    const OPPORTUNITY_STATUS_ACTIVE = 'active';
    const OPPORTUNITY_STATUS_WON = 'won';
    const OPPORTUNITY_STATUS_LOST = 'lost';

    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

    /**
     * @var string
     */
    private $date_created;

    /**
     * @var string
     */
    private $lead_name;

    /**
     * @var int
     */
    private $confidence;

    /**
     * @var string
     */
    private $value_period;

    /**
     * @var string
     */
    private $created_by;

    /**
     * @var string
     */
    private $note;

    /**
     * @var string
     */
    private $date_won;

    /**
     * @var string
     */
    private $user_name;

    /**
     * @var string
     */
    private $date_updated;

    /**
     * @var string
     */
    private $created_by_name;

    /**
     * @var string
     */
    private $contact_id;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $user_id;

    /**
     * @var string
     */
    private $updated_by_name;

    /**
     * @var string
     */
    private $date_lost;

    /**
     * @var string
     */
    private $status_type;

    /**
     * @var string
     */
    private $updated_by;

    /**
     * @var string
     */
    private $status_id;

    /**
     * @var string
     */
    private $organization_id;

    /**
     * @var string
     */
    private $lead_id;

    /**
     * @var string
     */
    private $status_label;

    /**
     * @var string
     */
    private $value;

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
    public function getConfidence()
    {
        return $this->confidence;
    }

    /**
     * @param int $confidence
     * @return $this
     * @throws InvalidParamException
     */
    public function setConfidence($confidence)
    {
        if (is_int($confidence)) {
            $this->confidence = $confidence;
        } else {
            throw new InvalidParamException('Opportunity confidence must be of type int');
        }

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
     * @return \DateTime
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

    /**
     * @return string
     */
    public function getDateWon()
    {
        return $this->date_won;
    }

    /**
     * @param $date_won
     * @return $this
     */
    public function setDateWon($date_won)
    {
        $this->date_won = $date_won;

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
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param $note
     * @return $this
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param $user_name
     * @return $this
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getValuePeriod()
    {
        return $this->value_period;
    }

    /**
     * @param $value_period
     * @return $this
     */
    public function setValuePeriod($value_period)
    {
        $this->value_period = $value_period;

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
     * @param $contact_id
     * @return $this
     */
    public function setContactId($contact_id)
    {
        $this->contact_id = $contact_id;

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
    public function getDateLost()
    {
        return $this->date_lost;
    }

    /**
     * @param $date_lost
     * @return $this
     */
    public function setDateLost($date_lost)
    {
        $this->date_lost = $date_lost;

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
    public function getStatusId()
    {
        return $this->status_id;
    }

    /**
     * @param $status_id
     * @return $this
     */
    public function setStatusId($status_id)
    {
        $this->status_id = $status_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatusLabel()
    {
        return $this->status_label;
    }

    /**
     * @param $status_label
     * @return $this
     */
    public function setStatusLabel($status_label)
    {
        $this->status_label = $status_label;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatusType()
    {
        return $this->status_type;
    }

    /**
     * @param $status_type
     * @return $this
     */
    public function setStatusType($status_type)
    {
        $this->status_type = $status_type;

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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param $user_id
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
