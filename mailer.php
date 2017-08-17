<?php include_once "./autoform.php" ?>
<link rel="stylesheet" href="form.css">

<form action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
    <label>お名前:</label><input type="text" name="firstname" data-required value="Simon"><input type="text" name="name" data-required value="Leigh"><br>
    <label>フリガナ:</label><input type="text" name="firstfuri" data-required value="サイモン"><input type="text" name="lastfuri" data-required value="リー"><br>
    <label>e-mail:<label><input type="text" name="email" data-required data-valid="email" value='abc@123.com'><br>
    <label>電話:</label><input type="text" name="phone" data-required data-valid="phone" value="08013378008"><br>
    <label>主題:</label><input type="text" name="subject" data-required ><br>
    <label>お問い合わせ内容:</label><textarea name="content" data-required cols="30" rows="10"></textarea><br>
    <label>お問い合わせ種類:</label>予約<input type="radio" name="inquiry" data-required value="booking" checked>
    <label>お問い合わせ</label><input type="radio" name="inquiry" data-required value="suggestion"><br>
    <label>Apply to newsletter:</label><input type="checkbox" name="newsletter" checked><br>
    <label>Post Code:</label><input type="text" name="postcode" data-required" postcode"><br>
    <label>Prefecture:</label><select name="prefecture" data-required>
                    <?php include "prefecture-form.php"; ?>
                </select><br>
    <label>Address:</label><input type="text" name="address" data-required><br>
    <input type="submit">
</form>