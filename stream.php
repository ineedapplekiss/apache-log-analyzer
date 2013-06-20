<?php
m();
$in = '13';
$out = '13out';
$r = fopen($in,'r');
$w = fopen($out,'a+');
echo stream_copy_to_stream($r,$w)."\n";

m();
mp();

function m()
{
	    $m = memory_get_usage();
		    echo floor($m/1024)."k----[".floor($m/1024/1024)." M] \n";
}

function mp()
{
	    $m = memory_get_peak_usage();
		    echo 'peak:'.floor($m/1024)."k----[".floor($m/1024/1024)." M] \n";
}
?>

