<?

$valid = preg_match('/^\(?\+?([0-9]{1,4})\)?[-\. ]?(\d{3})[-\. ]?([0-9]{7})$/', 'asaf');
//trigger_error("uhoh", E_USER_ERROR)
?>

<h1><?php echo $valid?>