<?php

use Paack\Builder;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase {
  public function testSetsApiKey(){
    $builder = new Builder();
    $client = $builder->setProduction();
    $this->assertEquals($client->getBaseUri(), "https://api.paack.co/api/public/v1/");
  }
}
