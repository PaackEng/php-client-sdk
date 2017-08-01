<?php

use Paack\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {

  public function testSetsApiKey(){
    $key = "123";
    $client = new Client($key);
    $this->assertEquals($key, $client->getApiKey());
  }

  public function testSetsBaseUrl(){
  	$url = "123";
  	$client = new Client("api");
  	$client->setBaseUri($url);
  	$this->assertEquals($client->getBaseUri(), $url);
  }

  public function testLoadsOrders() {
    $client = new Client("a16bcd2d965c45da1ceeb84194f30e964adb4f61");
    $client->setBaseUri("http://localhost:3000/api/public/v1/");
    $data = $client->getOrders();
    $this->assertEquals($data, []);
  }
}
