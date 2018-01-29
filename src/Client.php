<?php
namespace Paack;
use Paack\Resources\Order;
use Paack\Resources\Store;
use Paack\Resources\OrderRequest;
use Http\Client\Common\HttpMethodsClient as HttpClient;
use Http\Discovery\HttpClientDiscovery as HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery as MessageFactoryDiscovery;

class Client {
  private $apiKey;
  private $base_uri;
  protected $client;

  public function __construct($apiKey){
    $this->apiKey = $apiKey;
    $this->setHttpClient();
  }

  public function setHttpClient(HttpClient $client = null){
    if ($client === null) {
        $client = new HttpClient(
            HttpClientDiscovery::find(),
            MessageFactoryDiscovery::find()
        );
    }
    $this->client = $client;
    return $this;
  }

  public function getHttpClient(){
    return $this->client;
  }


  public function getOrders($filters=[]) {
    $url = $this->base_uri.'orders?api='.$this->apiKey;
    $response = $this->getHttpClient()->send('GET',$url);
    $json_response = json_decode($response->getBody()->getContents());
    $orders = [];
    foreach($json_response->data as $order)
      $orders[] = new Order($order);

    return $orders;
  }

  public function getStores(){
    $url = $this->base_uri.'stores?api='.$this->apiKey;
    $headers = array();
    $headers['Content-Type'] = 'application/json';
    $response = $this->getHttpClient()->send('GET', $url);
    $json_response = json_decode($response->getBody()->getContents());
    $stores = [];
    foreach($json_response->data as $store)
      $stores[] = new Store($store);

    return $stores;
  }

  public function createOrder($order_request){
    if(!($order_request instanceOf OrderRequest)){
      throw new \InvalidArgumentException('Please use order request');
    }

    $url = $this->base_uri.'orders';
    $params = $order_request->getParams();
    $params['api'] = $this->apiKey;
    $headers = array();
    $headers['Content-Type'] = 'application/json';
    $response = $this->getHttpClient()->send('POST', $url, $headers, json_encode($params));
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
