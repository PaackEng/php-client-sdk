<?php
use Paack\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {
  public function testSetsApiKey(){
    $key = "123";
    $client = new Client($key);
    $this->assertEquals($key, $client->getApiKey());
  }
}
