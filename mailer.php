<?php  include "./config.php";

$errors;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $testf->process();
    $mail_data = $testf->theData;
    $errors = $testf->theErrors;

    $message = "Name: ". $mail_data['first-name'] ." ". $mail_data['last-name'];
    $message .= "(". $mail_data['first-furi'] .' '. $mail_data['last-furi'] .")". "\r\n";
    $message .= "Email: ". $mail_data['email']. "\r\n";
    $message .= "Phone No.: ". (!isset($mail_data['phone']) ? "Not provided" : $mail_data['phone']). "\r\n";
    $message .= $mail_data["content"];

    if ($testf->valid) {
        $sent = send_mail($mail_data['inquiry'], $mail_data['email'], $mail_data['subject'], $message);
        if ($sent) {
            echo "Mail Sent";
        } else {
            echo "Could not send";
        }
    }
}
?>

<?php if (isset($errors)): ?>
<?php foreach ($errors as $field => $error): ?>
<h2><?php echo $field ." is ". $error ?></h2>
<?php endforeach; ?>
<?php endif; ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    お名前: <input type="text" name="first-name" value="Simon"><input type="text" name="last-name" value="Leigh"><br>
    フリガナ: <input type="text" name="first-furi" value="サイモン"><input type="text" name="last-furi" value="リー"><br>
    E-mail: <input type="text" name="email" value='abc@123.com'><span><?php $errors['email'] ?></span><br>
    電話: <input type="text" name="phone" value="08013378008"><br>
    主題: <input type="text" name="subject" ><br>
    お問い合わせ内容: <textarea name="content" cols="30" rows="10"></textarea><br>
    お問い合わせ種類: 予約<input type="radio" name="inquiry" value="booking" checked>お問い合わせ<input type="radio" name="inquiry" value="suggestion">
    <input type="submit">
</form>