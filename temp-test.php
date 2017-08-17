<?php
include_once "./templator/templator-classes.php";
include_once "./formLib/auto-form.php";


$test = new Template("mailer.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = new AutoForm('autotest', $test);
    $form->process();
    $vals = $form->getToReplace();
    $test->replace($vals);
    print_r($form->theErrors);
}

$test->render();
exit();
?>