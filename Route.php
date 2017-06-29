<?php

  /**
   * @author    Rafael Gadotti Bachovas
   * @link      https://github.com/rbgadotti/tiny-framework
   */

  namespace Tiny;

	class Route {

		private $ALLOWED_METHODS = array('GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS');

		private $method;
		private $url;
		private $callback;
		private $isAjax;

		public function __construct($method = 'GET', $url = null, $callback = null, $isAjax = false){

      $this->setMethod($method);
      $this->setUrl($url);
      $this->setCallback($callback);
			$this->setAjax($isAjax);

		}

    public function setMethod($method){

      if(in_array($method, $this->ALLOWED_METHODS)){
        $this->method = $method;
      }else{
        throw new Exception('Route method not permited');
      }

    }

    public function setUrl($url){

      if(!is_null($url)){
        $this->url = $url;        
      }else{
        throw new Exception('Route url can\'t be null');
      }

    }

    public function setCallback($callback){
      
      if(!is_null($callback)){

        if(is_callable($callback)){
          $this->callback = $callback;         
        }elseif(is_string($callback)){

          if(count(explode('@', $callback) === 2)){
            $this->callback = $callback;
          }else{
            throw new Exception('Invalid reference to callback');
          }

        }

      }else{
        throw new Exception('Route callback needs to be callable'); 
      }

    }

    public function setAjax($isAjax){
      $this->isAjax = !!$isAjax;
    }

		public function getMethod(){ return $this->method; }
		public function getUrl(){ return $this->url; }
		public function getCallback(){ return $this->callback; }
		public function isAjax(){ return $this->isAjax; }

	}
