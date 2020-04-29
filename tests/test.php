<?php
/**
 * Date: 4/29/20
 * @author Patrick Mutwiri
 * @patric_mutwiri
 */

use Patricmutwiri\Archive\Archive;
use PHPUnit\Framework\TestCase;
include "../vendor/autoload.php";

class Tests extends TestCase
{
    public function test()
    {
        $archive = new Archive();
        $confs = $archive->confs();
        print_r($confs);
        $name = $archive->getName('test');
        $this->assertEquals($name, 'Mutwiri');
    }
}