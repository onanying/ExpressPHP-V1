<?php

header('HTTP/1.1 404 Not Found');
setcookie("TestCookie","SomeValue");
header("X-Sample-Test: foo");
header('Content-type: text/plain');

var_dump(http_response_code());

?>

<html>
<body>

<?php
// 发送哪些报头？
var_dump(headers_list());
?>

</body>
</html>
