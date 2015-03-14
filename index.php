<?php

require 'vendor/autoload.php';

//slim init
$app = new \Slim\Slim();

//twig init
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);

$app->get('/', function () use ($twig) {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: text/javascript; charset=UTF-8');
    echo $twig->render('tester.tmpl');
});

$app->post('/testerpost', function () use ($app) {
    $url = $app->request()->post("url");
    $input = $app->request()->post("input");
    
    $result = sendpost($input,$url);
    echo $result;
});

function sendpost($data,$url) {
	//curl less method
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/json\r\n",
			'method'  => 'POST',
			'content' => $data,
		),
	);

	$context  = stream_context_create($options);
	return $result = @file_get_contents($url, false, $context);
}

$app->run();