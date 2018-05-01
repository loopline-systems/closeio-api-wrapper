<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace Tests\LooplineSystems\CloseIoApiWrapper\Library;

use Tests\LooplineSystems\CloseIoApiWrapper\Library\Fake\ObjectHydrateHelperDemo;

class ObjectHydrateHelperTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectHydrateHelperDemo
     */
    private $testObject;

    public function setUp()
    {
        $this->testObject = new ObjectHydrateHelperDemo();
    }

    public function testHydrateWithoutData()
    {
        $data = [];

        $this->testObject->hydrate($data);

        $this->assertNull($this->testObject->getFirst());
        $this->assertNull($this->testObject->getSecond());
    }

    public function testHydratePartialData()
    {
        $data = [
            'first' => 10,
        ];

        $this->testObject->hydrate($data);

        $this->assertEquals(10, $this->testObject->getFirst());
        $this->assertNull($this->testObject->getSecond());
    }

    public function testDoNotHydrateFalsyData()
    {
        $this->testObject->hydrate(['first' => false]);
        $this->assertNull($this->testObject->getFirst());

        $this->testObject->hydrate(['first' => 0]);
        $this->assertNull($this->testObject->getFirst());

        $this->testObject->hydrate(['first' => null]);
        $this->assertNull($this->testObject->getFirst());
    }

    public function testHydrateAllData()
    {
        $data = [
            'first' => 10,
            'second' => 'test',
        ];

        $this->testObject->hydrate($data);

        $this->assertEquals(10, $this->testObject->getFirst());
        $this->assertEquals('test', $this->testObject->getSecond());
    }

    public function testNonHydrateNonExistingData()
    {
        $data = [
            'third' => 10,
        ];

        $this->testObject->hydrate($data);

        $this->assertNull($this->testObject->getFirst());
        $this->assertNull($this->testObject->getSecond());
    }

    public function testHydrateWithCustomMappingData()
    {
        $data = [
            'third' => 10,
        ];

        $this->testObject->hydrate($data, [], ['setThird' => 'setFirst']);

        $this->assertEquals(10, $this->testObject->getFirst());
        $this->assertNull($this->testObject->getSecond());
    }
}
