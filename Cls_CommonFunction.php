<?php

class CommonFunctions
{
	var $APIURL;
	function config($opt)
	{
		switch($opt)
		{
			case "APIURL":
			$this->APIURL="http://127.0.0.1:8080"; 
			//$this->APIURL="http://ec2-54-187-178-241.us-west-2.compute.amazonaws.com:8080";
			return $this->APIURL;
		}
	}
	function Log($text, $level='i', $file='logs'){
    switch (strtolower($level)) 
    {
        case 'e':
        case 'error':
            $level='ERROR';
            break;
        case 'i':
        case 'info':
            $level='INFO';
            break;
        case 'd':
        case 'debug':
            $level='DEBUG';
            break;
        default:
            $level='INFO';
    }
    error_log(date("[Y-m-d H:i:s]")."\t[".$level."]\t[".basename(__FILE__)."]\t".$text."\n", 3, $file);
}
	function isMobileDevice(){
		$aMobileUA = array(
			'/iphone/i' => 'iPhone', 
			'/ipod/i' => 'iPod', 
			'/ipad/i' => 'iPad', 
			'/android/i' => 'Android', 
			'/blackberry/i' => 'BlackBerry', 
			'/webos/i' => 'Mobile'
		);

		//Return true if Mobile User Agent is detected
		foreach($aMobileUA as $sMobileKey => $sMobileOS){
			if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
				return true;
			}
		}
		//Otherwise return false..  
		return false;
	}	
	function SendMail($Content=""){
		echo "Mailed ".$Content."<br>";
		
	 }
	function SendSMS($To,$Text){
		echo "Texted".$To." ".$Text;
	 }
	 
	function CreateOTP($count=4){
		 $otp_code = strtoupper(bin2hex(openssl_random_pseudo_bytes($count)));
		 return  $otp_code." ";
		
	 }
	 

}
?>