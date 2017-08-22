<?php 
session_start();
include_once "./formLib/autoform.php" 
?>

<html>
    <head>
    <link rel="stylesheet" href="form.css">
    </head>
</html>
<body>
    <h1>Test</h1>
    <p>Lets try it oot</p>
    <?php displayAutoForm("testForm", "./testForm/form.php", "mail.php", "./testForm/config.ini", "./testForm/kakunin.php"); ?>
</body>