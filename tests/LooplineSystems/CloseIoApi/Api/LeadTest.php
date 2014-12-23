<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Tests;

use LooplineSystems\CloseIoApiWrapper\Model\Lead;
use LooplineSystems\CloseIoApiWrapper\Model\Opportunity;

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
                            'country' => 'de'
                        ],
                    ],
                    'organization' => 'Test Organization',
                    'created_by' => 'Test Creator',
                    'url' => 'test url',
                    'tasks' => [
                        [
                            'text' => 'Test Task Text'
                        ]
                    ],
                    'name' => 'Test Name',
                    'contacts' => [
                        [
                            'name' => 'Test Contact',
                            'title' => 'Test Title',
                            'phones' => [
                                [
                                    'phone' => '23211434332323',
                                    'type' => 'office'
                                ]
                            ],
                            'emails' => [
                                [
                                    'email' => 'testemail@mail.com',
                                    'type' => 'office'
                                ]
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
