<?php


m();

/* Define our filter class */
class strtoupper_filter extends php_user_filter {
  function filter($in, $out, &$consumed, $closing)
  {
    while ($bucket = stream_bucket_make_writeable($in)) {
      //$bucket->data = strtoupper($bucket->data);
      $bucket->data = preg_replace('#((?:\d{1,3}\.){3}\d{1,3}) - - (\[[^]]{20,30}\]) (\d{1,2}) (\"[^"]{20,400}\") (\d{3}) (\"{0,1}[0-9-]{1,8}\"{0,1}) (\"{0,1}[^"]{1,400}\"{0,1}) (\"{0,1}[^"]{1,800}\"{0,1}) (\"{0,1}[^"]{1,800}\"{0,1})#','\1 - - \2 \4 \5 \6 \7 \8',$bucket->data);
      $consumed += $bucket->datalen;
      stream_bucket_append($out, $bucket);
    }
    return PSFS_PASS_ON;
  }
}

/* Register our filter with PHP */
stream_filter_register("myfilter", "strtoupper_filter")
    or die("Failed to register filter");




$in = 'log/130621.mall.jiaju.sina.com.cn_3221.cn.gz';
$out = '13out';
$r = gzopen($in,'r');
$w = fopen($out,'w');

stream_filter_append($w, "myfilter");



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

