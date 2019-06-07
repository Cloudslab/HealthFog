<?php
// Coded by:
// Shreshth Tuli

function getOS($userAgent) {
    // Create list of operating systems with operating system name as array key 
    $oses = array (
        'iPhone'            => '(iPhone)',
        'Windows 3.11'      => 'Win16',
        'Windows 95'        => '(Windows 95)|(Win95)|(Windows_95)',
        'Windows 98'        => '(Windows 98)|(Win98)',
        'Windows 2000'      => '(Windows NT 5.0)|(Windows 2000)',
        'Windows XP'        => '(Windows NT 5.1)|(Windows XP)',
        'Windows 2003'      => '(Windows NT 5.2)',
        'Windows Vista'     => '(Windows NT 6.0)|(Windows Vista)',
        'Windows 7'         => '(Windows NT 6.1)|(Windows 7)',
        'Windows NT 4.0'    => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
        'Windows ME'        => 'Windows ME',
        'Open BSD'          => 'OpenBSD',
        'Sun OS'            => 'SunOS',
        'Linux'             => '(Linux)|(X11)',
        'Safari'            => '(Safari)',
        'Mac OS'            => '(Mac_PowerPC)|(Macintosh)',
        'QNX'               => 'QNX',
        'BeOS'              => 'BeOS',
        'OS/2'              => 'OS/2',
        'Search Bot'        => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
    );
    
    // Loop through $oses array
    foreach($oses as $os => $preg_pattern) {
        // Use regular expressions to check operating system type
        if ( preg_match('@' . $preg_pattern . '@', $userAgent) ) {
            // Operating system was matched so return $oses key
            return $os;
        }
    }
    
    // Cannot find operating system so return Unknown
    
    return 'n/a';
}

// Display CPU load
error_reporting(0);
$os = getOS($_SERVER['HTTP_USER_AGENT']);

//Windows:
if(strpos($os, 'Windows') !== false || strpos($os, 'n/a') !== false){
	exec('wmic cpu get LoadPercentage', $p);
	$load = trim($p[1], '"');
	echo $load/100;
}
//Linux: 
else {
	$load = sys_getloadavg();
	echo $load[0];
}

//echo $os;

?>

