<?php

class Test {
	private $myVar;
	
	public function __construct() {
		$this->myVar = new Bild();
	}
	
	function __destruct() {
	
	}
	
	public function getBild() {
		return $this->myVar;
	}
}

class Bild {
	private $test = "Hallo";
	
	public function getText() {
		return $this->test;
	}
}

$test = new test();
echo (String)$test->getBild()->getText();