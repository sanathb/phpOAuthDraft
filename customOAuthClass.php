<?php
/*
 * php library for 500px
 * 
 * @author sanath
 * @version 0.0.1

*/

class MyFpx {
	
	function  __construct($client_id = false,$client_secret = false) {
		$this->ClientID = $client_id;
		$this->ClientSecret = $client_secret;		
    }
	
	function GET($url,$params=false) {
		return $this->makeRequest($url,$params,HTTP_GET);
	}
	
	function POST($url,$params=false) {
		return $this->makeRequest($url,$params,HTTP_POST);
	}
	
	function MakeUrl($url,$params) {
		if(!empty($params) && $params) {
			foreach($params as $k=>$v) $kv[] = "$k=$v";
			//$url_params = str_replace(" ","+",implode('&',$kv));
			$url_params = implode('&',$kv);
			$url = trim($url) . '?' . $url_params;
		}
		return $url;
	}
    
    
    private function makeRequest($url,$params=false,$type=HTTP_GET) {
		
		// Populate data for the GET request
		if($type == HTTP_GET) $url = $this->MakeUrl($url,$params);
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL,$url);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		
		if ( isset($_SERVER['HTTP_USER_AGENT']) ) {
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
		} else {
			// Handle the useragent like we are Google Chrome
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.X.Y.Z Safari/525.13.');
		}
		
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		//$acceptLanguage[] = "Accept-Language:" . $this->ClientLanguage;
		//curl_setopt($ch, CURLOPT_HTTPHEADER, $acceptLanguage); 
		
		// Populate the data for POST
		if($type == HTTP_POST) {
			curl_setopt($ch, CURLOPT_POST, 1); 
			if($params) curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		}

		$result=curl_exec($ch);
		$info=curl_getinfo($ch);
		curl_close($ch);
		
		return array('result' => $result,
		             'info' => $info,
					 //'error' => $errors,
					);
	}
    
}

