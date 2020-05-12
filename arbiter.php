
<?php

session_start();
	
// Parse config.txt for IPs 
$file = fopen("config.txt", "r");
$line = fgets($file);
$choiceArray = explode(" ", $line);
$localIP = getHostByName(getHostName());
		
// Initialize choices
// true if work given to them, else false

$toMaster = true;	
if(preg_replace('/\s+/', '', $choiceArray[0]) == "DisableMaster"){
	$toMaster = false;	
}
$toAneka = true;	
if(preg_replace('/\s+/', '', $choiceArray[1]) == "DisableAneka"){
	$toAneka = false;	
}

$ips = array();
while(($line = fgets($file)) !== false){
  array_push($ips, $line);
}
	
// Initialize loads array to store loads of workers
$loads = array();
// For each IP, get load from load.php
foreach($ips as $ip){
	$ip = preg_replace('/\s+/', '', $ip);
	$dataFromExternalServer = @file_get_contents("http://".$ip."/HealthFog/load.php");
	if($dataFromExternalServer != FALSE){
		$dataFromExternalServer = preg_replace('/\s+/', '', $dataFromExternalServer);	
		$my_var = 0.0 + $dataFromExternalServer;
		//echo "<br/>Woker load with IP ".$ip.": ".$my_var;
	} else{
		$my_var = 100;
		//echo "<br/>Woker with IP ".$ip.": compromised - Error \"Could not connect to fog node\"";
	}
	array_push($loads, $my_var);	
	// If any load < 80% then toMaser and toAneka = false
  	if($my_var <= 0.8){
  		$toMaster = false;
  		$toAneka = false;
  	}
}
	
$result = "";

	
if($toMaster && $toAneka){
	$toAneka = false;
}

if(sizeof($loads) == 0){
	$toMaster = true;	
}	
	
if(!$toMaster && !$toAneka){
	// Work given to worker with least load
	$min = 100;
	$minindex = 0;
	foreach($loads as $load){
		if ($min > $load){
			$min = $load;			
		}		
	}
	foreach($loads as $load ){
		if($min == $load){
			break;			
		}		
		$minindex = $minindex+1;
	}
	$ipworker = $ips[$minindex];
	$ipworker = preg_replace('/\s+/', '', $ipworker);
	echo $ipworker;	
}
elseif($toAneka) {
	// Work done to Aneka
	$file = fopen("config.txt", "r");
	$line = fgets($file);
	$ipworker = preg_replace('/\s+/', '', $line);
	echo "cloud";
	//$result = file_get_contents('http://'.$ipworker.'/HealthKeeper/Aneka/workerAneka.php/?'.$getRequest);
}
else{
	// Work done by master
	echo $localIP;
}

?>
