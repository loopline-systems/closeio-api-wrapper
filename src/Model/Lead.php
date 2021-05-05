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
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidUrlException;
use LooplineSystems\CloseIoApiWrapper\Library\JsonSerializableHelperTrait;
use LooplineSystems\CloseIoApiWrapper\Library\ObjectHydrateHelperTrait;
use LooplineSystems\CloseIoApiWrapper\Library\UrlUtils;

class Lead implements \JsonSerializable
{
    use JsonSerializableHelperTrait;
    use ObjectHydrateHelperTrait;
    const LEAD_STATUS_POTENTIAL = 'Potential';
    const LEAD_STATUS_BAD_FIT = 'Bad Fit';
    const LEAD_STATUS_QUALIFIED = 'Qualified';
    const LEAD_STATUS_CUSTOMER = 'Customer';

    /**
     * @var string
     */
    private $id;

    /*
     * @var string
     */
    private $status_id;

    /**
     * @var string
     */
    private $status;

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
     * @var string
     */
    private $name;

    /**
     * @var Contact[]
     */
    private $contacts;

    /**
     * @var string
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
     *
     * @throws InvalidParamException
     */
    public function __construct(array $data = null)
    {
        if ($data) {
            // custom is not a class and should be set separately
            if (isset($data['custom'])) {
                $this->setCustom($data['custom']);
                unset($data['custom']);
            }

            // child objects
            $nestedObjects = ['contacts', 'tasks', 'addresses', 'opportunities', 'custom'];

            $this->hydrate($data, $nestedObjects);
        }
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
     * @return Address[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @return $this
     */
    public function addAddress(Address $address)
    {
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * @param Address[] $addresses
     *
     * @return $this
     */
    public function setAddresses(array $addresses)
    {
        $this->addresses = $addresses;

        return $this;
    }

    /**
     * @return Contact[]
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @return $this
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * @param Contact[] $contacts
     *
     * @return $this
     */
    public function setContacts(array $contacts)
    {
        $this->contacts = $contacts;

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
     * @return array
     */
    public function getCustom()
    {
        return $this->custom;
    }

    /**
     * @param array $custom
     *
     * @return $this
     */
    public function setCustom($custom)
    {
        $this->custom = $custom;

        return $this;
    }

    /**
     * Sets the value of a custom field. By passing a `null` value the field
     * will be unset from the lead.
     *
     * @param string $name  The name or ID of the field
     * @param mixed  $value The value
     *
     * @return $this
     */
    public function setCustomField(string $name, $value)
    {
        $this->custom[$name] = $value;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     *
     * @return $this
     */
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;

        return $this;
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
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     *
     * @return $this
     */
    public function setOpportunities(array $opportunities)
    {
        $this->opportunities = $opportunities;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param string $organization
     *
     * @return $this
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;

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
     * @param string $status
     *
     * @return $this
     */
    public function setStatusId($status)
    {
        $this->status_id = $status;

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
     */
    public function setStatus($status)
    {
        $this->status = $status;

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
     * @param string $status_label
     *
     * @return $this
     */
    public function setStatusLabel($status_label)
    {
        $this->status_label = $status_label;

        return $this;
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
     *
     * @return $this
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;

        return $this;
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
     *
     * @return $this
     *
     * @throws InvalidUrlException
     */
    public function setUrl($url)
    {
        if (!UrlUtils::validate($url)) {
            throw new InvalidUrlException('"' . $url . '" is not a valid URL');
        }

        $this->url = $url;

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
    public function getHtmlUrl()
    {
        return $this->html_url;
    }

    /**
     * @param string $html_url
     *
     * @return $this
     */
    public function setHtmlUrl($html_url)
    {
        $this->html_url = $html_url;

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

    public function __set(string $name, $value)
    {
        if (strpos($name, 'custom.') === 0) {
            @trigger_error('Setting a custom field using the $object->$fieldName syntax is deprecated since version 0.8. Use the setCustomField() method instead.', \E_USER_DEPRECATED);

            $this->custom[substr($name, 7)] = $value;
        } else {
            $this->$name = $value;
        }
    }
}
