<?php

namespace Ahlin\Bundle\CoreBundle\Tests\Factory;

use Ahlin\Bundle\CoreBundle\Form\DataTransformer\DateTimeToIso8601Transformer;
use DateTime;

/**
 * Class DateTimeToIso8601TransformerTest
 * This class tests that the transformations in both directions are correct
 */
class DateTimeToIso8601TransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests that transformer successfully does a transform
     * @group transformer
     * @dataProvider getValidDataPairs
     * @param $data
     */
    public function testSuccessfulTransform($data)
    {
        $transformer = new DateTimeToIso8601Transformer('test');
        $transformed = $transformer->transform($data['datetime']);
        $this->assertEquals($data['string'], $transformed);
    }

    /**
     * Tests that transformer successfully does a reverse transform
     * @group transformer
     * @dataProvider getValidDataPairs
     * @param $data
     */
    public function testSuccessfulReverseTransform($data)
    {
        $transformer = new DateTimeToIso8601Transformer('test');
        $transformed = $transformer->reverseTransform($data['string']);
        $this->assertEquals($data['datetime'], $transformed);
    }

    /**
     * Tests that transformer throws an exception if invalid value is provided for transformation
     * @group transformer
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     * @dataProvider getInvalidDataPairs
     * @param $data
     */
    public function testFailedTransform($data)
    {
        $transformer = new DateTimeToIso8601Transformer('test');
        $transformer->transform($data['datetime']);
    }

    /**
     * Tests that transformer throws an exception if invalid value is provided for reverse transformation
     * @group transformer
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     * @dataProvider getInvalidDataPairs
     * @param $data
     */
    public function testFailedReverseTransform($data)
    {
        $transformer = new DateTimeToIso8601Transformer('test');
        $transformer->reverseTransform($data['string']);
    }

    // Providers

    static function getValidDataPairs()
    {
        return array(
            array('data' => array('datetime' => new DateTime('1988-12-06T00:00:00-0100'), 'string' => '1988-12-06T00:00:00-0100')),
            array('data' => array('datetime' => new DateTime('2008-07-09T19:00:00+0100'), 'string' => '2008-07-09T19:00:00+0100')),
            array('data' => array('datetime' => new DateTime('2015-02-09T09:00:00+0200'), 'string' => '2015-02-09T09:00:00+0200')),
        );
    }

    static function getInvalidDataPairs()
    {
        return array(
            array('data' => array('datetime' => 'now',  'string' => 'test')),
            array('data' => array('datetime' => time(), 'string' => 2000000000000000000)), # Too much
        );
    }
}
