<link rel="stylesheet" href="form.css">


<form action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
    <div id="name-form">
        <label>お名前:</label>
        <input data-ppForm class="ponies" type="text" name="firstname" data-required value="Simon">
        <input data-ppForm type="text" name="name" data-required value="Leigh">
        <div data-error="required" data-errfor="firstname">Firstname is required please enter</div>
    </div>
    <div id="furigana-form">
        <label>フリガナ:</label>
        <input data-ppForm type="text" name="firstfuri" data-required value="サイモン">
        <input data-ppForm type="text" name="lastfuri" data-required value="リー">
    </div>
    <div id="email-form">
        <label>e-mail:<label>
        <input data-ppForm type="text" name="email" data-required data-valid="email" value='abc@123.com'>
    </div>
    <div id="phone-form">
        <label>電話:</label>
        <input data-ppForm type="text" name="phone" data-required data-valid="phone" value="08013s378008">
    </div>
    <div id="mail-form">
        <label>主題:</label><input data-ppForm type="text" name="subject" data-required ><br>
        <label>お問い合わせ内容:</label><textarea data-ppForm name="content" data-required cols="30" rows="10"></textarea><br>
        <label>お問い合わせ種類:</label>予約<input data-ppForm type="radio" name="inquiry" data-required data-valid="keyval" value="booking" checked>
        <label>お問い合わせ</label><input data-ppForm type="radio" name="inquiry" data-required value="suggestion"><br>
        <label>趣味:</label>スポーツ<input data-ppForm type="checkbox" name="newsletter" checked>本<input type="checkbox" name="newsletter" checked><br>
    </div>
    <div id="address-form">
        <label>〒:</label><input data-ppForm type="text" name="postcode" data-valid="zip" data-required><br>
        <label>都道府県:</label><select data-ppForm name="prefecture" data-required>
                        <?php include "prefecture-form.php"; ?>
                    </select><br>
        <label>市区町村:</label><input data-ppForm type="text" name="city" data-required><br>
        <label>丁目番地:</label><input data-ppForm type="text" name="address" data-required><br>
        <label>マンション・アパート名:</label><input data-ppForm type="house" name="address" data-required><br>
    </div>
    <input type="submit">
</form>