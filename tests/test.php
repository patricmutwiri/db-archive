<?php
/**
 * Date: 4/29/20
 * @author Patrick Mutwiri
 * @patric_mutwiri
 */

class SampleTest extends PHPUnit_Framework_TestCase
{

    public function testSample()
    {
        $testName = new Patricmutwiri\Archive\Archive();
        $name = $testName->getName('test');
        $this->assertEquals($name, 'Mutwiri');
    }
}