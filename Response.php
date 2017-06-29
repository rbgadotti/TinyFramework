<?php

/**
	 * @author 		Rafael Gadotti Bachovas
	 * @link      https://github.com/rbgadotti/tiny-framework
	 */

	namespace Tiny;

	Class Response {

		public function json($arr = array(), $statusCode = 200){

			header('Content-Type: application/json');
			http_response_code($statusCode);
			echo json_encode($arr);

		}

		public function view($viewName, $statusCode = 200){

			http_response_code($statusCode);
			include($viewName);

		}

		public function write($content, $statusCode = 200){

			http_response_code($statusCode);
			echo $content;

		}

	}