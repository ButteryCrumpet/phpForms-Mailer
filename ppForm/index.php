<?php 
session_start();

include 'functions.php';

$path = strtok($_SERVER["REQUEST_URI"],'?');
$form = getNameConfirmFromURL($path);

if ($form['confirmation']) {
    displayConfirmation($form['name']);
} else if ($form['mail']) {
    formToMail($form['name']);
} else {
    displayAutoForm($form['name']);
}