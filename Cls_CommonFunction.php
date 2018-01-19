<?php

class CommonFunctions
{
	var $APIURL;
	function config($opt){
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
	 

	function CurlSendPostRequest($url,$request){
       
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array("Authcode:".$_SESSION['USERID']));
		curl_setopt($ch, CURLOPT_POSTFIELDS,$request);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		$data = curl_exec($ch);
		$curl_errno = curl_errno($ch);
		$curl_error = curl_error($ch);
		//echo "<script> console.log('ErrNo:".$curl_errno."')</script>";
		//echo "<script> console.log('Err:".$curl_error."')</script>";
		curl_close($ch);
		return $data;
	}
	function CurlSendGetRequest($url,$request){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HTTPHEADER,array("Authcode:".$_SESSION['USERID']));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		$data = curl_exec($ch);
		$curl_errno = curl_errno($ch);
		$curl_error = curl_error($ch);
		echo "<script> console.log('ErrNo:".$curl_errno."')</script>";
		echo "<script> console.log('Err:".$curl_error."')</script>";
		curl_close($ch);
		return $data;
	}
	
	function GetData($opt,$what,$name=false)
	{
		$URL=$this->config('APIURL')."/".$what;
		$Barns=$this->CurlSendGetRequest($URL,"");
		//echo $Barns;
		$Barns=json_decode($Barns);
		
		
		$Str="";
		switch($opt)
		{
			case "COMBO":
				foreach($Barns->data as $Barn) { 
					
					//echo json_encode($Barn)."<br><br><br>";
					if($name)
					{
						$Str.="<option value=".$Barn->id.">".$Barn->name."</option>"; 
					}else
					{
						$Str.="<option value=".$Barn->id.">".$Barn->title."</option>"; 
					}
				}
				return $Str;
			break;
			case "LIST":
				foreach($Barns->data as $Barn) {  $Str.="<li><input type='checkbox' value=".$Barn->id." name='ameni[]'>".$Barn->title."</li>"; }
				return $Str;
			break;
		}
		
	}
	function GetCurrentChairStatus($Chairs)
	{
		
	}

}

?>