<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Api;

use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Library\Api\AbstractApi;
use LooplineSystems\CloseIoApiWrapper\Library\Curl\Curl;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Model\Contact;

class ContactApi extends AbstractApi
{
    const NAME = 'ContactApi';

    /**
     * {@inheritdoc}
     */
    protected function initUrls()
    {
        $this->urls = [
            'get-contacts' => '/contact/',
            'add-contact' => '/contact/',
            'get-contact' => '/contact/[:id]/',
            'update-contact' => '/contact/[:id]/',
            'delete-contact' => '/contact/[:id]/',
        ];
    }

    /**
     * @return Contact[]
     */
    public function getAllContacts()
    {
        /** @var Contact[] $contacts */
        $contacts = [];

        $apiRequest = $this->prepareRequest('get-contacts');

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200) {
            $rawData = $result->getData()[CloseIoResponse::GET_RESPONSE_DATA_KEY];

            foreach ($rawData as $contact) {
                $contacts[] = new Contact($contact);
            }
        }

        return $contacts;
    }

    /**
     * @param $id
     * @return Contact
     * @throws ResourceNotFoundException
     */
    public function getContact($id)
    {
        $apiRequest = $this->prepareRequest('get-contact', null, ['id' => $id]);

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200 && ($result->getData() !== null)) {
            $contact = new Contact($result->getData());
        } else {
            throw new ResourceNotFoundException();
        }

        return $contact;
    }

    /**
     * @param Contact $contact
     * @return CloseIoResponse
     */
    public function addContact(Contact $contact)
    {
        $contact = json_encode($contact);
        $apiRequest = $this->prepareRequest('add-contact', $contact);

        return $this->triggerPost($apiRequest);
    }

    /**
     * @param Contact $contact
     * @return Contact|string
     * @throws InvalidParamException
     * @throws ResourceNotFoundException
     */
    public function updateContact(Contact $contact)
    {
        // check if contact has id
        if ($contact->getId() == null) {
            throw new InvalidParamException('When updating a contact you must provide the contact ID');
        }
        // remove id from contact since it won't be part of the patch data
        $id = $contact->getId();
        $contact->setId(null);

        $contact = json_encode($contact);
        $apiRequest = $this->prepareRequest('update-contact', $contact, ['id' => $id]);
        $response = $this->triggerPut($apiRequest);

        // return Contact object if successful
        if ($response->getReturnCode() == 200 && ($response->getData() !== null)) {
            $contact = new Contact($response->getData());
        } else {
            throw new ResourceNotFoundException();
        }

        return $contact;
    }

    /**
     * @param $id
     * @return CloseIoResponse
     * @throws ResourceNotFoundException
     */
    public function deleteContact($id)
    {
        $apiRequest = $this->prepareRequest('delete-contact', null, ['id' => $id]);

        /** @var CloseIoResponse $result */
        $result = $this->triggerDelete($apiRequest);

        if ($result->getReturnCode() == 200) {
            return $result;
        } else {
            throw new ResourceNotFoundException();
        }
    }

    /**
     * @param Curl $curl
     */
    public function setCurl($curl)
    {
        $this->curl = $curl;
    }
}
