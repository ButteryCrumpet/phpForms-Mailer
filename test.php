<?php 
$cake = "cake";
$mails = array();
$mails[] = 'i1711025@gl.aiu.ac.jp';
$mails[] = 'sleigh564@hotmail.com';
$mails[] = 'sleigh@produce-pro.co.jp';

foreach ($mails as $mail) {
    $atIndex = strrpos($mail, "@");
    $domain = substr($mail, $atIndex+1);
    if (checkdnsrr($domain,"MX")) {
        echo "MX true<br>";
    } else {
        echo 'MX false<br>';
    }
    if (checkdnsrr($domain,"A")) {
        echo "A true<br>";
    } else {
        echo 'A false<br>';
    }
}

?>
<h2>Test Form template includes <?php echo $cake ?></h2>