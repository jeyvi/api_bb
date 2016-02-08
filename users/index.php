<?php 

include "../index.php";

if (authorize())
{
	echo file_get_contents('users.json');
}