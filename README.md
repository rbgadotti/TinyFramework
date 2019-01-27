# Tiny Framework #

Framework example (Created by myself)

### Usage ###

```php

$app = new Tiny\App;

// Example 1;
$app->route(['GET', 'POST'], '/json', function($request, $response){
	// echo 'hello route';
	$response->json(array('status' => 'not found'), 404);
});

// Example 2; Same as Example 1;
$app->get('/hello', function($request, $response){
	$response->write('hello route');
});

$app->post('/hello', function($request, $response){
	$response->write('hello route');
});

// Example 3; Set route to all methods;
$app->any('/foo', function($request, $response){
	$response->write('hello route');
});

// Example 4; Route to Ajax;
$app->ajax('GET', '/hello', function($request, $response){
	$response->write('hello route');
});

// Example 5; Group
$app->group('/teste', function() use ($app){

	$app->get('/oi', function($request, $response){ $response->write('Teste->Oi Works!'); });
	$app->get('/hi', function($request, $response){ $response->write('Teste->hi Works!'); });

});

// Example 6; Controller;
Class ExampleController {
	public function sayHello($request, $response){
		$response->write('Hello from exampleController!');	
	}
}
$app->get('/controller', 'ExampleController@sayHello');

$app->run();
```
