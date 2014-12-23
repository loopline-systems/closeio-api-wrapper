<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Tests;

use LooplineSystems\CloseIoApiWrapper\Model\Email;
use LooplineSystems\CloseIoApiWrapper\Model\Lead;
use LooplineSystems\CloseIoApiWrapper\Model\Opportunity;
use LooplineSystems\CloseIoApiWrapper\Model\Phone;

class LeadTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $data
     * @param $shouldSucceed
     * @param $expectedException
     * @dataProvider testLeadProvider
     */
    public function testHydrateLead($data, $shouldSucceed, $expectedException)
    {
        if ($shouldSucceed){
            $lead = new Lead($data);
            $objectifiedLead = json_decode(json_encode($lead));
            $objectifiedData = json_decode(json_encode($data));

            $this->assertTrue($objectifiedData == $objectifiedLead);
        } else {
            $this->setExpectedException($expectedException);
            new Lead($data);
        }
    }

    /**
     * @param array $data
     * @param bool $shouldSucceed
     * @param string $expectedException
     * @dataProvider fullLeadProvider
     */
    public function testCreateDynamicLead($data)
    {
        $hydratedLead = new Lead($data);
        $dynamicLead = new Lead();

        $dynamicLead->setId($data['id']);
        $dynamicLead->setStatusId($data['status_id']);
        $dynamicLead->setStatusLabel($data['status_label']);
        $dynamicLead->setDescription($data['description']);
        $dynamicLead->setDisplayName($data['display_name']);
        $dynamicLead->setAddresses($data['addresses']);
        $dynamicLead->setOrganization($data['organization']);
        $dynamicLead->setCreatedBy($data['created_by']);
        $dynamicLead->setUrl($data['url']);
        $dynamicLead->setTasks($data['tasks']);
        $dynamicLead->setName($data['name']);
        $dynamicLead->setContacts($data['contacts']);
        $dynamicLead->setDateCreated($data['date_created']);
        $dynamicLead->setCustom($data['custom']);
        $dynamicLead->setUpdatedByName($data['updated_by_name']);
        $dynamicLead->setCreatedByName($data['created_by_name']);
        $dynamicLead->setOpportunities($data['opportunities']);
        $dynamicLead->setHtmlUrl($data['html_url']);
        $dynamicLead->setUpdatedBy($data['updated_by']);
        $dynamicLead->setDateUpdated($data['date_updated']);
        $dynamicLead->setOrganizationId($data['organization_id']);

        $dynamicLead = json_decode(json_encode($dynamicLead));
        $hydratedLead = json_decode(json_encode($hydratedLead));

        $this->assertTrue($hydratedLead == $dynamicLead);
    }

    /**
     * @return array
     */
    public function testLeadProvider()
    {
        return array(
            // good data set 1
            [
                [
                    'name' => 'Test'
                ],
                true, // whether should succeed or not
                null // expected exception
            ],
            // good data set 2
            [
                [
                    'name' => 'Test',
                    'id' => 'ABasflkajflkewjl312309',
                ],
                true, // whether should succeed or not
                null // expected exception
            ],
            // bad data set 1
            [
                [
                    'nane' => 'Test'
                ],
                false, // whether should succeed or not
                'LooplineSystems\CloseIoApiWrapper\Library\Exception\UndefinedMethodException' // expected exception
            ]
        );
    }

    /**
     * @return array
     */
    public function fullLeadProvider()
    {
        return [
            // good data set 3
            [
                [
                    'id' => 'ADFAwfsdfasfklwfa',
                    'status_id' => '4239092092202390',
                    'status_label' => '4239092092202390',
                    'description' => 'Test Description',
                    'display_name' => 'Test Display',
                    'addresses' => [
                        [
                            'city' => 'Test City',
                            'country' => 'de',
                            'zipcode' => '90210',
                            'label' => 'office',
                            'state' => 'Test State',
                            'address_1' => 'Test Street',
                            'address_2' => 'Test Building'
                        ],
                    ],
                    'organization' => 'Test Organization',
                    'created_by' => 'Test Creator',
                    'url' => 'test url',
                    'tasks' => [
                        [
                            'due_date' => '01-01-2016',
                            'text' => 'Test Task Text',
                            'assigned_to' => 'dfaslk2324',
                            'completed' => 'false',
                            'lead_name' => 'Test Lead',
                            'updated_by' => 'dfaslk2324',
                            'date_updated' => '01-01-2015',
                            'created_by' => 'dfaslk2324',
                            'organization_id' => 'AFSl23lkjs0',
                            'updated_by_name' => 'Test User',
                            'assigned_to_name' => 'Test User',
                            'created_by_name' => 'Test User',
                            'lead_id' => 'dsfalkj23',
                            'date_created' => '01-01-2014'
                        ]
                    ],
                    'name' => 'Test Name',
                    'contacts' => [
                        [
                            'name' => 'Test Contact',
                            'title' => 'Test Title',
                            'date_updated' => '01-01-2015',
                            'created_by' => 'dasflkj32lkjs',
                            'organization_id' => 'sdalfkj2l2jk',
                            'phones' => [
                                [
                                    'phone' => '23211434332',
                                    'phone_formatted' => '+49 23 21 1434 332',
                                    'type' => Phone::PHONE_TYPE_OFFICE,
                                ]
                            ],
                            'emails' => [
                                [
                                    'email' => 'testemail@mail.com',
                                    'type' => Email::EMAIL_TYPE_DIRECT                                ]
                            ],
                            'urls' => [
                                [
                                    'url' => 'www.test.com',
                                    'type' => 'office'
                                ]
                            ]
                        ]
                    ],
                    'date_created' => '01-01-2015',
                    'custom' => [
                        'custom_key' => 'custom data'
                    ],
                    'updated_by_name' => 'Test Updater',
                    'created_by_name' => 'Test Creator',
                    'opportunities' => [
                        [
                            'date_created' => '01-01-2014',
                            'note' => 'Test note for opportunity',
                            'lead_name' => 'Test Name',
                            'confidence' => 'Confident',
                            'value_period' => Opportunity::OPPORTUNITY_FREQUENCY_ANNUAL,
                            'created_by' => 'Creator',
                            'date_won' => '01-01-2015',
                            'user_name' => 'Test User',
                            'date_updated' => '01-01-2015',
                            'created_by_name' => 'Test User',
                            'contact_id' => 'Contasdfsalkfjwfawljclkjas',
                            'id' => 'oppsaflklj4kljsdl',
                            'updated_by_name' => 'Test User',
                            'date_lost' => '01-01-2014',
                            'status_type' => '3230923i4902df',
                            'status_id' => '324lsdkjflakj',
                            'organization_id' => 'llk3j4lkjkla',
                            'lead_id' => '32lkjsdalfkj34lkj',
                            'status_label' => Opportunity::OPPORTUNITY_STATUS_WON,
                            'value' => '42342'
                        ]
                    ],
                    'html_url' => 'test.com',
                    'updated_by' => 'test updater',
                    'date_updated' => '01-01-2015',
                    'organization_id' => 'sfklj23kljlsdkfj23l'
                ],
            ],
        ];
    }
}
