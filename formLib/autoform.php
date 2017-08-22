<?php

include_once $_SERVER['DOCUMENT_ROOT']."/domLib/dom.utils.php";
include_once "form.classes.php";
include_once "form.auto.php";

function displayAutoForm($name, $template, $action, $config_file, $confirm_template) {
    $config = parse_ini_file($config_file, true);
    $form = new AutoForm($name, $template, $action, $config, $confirm_template);
    $form->render();
}