<?php

namespace Paack\Resources;

class OrderRequest {

	public function setRecipientEmail($email){
		$this->email = $email;
	}

	public function setRecipientPhone($phone){
		$this->phone = $phone;
	}

	public function setRecipientName($name){
		$this->name = $name;
	}

	public function setRetailerStoreId($store_id){
		$this->retailer_store_id = $store_id;
	}

	public function setStoreId($store_id){
		$this->store_id = $store_id;
	}

	public function setPickupAddress(address, postal_code, city, country){
		$this->pickup_address = createAddress(address, postal_code, city, country)
	}

	public function setDeliveryAddress(address, postal_code, city, country){
		$this->delivery_address = createAddress(address, postal_code, city, country);	
	}

	private function createAddress(address, postal_code, city, country){
		return array(
					 "address"     => address,
					 "postal_code" => postal_code,
					 "city"        => city,
					 "country"     => country
				);
	}

	public function setRetailerOrderNumber($number){
		$this->retailer_order_number = $number;
	}

	public function isValid(){
		if(!isset($this->retailer_order_number)){
			return false;
		}

		if(!isset($this->delivery_address)){
			return false;
		}

		if(!(isset($this->store_id) || isset($this->retailer_store_id) || isset($this->pickup_address))){
			return false;
		}

		if(!(isset($this->email) || isset($this->phone) )){
			return false;
		}
	}

	public function getParams(){
		$params = []
		if(isset($this->email)){
			$params['email'] = $this->email;
		}
		if(isset($this->name)){
			$params['name'] = $this->name;
		}
		if(isset($this->phone)){
			$params['phone'] = $this->phone;
		}
		if(isset($this->retailer_store_id)){
			$params['retailer_store_id'] = $this->retailer_store_id;
		}else{
			$params['store_id'] = $this->store_id;
		}

		if(isset($this->retailer_order_number)){
			$params['retailer_order_number'] = $this->retailer_order_number;
		}

		if(isset($this->pickup_address)){
			$params['pickup_address'] = [
				'address' => $this->pickup_address['address'],
				'postal_code' => $this->pickup_address['postal_code'],
				'city' => $this->pickup_address['city'],
				'country' => $this->pickup_address['country']
			];
		}

		if(isset($this->delivery_address)){
			$params['delivery_address'] = [
				'address' => $this->delivery_address['address'],
				'postal_code' => $this->delivery_address['postal_code'],
				'city' => $this->delivery_address['city'],
				'country' => $this->delivery_address['country']
			];
		}
		return $params;
	}
}