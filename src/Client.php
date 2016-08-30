<?php

class Client extends \GuzzleHttp\Client {
  private $api;
  public function __construct($api){
    parent::__construct(
      ['base_url' => ['https://api.paack.co/api/public/{version}/orders', ['version' => 'v1']]]
    );
  }
}
