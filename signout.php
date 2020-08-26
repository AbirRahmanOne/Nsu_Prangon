<?php session_start(); ?>
<?php require_once('helpers/function.php'); ?>

<?php
	session_destroy();
	redirect_to('login.php');
?>