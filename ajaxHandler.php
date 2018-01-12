<?php


session_start();

if(isset($_POST['OPT'])){$OPT=$_POST['OPT'];}else{$OPT="NONE";}
if(isset($_POST['DATA'])){$DATA=$_POST['DATA'];}else{$DATA=new stdClass();}
echo $OPT;	

switch($OPT)
{
	case 'SETSESSION':
		$_SESSION[$DATA[0]]=$DATA[1];
		print_r($_SESSION);
	break;
}


?>