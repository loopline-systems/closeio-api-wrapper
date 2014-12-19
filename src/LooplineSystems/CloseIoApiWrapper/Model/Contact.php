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

class Contact implements \JsonSerializable
{

    use ObjectHydrateHelperTrait;
    use JsonSerializableHelperTrait;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $date_updated;

    /**
     * @var string
     */
    private $created_by;

    /**
     * @var string
     */
    private $id;

    /**
     * @var  string
     */
    private $organization_id;

    /**
     * @var  Url[]
     */
    private $urls;

    /**
     * @var  string
     */
    private $date_created;

    /**
     * @var  string
     */
    private $updated_by;

    /**
     * @var  Phone[]
     */
    private $phones;

    /**
     * @var Email[]
     */
    private $emails;

    /**
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        if ($data) {
            $this->hydrate($data, ['phones', 'emails', 'urls']);
        }
    }

    /**
     * @return Email[]
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param Email $email
     */
    public function addEmail(Email $email)
    {
        $this->emails[] = $email;
    }
    
    /**
     * @param Email[] $emails
     */
    public function setEmails(array $emails)
    {
        $this->emails = $emails;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Phone[]
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * @param Phone $phone
     */
    public function addPhone(Phone $phone)
    {
        $this->phones[] = $phone;
    }
    
    /**
     * @param Phone[] $phones
     */
    public function setPhones(array $phones)
    {
        $this->phones = $phones;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
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
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
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
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return Url[]
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @param $urls
     */
    public function setUrls($urls)
    {
        $this->urls = $urls;
    }
}
