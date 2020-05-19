<!-- 
	Coded By:
	Shreshth Tuli
-->

<?php
   $data = $_GET['data'];
   if (!(file_put_contents('HeartModel/data.csv',$data) === FALSE)){
   	echo "File xfer completed."; // file could be empty, though
   }
   else echo "File xfer failed.";
?>