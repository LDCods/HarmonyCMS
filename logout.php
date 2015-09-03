<?php
include('include/init.php');
session_destroy();
$ref = $_SERVER['HTTP_REFERER'];
/*header('Location: '.$ref.'');
exit();*/
?>

<meta http-equiv="refresh" content="0; URL=<?php echo $ref; ?>">

