<?php
/**
 * Date: 4/29/20
 * @author Patrick Mutwiri
 * @patric_mutwiri
 */

use Patricmutwiri\Archive\Archive;
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    public function testSample()
    {
        $testName = new Archive();
        $name = (new Archive())->getName('test');
        $this->assertEquals($name, 'Mutwiri');
    }
}