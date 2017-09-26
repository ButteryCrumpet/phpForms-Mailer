<?php
mb_language('ja');
mb_internal_encoding('UTF-8');
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__));

//necessary
define('CONFIRM_URI', 'confirmation');
define('MAIL_URI', 'mail');
define('SECURE_KEY', '-pp1234');
define('URI_404', '/404.php');

const FORMS = array(
    'testForm',
    'testForm2',
);
