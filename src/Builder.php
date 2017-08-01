<?php

namespace Paack;  

class Builder {
  private $client;

  public function __construct(){
    $this->client = new Client("NO KEY");
  }

  public function setProduction($bool=true){
    if($bool){
      $this->client->setBaseUri("https://api.paack.co/api/public/v1/");
    }else{
      $this->client->setBaseUri("https://test.api.paack.co/api/public/v1/");
    }
    return $this->client;
  }

  public function setApiKey($apiKey){
    $this->client->setApiKey($apiKey);
    return $this->client;
  }

  public function setBaseUri($base_uri){
    $this->client->setBaseUri($base_uri);
    return $this->client;
  }
}