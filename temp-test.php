<?php
include_once "./templator/templator-classes.php";

$values = array(
    "no-cake" => "cake",
);

$test = new Template("mailer.php", $values);
$out = $test->render();

echo $out;
exit();
?>