<?php

/**
	 * @author 		Rafael Gadotti Bachovas
	 * @link      https://github.com/rbgadotti/tiny-framework
	 */

	namespace Tiny;

	Class Request {

		public $requestUri;
		public $requestMethod;
		public $queryString;
		public $httpXRequestedWith;
		public $body = array();

		public function __construct(){
			$this->setRequestData();		
		}

		public function setRequestData(){

			$this->setRequestUri();
			$this->setRequestMethod();
			$this->setQueryString();
			$this->setHttpXRequestedWith();

		}

		public function setRequestUri($val = null){
			$this->requestUri = !is_null($val) ? $val : $_SERVER['REQUEST_URI'];
		}

		public function setRequestMethod($val = null){
			$this->requestMethod = !is_null($val) ? $val : $_SERVER['REQUEST_METHOD'];
		}

		public function setQueryString($val = null){
			$this->queryString = !is_null($val) && is_array($val) ? http_build_query($val) : $_SERVER['QUERY_STRING'];	
		}

		public function setHttpXRequestedWith($val = null){
			$this->httpXRequestedWith = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : $val;	
		}

		public function isAjax(){
			return strtolower($this->httpXRequestedWith) == 'xmlhttprequest';
		}

		public function getRequestUri(){
			return $this->requestUri;
		}

		public function getRequestMethod(){
			return $this->requestMethod;
		}

		public function body(){
			return array();
		}

		public function setBody($data, $value = null){

			if(is_array($data) && is_null($value)){
				$this->body = $data;
			}else{
				$this->body[$data] = $value;
			}

		}
		
	}