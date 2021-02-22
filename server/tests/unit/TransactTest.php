<?php

use \PHPUnit\Framework\TestCase;
require_once('index.php');

class TransactTest extends TestCase {

    public function testTransactNegative() {
        $change = getChange(100.00, 50.00);
        $this->assertEquals(-50.00, $change);
    }

    public function testTransactPositive() {
        $change = getChange(7.99, 10.00);
        $denominations = [
            100 => 0,
            50 => 0,
            20 => 0,
            10 => 0,
            5 => 0,
            1 => 2,
            "0.5"=> 0,
            "0.25" => 0,
            "0.1" => 0,
            "0.05" => 0,
            "0.01" => 1,
        ];
        $this->assertEquals($denominations, $change);
    }
}

?>