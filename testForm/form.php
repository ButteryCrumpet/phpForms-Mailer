<form  data-ppFormTag="mailer" action="/" method="post">
    <div id="name-form">
        <label>お名前:</label>
        <input data-ppForm type="text" name="firstname" data-required value="Simon">
        <input data-ppForm type="text" name="lastname" data-required value="Leigh">
        <div class="em" data-error="firstname" ></div>
        <div class="em" data-error="lastname" ></div>
    </div>
    <div id="furigana-form">
        <label>フリガナ:</label>
        <input data-ppForm type="text" name="firstfuri" data-required value="サイモン">
        <input data-ppForm type="text" name="lastfuri" data-required value="リー">
        <div class="em" data-error="firstfuri" ></div>
        <div class="em" data-error="lastfuri" ></div>
    </div>
    <div id="email-form">
        <label>e-mail:<label>
        <input data-ppForm type="text" name="email" data-required data-valid="email" value='abc@123.com'>
        <div class="em" data-error="email" ></div>
    </div>
    <div id="phone-form">
        <label>電話:</label>
        <input data-ppForm type="text" name="phone" data-required data-valid="phone" value="08013378008">
        <div class="em" data-error="phone" ></div>
    </div>
    <div id="mail-form">
        <label>主題:</label><input data-ppForm type="text" name="subject" data-required ><br>
        <div class="em" data-error="subject" ></div>
        <label>お問い合わせ内容:</label><textarea data-ppForm name="content" data-required cols="30" rows="10"></textarea><br>
        <div class="em" data-error="content" ></div>
        <label>お問い合わせ種類:</label>予約<input data-ppForm type="radio" name="inquiry" data-required value="booking" checked>
        <label>お問い合わせ</label><input data-ppForm type="radio" name="inquiry" data-required value="suggestion"><br>
        <div class="em" data-error="inquiry" ></div>
        <label>趣味: </label>
        スポーツ<input data-ppForm type="checkbox" name="newsletter[]" value="sports" checked="checked">
        本<input data-required data-ppForm type="checkbox" value="books" name="newsletter[]" checked><br>
    </div>
    <div id="address-form">
        <label>〒:</label><input data-ppForm type="text" name="zip" data-valid="zip" data-required><br>
        <div class="em" data-error="zip" ></div>
        <label>都道府県:</label><select data-ppForm name="prefecture" data-required>
                        <?php include "prefecture-form.php"; ?>
                    </select><br>
        <div class="em" data-error="prefecture" ></div>
        <label>市区町村:</label><input data-ppForm type="text" name="city" data-required><br>
        <div class="em" data-error="city" ></div>
        <label>丁目番地:</label><input data-ppForm type="text" name="address" data-required><br>
        <div class="em" data-error="address" ></div>
        <label>マンション・アパート名:</label><input data-ppForm type="text" name="house" data-required><br>
        <div class="em" data-error="house" ></div>
    </div>
    <input type="submit">
</form>