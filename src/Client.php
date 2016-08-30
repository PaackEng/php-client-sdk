<?php
namespace Paack;

class Client extends \GuzzleHttp\Client {
  private $apiKey;
  public function __construct($apiKey){
    $this->apiKey = $apiKey;
    parent::__construct(
      ['base_url' => ['https://api.paack.co/api/public/{version}/orders', ['version' => 'v1']]]
    );
  }
  public function getApiKey(){
    return $this->apiKey;
  }
}
