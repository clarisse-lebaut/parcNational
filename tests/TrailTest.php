<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/Trails.php';

class TrailTest extends TestCase{
    public function test_get_all_trails(){
        $bddObject = new ConnectBDD();
        $trailsObject = new Trails();
        $trails = $trailsObject->get_all_trails($bddObject->bdd);
        $this->assertGreaterThan(0, count($trails));
    }
}

