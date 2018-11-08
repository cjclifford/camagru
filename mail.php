<?php

error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

if (mail("cliffordcuan@gmail.com", "Test Subject", "Test Content"))
	echo "success";
else
	echo "failure";