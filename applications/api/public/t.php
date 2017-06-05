<?php

header('HTTP/1.1 404 Not Found');
setcookie("TestCookie","SomeValue");
header("X-Sample-Test: foo");
header('Content-type: text/plain');

var_dump(http_response_code());


