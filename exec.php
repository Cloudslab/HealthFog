<?php

if(isset($_GET["cloud"])){
	$file = fopen("cloud.txt", "r");
	$ip = fgets($file);

	move_uploaded_file("data.csv", "data.csv");
	$tmp = file_get_contents("http://".$ip."/HealthFog/exec.php");
	
	echo $tmp;
}
else{
	echo exec("cp data.csv ./HeartModel/");

	while(true){
		if(file_exists("./HeartModel/output.txt")) break;
		else sleep(0.1);
	}

	$myfile = fopen("./HeartModel/output.txt", "r");
	echo fread($myfile,filesize("./HeartModel/output.txt"));
	fclose($myfile);	

	unlink("./HeartModel/output.txt");
}
?>