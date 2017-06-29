<?php

/**
	 * @author 		Rafael Gadotti Bachovas
	 * @link      https://github.com/rbgadotti/tiny-framework
	 */

	namespace Tiny;

	use Tiny\Router;

	Class App {

		public $router;

		public function __construct(){
			$this->router = new Router();
		}

		public function __call($name, $arguments){
			if(method_exists($this->getRouter(), $name))
				return call_user_func_array(array($this->getRouter(), $name), $arguments);
		}

		public function getRouter(){
			return $this->router;
		}

		public function beforeInit(){}
		public function onInit(){}

		public function run(){
			$this->beforeInit();
			$this->getRouter()->doRouting();
			$this->onInit();
		}

	}