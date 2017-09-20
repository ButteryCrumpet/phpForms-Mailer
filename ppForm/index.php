<?php 
session_start();

include "formLib/dom.utils.php";
include "formLib/form.classes.php";
include "formLib/form.auto.php";
include 'config.php';

function displayAutoForm() {
    $template = 'templates/form.php';
    $config_file = 'config/form.ini';

    $config = parse_ini_file($config_file, true);
    $form = new AutoForm("form", $template, $config);
    if ($form->checkValid()) {
        $form->onValidAction();
    } else {
        $form->render();
    }
}

displayAutoForm();
