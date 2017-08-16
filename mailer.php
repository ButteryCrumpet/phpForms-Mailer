<?php //include "./temp-test.php" ?>
<?php include "./mailer-functions.php" ?>


<form action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
    お名前: <input type="text" name="first-name" value="Simon"><input type="text" name="last-name" value="Leigh"><br>
    フリガナ: <input type="text" name="first-furi" value="サイモン"><input type="text" name="last-furi" value="リー"><br>
    [@no-cake]: <input type="text" name="email" value='abc@123.com'><span><?php $errors['email'] ?></span><br>
    電話: <input type="text" name="phone" value="08013378008"><br>
    主題: <input type="text" name="subject" ><br>
    お問い合わせ内容: <textarea name="content" cols="30" rows="10"></textarea><br>
    お問い合わせ種類: 予約<input type="radio" name="inquiry" value="booking" checked>お問い合わせ<input type="radio" name="inquiry" value="suggestion">
    <input type="submit">
</form>