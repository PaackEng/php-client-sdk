<?php
namespace Paack;
use Paack\Resources\Order;
use Paack\Resources\OrderRequest;

class Client extends \GuzzleHttp\Client {
  private $apiKey;
  private $base_uri;
  public function __construct($apiKey){
    $this->apiKey = $apiKey;
    parent::__construct();
  }

  public function getOrders($filters=[]) {
    $url = $this->base_uri.'orders?api='.$this->apiKey;
    $response = $this->request('GET', $url);
    $json_response = json_decode($response->getBody()->getContents());
    $orders = [];
    foreach($json_response->data as $order)
      $orders[] = new Order($order);

    return $orders;
  }

  public function createOrder($order_request){
    if(!($order_request instanceOf OrderRequest)){
      throw new \InvalidArgumentException('Please use order request');
    }

    $url = $this->base_uri.'orders';
    $params = $order_request->getParams();
    $params['api'] = $this->apiKey;
    $response = $this->request('POST', $url, ['json' => $params]);

    $json_response = json_decode($response->getBody()->getContents());
    return new Order($json_response->data);
  }

  public function getApiKey() {
    return $this->apiKey;
  }

  public function setApiKey($apiKey) {
    return $this->apiKey = $apiKey;
  }

  public function getBaseUri(){
    return $this->base_uri;
  }

  public function setBaseUri($base_uri){
    $this->base_uri = $base_uri;
  }
}
