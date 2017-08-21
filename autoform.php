<?php

include_once "./domLib/dom.utils.php";
include_once "./formLib/form.classes.php";
include_once "./formLib/form.auto.php";

function displayAutoForm($template, $config_file) {
    $config = parse_ini_file($config_file, true);
    $form = new AutoForm($template, $config);
    $form->render();
}