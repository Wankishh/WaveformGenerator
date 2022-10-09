<?php

require __DIR__.'/vendor/autoload.php';

header("Content-type: application/json");

echo json_encode([
	'message' => "You shall not pass :))",
], JSON_THROW_ON_ERROR);
die;


