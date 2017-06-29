<?php

  /**
   * @author    Rafael Gadotti Bachovas
   * @link      https://github.com/rbgadotti/tiny-framework
   */

  namespace Tiny;

  use Tiny\Route;
  use Tiny\Request;
  use Tiny\Response;

	class Router {

		private $SIMULATED_REQUEST = array();
		private $routes = array();
		private $group = null;

		public function __construct(){}

		public function route($method, $url, $callback, $ajax = false){

			$url = is_null($this->group) ? $url : $this->group . $url;

			if(is_array($method)){
				foreach($method as $m){
					$this->routes[] = new Route($m, $url, $callback, $ajax);
				}
				return true;
			}else{
				return $this->routes[] = new Route($method, $url, $callback, $ajax);
			}
		}

		public function get($url, $callback){
			return $this->route('GET', $url, $callback);
		}

		public function post($url, $callback){
			return $this->route('POST', $url, $callback);
		}

		public function patch($url, $callback){
			return $this->route('PATCH', $url, $callback);
		}

		public function put($url, $callback){
			return $this->route('PUT', $url, $callback);
		}

		public function delete($url, $callback){
			return $this->route('DELETE', $url, $callback);
		}

		public function options($url, $callback){
			return $this->route('OPTIONS', $url, $callback);
		}

		public function any($url, $callback){
			$methods = array('GET', 'POST', 'PATCH', 'PUT', 'DELETE', 'OPTIONS');
			return $this->route($methods, $url, $callback);
		}

		public function ajax($method, $url, $callback){
			return $this->route($method, $url, $callback, true);
		}

		public function group($groupUrl, $callback){

			$this->group = $groupUrl;
			$callback();
			$this->group = null;

		}

		public function doRouting(){

			$request = new Request;
			$response = new Response;

			foreach($this->routes as $route){

				$pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($route->getUrl())) . "$@D";
				$requestQueryParams = array();

				if($request->getRequestMethod() == $route->getMethod() && preg_match($pattern, $request->getRequestUri(), $requestQueryParams) && $request->isAjax() === $route->isAjax()) {

					// Remove the first match
					array_shift($requestQueryParams);
					$this->callRoute($request, $response, $route, $requestQueryParams);

				}

			}

		}

		private function callRoute($request, $response, $route, $requestQueryParams = array()){

			foreach($requestQueryParams as $paramKey => $paramValue){
				$request->setBody($paramKey, $paramValue);
			}

			// Call the callback with the matched positions as params
			if(is_callable($route->getCallback())){

				return call_user_func_array($route->getCallback(), array($request, $response));

			}elseif(is_string($route->getCallback())){

				$className = explode('@', $route->getCallback())[0];
				$methodName = explode('@', $route->getCallback())[1];
				$obj = new $className();
				
				if(method_exists($obj, $methodName)){
					return call_user_func_array(array($obj, $methodName), array($request, $response));
				}else{
					throw new Exception('Object '. $className . ' has no method called '. $methodName);
				}

			}

		}

	}