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

class Lead implements \JsonSerializable
{

    const LEAD_STATUS_POTENTIAL = 'Potential';
    const LEAD_STATUS_BAD_FIT = 'Bad Fit';
    const LEAD_STATUS_QUALIFIED = 'Qualified';
    const LEAD_STATUS_CUSTOMER = 'Customer';

    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

    /**
     * @var int
     */
    private $id;

    /*
     * @var string
     */
    private $status_id;

    /*
     * @var string
     */
    private $status_label;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $display_name;

    /**
     * @var Address[]
     */
    private $addresses;

    /**
     * @var string
     */
    private $organization;

    /**
     * @var string
     */
    private $created_by;

    /**
     * @var string
     */
    private $url;

    /**
     * @var Task[]
     */
    private $tasks;

    /**
     * @var Address[]
     */
    private $name;

    /**
     * @var Contact[]
     */
    private $contacts;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var array
     */
    private $custom;

    /**
     * @var string
     */
    private $updated_by_name;

    /**
     * @var string
     */
    private $created_by_name;

    /**
     * @var Opportunity[]
     */
    private $opportunities;

    /**
     * @var string
     */
    private $html_url;

    /**
     * @var string
     */
    private $updated_by;

    /**
     * @var string
     */
    private $date_updated;

    /**
     * @var string
     */
    private $organization_id;

    /**
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        if ($data) {
            // NON OBJECTS
            $nested_objects = ['contacts', 'tasks', 'addresses', 'opportunities', 'custom'];

            $this->hydrate($data, $nested_objects);

            // OBJECTS
            // contacts
            if (!empty($data['contacts'])) {
                $contacts = array();
                foreach ($data['contacts'] as $contact_raw) {
                    $contacts[] = new Contact($contact_raw);
                }
                $this->setContacts($contacts);
            }
            // tasks
            if (!empty($data['tasks'])) {
                $tasks = array();
                foreach ($data['tasks'] as $task_raw) {
                    $tasks[] = new Task($task_raw);
                }
                $this->setTasks($tasks);
            }
            // addresses
            if (!empty($data['addresses'])) {
                $addresses = array();
                foreach ($data['addresses'] as $address_raw) {
                    $addresses[] = new Address($address_raw);
                }
                $this->setAddresses($addresses);
            }
            // opportunities
            if (!empty($data['opportunities'])) {
                $opportunities = array();
                foreach ($data['opportunities'] as $opportunity_raw) {
                    $opportunities[] = new Opportunity($opportunity_raw);
                }
                $this->setOpportunities($opportunities);
            }
            // custom
            if (!empty($data['custom'])) {
                $custom_fields = array();
                foreach ($data['custom'] as $key => $custom_raw) {
                    $custom_fields[$key][] = $custom_raw;
                }
                $this->setCustom($custom_fields);
            }
        }
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Address[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param Address $address
     */
    public function addAddress($address)
    {
        $this->addresses[] = $address;
    }
    
    /**
     * @param Address[] $addresses
     */
    public function setAddresses(array $addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * @return Contact[]
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param Contact $contact
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;
    }
    
    /**
     * @param Contact[] $contacts
     */
    public function setContacts(array $contacts)
    {
        $this->contacts = $contacts;
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
     * @return array
     */
    public function getCustom()
    {
        return $this->custom;
    }

    /**
     * @param array $custom
     */
    public function setCustom($custom)
    {
        $this->custom = $custom;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param \DateTime $date_created
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * @param string $display_name
     */
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Opportunity[]
     */
    public function getOpportunities()
    {
        return $this->opportunities;
    }

    /**
     * @param Opportunity[] $opportunities
     */
    public function setOpportunities($opportunities)
    {
        $this->opportunities = $opportunities;
    }

    /**
     * @return string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param $organization
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
    }

    /**
     * @return string
     */
    public function getStatusId()
    {
        return $this->status_id;
    }

    /**
     * @param string $status
     */
    public function setStatusId($status)
    {
        $this->status_id = $status;
    }

    /**
     * @return string
     */
    public function getStatusLabel()
    {
        return $this->status_label;
    }

    /**
     * @param string $status_label
     */
    public function setStatusLabel($status_label)
    {
        $this->status_label = $status_label;
    }

    /**
     * @return Task[]
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param Task[] $tasks
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
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
    public function getHtmlUrl()
    {
        return $this->html_url;
    }

    /**
     * @param string $html_url
     */
    public function setHtmlUrl($html_url)
    {
        $this->html_url = $html_url;
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


}
