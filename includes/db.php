<?php
   // connect to database
	$connection = mysqli_connect('localhost','root','','cms');
	
	 //define other constants
	define('SITENAME', 'HELLO', false);
	define('SITESUBTITLE', '&nbsp;&nbsp;&nbsp;Shooting Craps in Sin City', false);
	define('POSTSPERPAGE', 10);
	define('AUTHOR', 'Rushikesh jadhav', false);
	define('TIMEOUT', 120);
	define('HASHCOST', 12);
	define('TZ', 'Asia/Kolkata');

?>
