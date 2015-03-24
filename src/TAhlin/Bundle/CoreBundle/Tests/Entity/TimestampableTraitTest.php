<?php

namespace TAhlin\Bundle\CoreBundle\Tests\Entity;

use DateTime;
use PHPUnit_Framework_Error;
use TAhlin\Bundle\CoreBundle\Entity\TimestampableTrait;

/**
 * Class Time (mock) which uses timestampable behavior
 */
class Time
{
    use TimestampableTrait;
}

/**
 * Class AbstractTimestampableTest tests behavior of timestampable trait
 */
class AbstractTimestampableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests time methods that they set up valid properties for the object
     * @group time
     * @dataProvider getValidData
     * @param $data
     */
    public function testTimeMethodsWithValidData($data)
    {
        $entity = new Time();

        $date = $data['time_create'];
        $entity->setTimeCreate($date);
        $this->assertEquals($date, $entity->getTimeCreate());

        $date = $data['time_update'];
        $entity->setTimeUpdate($date);
        $this->assertEquals($date, $entity->getTimeUpdate());

        $date = $data['time_delete'];
        $entity->setTimeDelete($date);
        $this->assertEquals($date, $entity->getTimeDelete());
    }

    /**
     * Tests create time method that it raises and error if invalid data is passed in
     * @group time
     * @dataProvider getInvalidData
     * @expectedException PHPUnit_Framework_Error
     * @param $data
     */
    public function testTimeCreateMethodWithInvalidData($data)
    {
        $entity = new Time();

        $date = $data['time_create'];
        $entity->setTimeCreate($date);
        $this->assertEquals($date, $entity->getTimeCreate());
    }

    /**
     * Tests update time method that it raises and error if invalid data is passed in
     * @group time
     * @dataProvider getInvalidData
     * @expectedException PHPUnit_Framework_Error
     * @param $data
     */
    public function testTimeUpdateMethodWithInvalidData($data)
    {
        $entity = new Time();

        $date = $data['time_update'];
        $entity->setTimeUpdate($date);
        $this->assertEquals($date, $entity->getTimeUpdate());
    }

    /**
     * Tests delete time method that it raises and error if invalid data is passed in
     * @group time
     * @dataProvider getInvalidData
     * @expectedException PHPUnit_Framework_Error
     * @param $data
     */
    public function testTimeDeleteMethodWithInvalidData($data)
    {
        $entity = new Time();

        $date = $data['time_delete'];
        $entity->setTimeDelete($date);
        $this->assertEquals($date, $entity->getTimeDelete());
    }

    // Data providers

    static function getValidData()
    {
        return array(
            array('data' => array('time_create' => new DateTime('2015-01-01 10:00:00'), 'time_update' => new DateTime('2015-01-01 11:00:00'), 'time_delete' => new DateTime('2015-01-01 11:00:00'))),
            array('data' => array('time_create' => new DateTime('2015-02-02 10:00:00'), 'time_update' => new DateTime('2015-02-02 11:00:00'), 'time_delete' => new DateTime('2015-02-02 11:00:00'))),
        );
    }

    static function getInvalidData()
    {
        return array(
            array('data' => array('time_create' => ' ', 'time_update' => 'test',    'time_delete' => 'wrong')),
            array('data' => array('time_create' => 1,   'time_update' => null,      'time_delete' => '2015-02-02 11:00:00')),
        );
    }
}