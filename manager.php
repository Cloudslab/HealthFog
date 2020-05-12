<!-- 
	Coded By:
	Shreshth Tuli
-->

<html>
<head><title>EdgeLens - Manager (Master)</title>
</head>
<body>

<?php

{
	// Read IPs from config.txt
	$file = fopen("config.txt", "r");
	$content = "";
	$line = fgets($file);
	$localIP = getHostByName(getHostName());
	
	while(($line = fgets($file)) !== false){
		$content=$content.$line;	
	}
	if(isset($_POST['config'])){echo "All Workers Configured<br/>";}
	fclose($file);
	
	// Alter first line of config.txt as per Enable master or aneka set or not
	if(isset($_POST['enableMaster'])){
		if(isset($_POST['enableAneka'])){
			file_put_contents("config.txt", "EnableMaster EnableAneka".PHP_EOL.$content);
		}
		else{
			file_put_contents("config.txt", "EnableMaster DisableAneka".PHP_EOL.$content);
		}
	}
	else{
		if(isset($_POST['enableAneka'])){
			file_put_contents("config.txt", "DisableMaster EnableAneka".PHP_EOL.$content);
		}
		else{
			file_put_contents("config.txt", "DisableMaster DisableAneka".PHP_EOL.$content);
		}
	}
	
	// If new IP added, add to config.txt
	if(isset($_POST['ip']) && $_POST['ip']!=""){
	$file = fopen("config.txt", "a");
	$k = $_POST['ip']."\n";
	echo "Worker IP added : ".$_POST['ip']."<br/>";
	fwrite($file, $k);
	fclose($file);	
	
	}
	{
	// Display IPs already set
	echo "Set Worker IPs here <br/>";
	$file = fopen("config.txt", "r");
	$line = fgets($file);
	while(($line = fgets($file)) !== false){
		echo "Worker IP : ".$line."<br/>";	
		if(isset($_POST['sync'])){
			$ip = preg_replace('/\s+/', '', $line);
			$tmp = file_get_contents("http://".$ip."/HealthFog/manager.php/?sync=sync");
		}	
	}
	fclose($file);
	echo "<br/>"."Add Worker IP<br/>";
	echo "
	<form id='ipinfo' method='post'>
	<input type='checkbox' name='enableMaster' value='Yes' checked />Enable Master as Worker <br/>
	<input type='checkbox' name='enableAneka' value='Yes' checked />Enable Aneka<br/>
	<input type='text' name='ip' id='ip'  maxlength=\"500\" /> <br/>
	<input type='submit' name='add' value='Add Worker' /> <br/>
	<input type='submit' name='config' value='Configure Workers' /> 
	<br/><br/>
	<input type='submit' name='remove' value='Remove all workers' />
	<input type='submit' name='sync' value='Sync Jar file' />
	</form>";
	}
}

$localIP = getHostByName(getHostName());
echo "Master IP address : ".$localIP;

?>

<?php

// Remove all worker nodes
if(isset($_POST['remove'])){
	file_put_contents("config.txt", "EnableMaster EnableAneka".PHP_EOL);
	echo "All Workers removed<br/>";
}

?>
</body>
</html>
