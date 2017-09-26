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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="/ppForm/formJS/toggle.js"></script>

<h2>Test Form template includes <?php echo $cake ?></h2>

<div class="ppTParent" data-pptoggle="test">Parent</div>
<div class="ppTParent" data-pptoggle="test2">Parent2</div>
<div class="ppTChild" data-pptoggle="test">Child1</div>
<div class="ppTChild" data-pptoggle="test">Child2</div>
<div class="ppTChild" data-pptoggle="test2">P2 Child1</div>
