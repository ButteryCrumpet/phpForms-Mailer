<?php 
session_start();
include_once "./formLib/autoform.php";
$form = displayAutoForm("testForm");
?>

<html>
    <head>
    <link rel="stylesheet" href="form.css">
    </head>
</html>
<body>
    <h1>Test</h1>
    <p>Lets try it oot</p>
    <?php $form->render() ?>
</body>