<?php
include "./templator/templator-classes.php";

$values = array(
    "no-cake" => "cake",
    "self" =>  "hi"
);

$test = new Template("mailer.php", $values);
$out = $test->render();

echo $out;

?>