
<form  data-ppFormTag="mailer" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
    <div id="name-form">
        <label>お名前:</label>
        <input data-ppForm type="text" name="firstname" data-required value="Simon">
        <input data-ppForm type="text" name="lastname" data-required value="Leigh">
        <div class="em" data-error="required|firstname" >Firstname is required please enter</div>
        <div class="em" data-error="required|lastname" >Lastname is required please enter</div>
    </div>
    <div id="furigana-form">
        <label>フリガナ:</label>
        <input data-ppForm type="text" name="firstfuri" data-required value="サイモン">
        <input data-ppForm type="text" name="lastfuri" data-required value="リー">
        <div class="em" data-error="required|firstfuri" >Required please enter</div>
        <div class="em" data-error="invalid|firstfuri" >Invalid please enter valid one</div>
        <div class="em" data-error="required|lastfuri" >Required please enter</div>
        <div class="em" data-error="invalid|lastfuri" >Invalid please enter valid one</div>
    </div>
    <div id="email-form">
        <label>e-mail:<label>
        <input data-ppForm type="text" name="email" data-required data-valid="email" value='abc@123.com'>
        <div class="em" data-error="required|email" >Required please enter</div>
        <div class="em" data-error="invalid|email" >Invalid please enter valid one</div>
    </div>
    <div id="phone-form">
        <label>電話:</label>
        <input data-ppForm type="text" name="phone" data-required data-valid="phone" value="08013378008">
        <div class="em" data-error="required|phone" >Required please enter</div>
        <div class="em" data-error="invalid|phone" >Invalid please enter valid one</div>
    </div>
    <div id="mail-form">
        <label>主題:</label><input data-ppForm type="text" name="subject" data-required ><br>
        <div class="em" data-error="required|subject" >Required please enter</div>
        <label>お問い合わせ内容:</label><textarea data-ppForm name="content" data-required cols="30" rows="10"></textarea><br>
        <div class="em" data-error="required|content" >Required please enter</div>
        <label>お問い合わせ種類:</label>予約<input data-ppForm type="radio" name="inquiry" data-required value="booking" checked>
        <label>お問い合わせ</label><input data-ppForm type="radio" name="inquiry" data-required value="suggestion"><br>
        <div class="em" data-error="required|inquiry" >Required please enter</div>
        <label>趣味: </label>スポーツ<input data-ppForm type="checkbox" name="newsletter[]" value="sports" checked="checked">
        本<input data-required data-ppForm type="checkbox" value="books" name="newsletter[]" checked><br>
    </div>
    <div id="address-form">
        <label>〒:</label><input data-ppForm type="text" name="zip" data-valid="zip" data-required><br>
        <div class="em" data-error="required|zip" >Required please enter</div>
        <div class="em" data-error="invalid|zip" >Invalid please enter valid one</div>
        <label>都道府県:</label><select data-ppForm name="prefecture" data-required>
                        <?php include "prefecture-form.php"; ?>
                    </select><br>
        <div class="em" data-error="required|prefecture" >Required please enter</div>
        <label>市区町村:</label><input data-ppForm type="text" name="city" data-required><br>
        <div class="em" data-error="required|city" >Required please enter</div>
        <label>丁目番地:</label><input data-ppForm type="text" name="address" data-required><br>
        <div class="em" data-error="required|address" >Required please enter</div>
        <label>マンション・アパート名:</label><input data-ppForm type="text" name="house" data-required><br>
        <div class="em" data-error="required|house" >Required please enter</div>
    </div>
    <input type="submit">
</form>