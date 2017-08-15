isset - abstract - data via url params
<form action="mailer.php" method="post">
First Name: <input type="text" name="first-name" value="Simon"> Last Name: <input type="text" name="last-name" value="Leigh"><br>
Furigana: <input type="text" name="first-furi" value="サイモン"> Last Name: <input type="text" name="last-furi" value="リー"><br>
E-mail: <input type="text" name="email" value='abc@123.com'><br>
Phone: <input type="text" name="phone" value="08013378008"><br>
Title: <input type="text" name="title" ><br>
Content: <textarea name="content" cols="30" rows="10"></textarea><br>
Inquiry: Booking<input type="radio" name="inquiry" value="booking" checked>Suggestion<input type="radio" name="sendTo" value="suggestion">
<input type="submit">
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
<?php include_once "./formLib/form-classes.php"; ?>
<?php
    $first_name = new GenericField('first-name', true);
    $last_name = new GenericField('last-name', true);
    $first_furi = new KanaField('first-furi', true);
    $last_furi = new KanaField('last-furi', true);
    $email = new EmailField('email', true);
    $phone = new PhoneNoField('phone');
    $title = new GenericField('title', true);
    $content = new GenericField('content', true);
    $args = array("booking"=>"booking@cake.com", "suggestion"=>"suggestion@cake.com");
    $mail = new KeyValueField('inquiry', true, $args);

    $fields = array($first_name, $last_name, $first_furi, $last_furi, $email, $phone, $title, $content, $mail);
    $form = new Form($fields);
    $form->process();
?>

<?php foreach ($form->fields as $name => $field): ?>
    <?php if($field->valid) : ?>
        <h1><?php echo $name . ': ' . $field->value; ?></h1>
    <?php else: ?>
        <h1><?php echo $name . ': ' . $field->error; ?>
    <?php endif; ?>
<?php endforeach; ?>

<?php endif; ?>