
<form action="mailer.php" method="post">
Name: <input type="text" name="name" value="Simon"><br>
Phone: <input type="text" name="phone" value="08055627260"><br>
E-mail: <input type="text" name="email" value='abc@123.com'><br>
Send To: 1<input type="radio" name="sendTo" value="email1" checked>2<input type="radio" name="sendTo" value="email2">
<input type="submit">
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
<?php include_once "mailer-classes.php"; ?>
<?php
    $a = new GenericField('name', true);
    $b = new PhoneNoField('phone', true); 
    $c = new EmailField('email', true);
    $args = array("email1"=>"1@cake.com", "email2"=>"2@cake.com");
    $d = new KeyValueField('sendTo', true, $args);
?>

<h1><?php echo $a->theData(); ?><span style="color: red;"><?php echo $a->error() ?></span></h1>
<h1><?php echo $b->theData(); ?><span style="color: red;"><?php echo $b->error() ?></span></h1>
<h1><?php echo $c->theData(); ?><span style="color: red;"><?php echo $c->error() ?></span></h1>
<h1><?php echo $d->theData(); ?><span style="color: red;"><?php echo $d->error() ?></span></h1>

<?php endif; ?>