<?php

require('form.php');

if (isset($_POST)) {
	$form = new Form($_POST['first-name'], $_POST['last-name'], $_POST['telephone'], $_POST['email'], $_POST['message']);
	print 'The form successfully sent!';
}
