<?php

namespace Paack\Resources;

class OrderRequest {
	public $packages = [];
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

	public function setPickupAddress($address, $postal_code, $city, $country){
		$this->pickup_address = $this->createAddress($address, $postal_code, $city, $y);
	}

	public function setDeliveryAddress($address, $postal_code, $city, $country){
		$this->delivery_address = $this->createAddress($address, $postal_code, $city, $country);
	}

	public function setPackages($packages){
		$this->packages = $packages;
	}

	private function createAddress($address, $postal_code, $city, $country){
		return array(
					 "address"     => $address,
					 "postal_code" => $postal_code,
					 "city"        => $city,
					 "country"     => $country
				);
	}


	public function setRetailerOrderNumber($number){
		$this->retailer_order_number = $number;
	}

	public function setDeliveryWindow($start_time, $end_time){
		$this->start_time = $start_time;
		$this->end_time   = $end_time;
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
		$params = [];
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

		if(isset($this->packages)){
			$packages = array();
			foreach ($this->packages as $package) {
				$packages[] = [
					'width'  => $package->width,
					'height' => $package->height,
					'length' => $package->length,
					'weight' => $package->weight,
					'description' => $package->description,
					'units' => $package->units,
					'barcode' => $package->barcode
				];
			}
			$params['packages'] = $packages;
		}

		if(isset($this->start_time) && isset($this->end_time)){
			$time_format = "Y-m-d\TH:i:s\Z";
			$utc_timezone = new \DateTimeZone("Etc/UTC");
			$start_time = $this->start_time;
			$start_time->setTimezone($utc_timezone);
			$end_time = $this->end_time;
			$end_time->setTimezone($utc_timezone);

			$params['delivery_window'] = [
				'start_time' => $start_time->format($time_format),
				'end_time' => $end_time->format($time_format)
			];
		}

		return $params;
	}
}
