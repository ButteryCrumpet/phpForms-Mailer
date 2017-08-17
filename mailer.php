<?php include_once "./domtest.php" ?>
<?php //include_once "./temp-test.php" ?>
<?php //include "./mailer-functions.php" ?>


<form action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
    お名前: <input type="text" name="firstname" data-required value="Simon"><input type="text" name="name" data-required value="Leigh"><br>
    フリガナ: <input type="text" name="firstfuri" data-required value="サイモン"><input type="text" name="lastfuri" data-required value="リー"><br>
    e-mail: <input type="text" name="email" data-required data-valid="email" value='abc@123.com'><br>
    電話: <input type="text" name="phone" data-required data-valid="phone" value="08013378008"><br>
    主題: <input type="text" name="subject" data-required ><br>
    お問い合わせ内容: <textarea name="content" data-required cols="30" rows="10"></textarea><br>
    お問い合わせ種類: 予約<input type="radio" name="inquiry" data-required value="booking" checked>
    お問い合わせ<input type="radio" name="inquiry" data-required value="suggestion"><br>
    Apply to newsletter: <input type="checkbox" name="newsletter" checked>
    Post Code: <input type="text" name="postcode" data-required" postcode"><br>
    Prefecture: <select name="prefecture" data-required>
                    <?php include "prefecture-form.php"; ?>
                </select><br>
    Address: <input type="text" name="address" data-required><br>
    <input type="submit">
</form>