<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Tests;

use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\Model\Address;
use LooplineSystems\CloseIoApiWrapper\Model\Contact;
use LooplineSystems\CloseIoApiWrapper\Model\Email;
use LooplineSystems\CloseIoApiWrapper\Model\Lead;
use LooplineSystems\CloseIoApiWrapper\Api\LeadApi;
use LooplineSystems\CloseIoApiWrapper\Model\Phone;

class LeadsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LeadApi
     */
    private $leadsApi;

    /**
     * @var CloseIoApiWrapper
     */
    private $closeIoApiWrapper;

    /**
     * @description construct test case and assign new closeIoApiWrapper and leadsApi to it
     */
    public function __construct()
    {
        $this->closeIoApiWrapper = new CloseIoApiWrapper('test');
        $this->leadsApi = $this->closeIoApiWrapper->getLeadApi();
    }

    /**
     * @description test adding a lead from test data contained in configuration file
     * @param $testData
     * 
     * @dataProvider getTestData
     */
    public function testAddLeadFromData($testData)
    {
        // create lead
        $lead = new Lead($testData);
        $response = $this->leadsApi->addLead($lead);

        // check if request is successful
        $this->assertTrue($response->getReturnCode() === 200);

        // check if new lead can be created from returned data and name matches added lead
        $createdLead = new Lead($response->getData());
        $this->assertTrue($lead->getName() === $createdLead->getName());
    }

    /**
     * @description test adding a new lead that is created in the method
     * @depends testAddLeadFromData
     */
    public function testAddLeadDynamic()
    {
        // create lead
        $lead = new Lead();
        $lead->setName('Dynamic Test');
        $lead->setDescription('Dynamic lead test description');
        $lead->setUrl('www.dynamic-lead-test.com');

        // address
        $address = new Address();
        $address->setCountry('DE');
        $address->setCity('Berlin');
        $address->setAddress1('Main Street');
        $address->setAddress2('Mitte');

        // contacts
        $contact = new Contact();
        $contact->setName('Dynamic Testcontact');
        $contact->setTitle('Dynamic Contact Test Title');

        // emails
        $email = new Email();
        $email->setEmail('testcontactemail@dynamic-lead-test.com');
        $email->setType('work');
        $contact->addEmail($email);

        // phones
        $phone = new Phone();
        $phone->setPhone('01244349656');
        $phone->setType('mobile');
        $contact->addPhone($phone);

        $lead->addAddress($address);
        $lead->addContact($contact);

        $response = $this->leadsApi->addLead($lead);

        // check if request is successful
        $this->assertTrue($response->getReturnCode() === 200);

        // check if new lead can be created from returned data and matches added lead
        $createdLead = new Lead($response->getData());
        $this->assertTrue($lead->getName() === $createdLead->getName());
        $this->assertTrue($lead->getContacts()[0]->getName() === $createdLead->getContacts()[0]->getName());
    }

    /**
     * test getting all available leads
     * @depends testAddLeadFromData
     */
    public function testGetAllLeads()
    {
        /**
         * @var Lead[] $response
         */
        $response = $this->leadsApi->getAllLeads();
        $this->assertTrue($response[0]->getId() !== null);
    }

    /**
     * @description test getting a single lead by specific id
     * @depends testAddLeadFromData
     */
    public function testGetLead()
    {
        // needs to be updated to match real lead
        $id = 'lead_LCNbXu7npeiAFl0LqalbWzXsuvLk1tzy6vSQyl1zssB';

        /** @var Lead $response */
        $response = $this->leadsApi->getLead($id);

        // check if lead id matches requested one
        $this->assertTrue($response->getId() === $id);
    }

    /**
     * @return array
     */
    public function getTestData()
    {
        $testData = [
            "name" => "Test Company",
            "email" => "info@testcompany.com",
            "url" => "www.test-company-site.com",
            "contacts" => [
                "name" => "Tester Contactsson",
                "title" => "Chief Tester",
                "phones" => [
                    "phone" => "00353861245532",
                    "type" => "mobile"
                ],
                "emails" => [
                    "email" => "t.contactsson@testcompany.com",
                    "type" => "office"
                ]
            ]
        ];
        
        //data providers must be arrays of arrays
        return [$testData];
    }
}
