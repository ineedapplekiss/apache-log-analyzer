<?php


m();

/* Define our filter class */
class strtoupper_filter extends php_user_filter {
    public $buffer = '';
    function filter($in, $out, &$consumed, $closing)
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            //$bucket->data = strtoupper($bucket->data);
            if(!empty($this->buffer))
            {
                $bucket->data = $this->buffer.$bucket->data;
            }
            $pos = strrpos($bucket->data,"\n");
            if($pos!==false && $pos!==0)
            {
                $this->buffer = substr($bucket->data,$pos);
                $bucket->data = substr($bucket->data,0,$pos);
                if($this->buffer=="\n")
                {
                    $bucket->data .= $this->buffer;
                    $this->buffer="";
                }
            }
            else
            {
                $this->buffer = $bucket->data;
            }
            $bucket->data = preg_replace('#((?:\d{1,3}\.){3}\d{1,3}) - - (\[[^]]{20,30}\]) (\d{1,2}) (\"[^"]{0,1400}\") (\d{3}) (\"{0,1}[0-9-]{0,8}\"{0,1}) (\"{0,1}[^"]{0,1900}\"{0,1}) ([\\\"]{0,3}[^"]{0,1800}[\\\"]{0,3}) (\"{0,1}[^"]{0,1800}\"{0,1})#','\1 - - \2 \4 \5 \6 \7 \8',$bucket->data);
            //$bucket->data = $bucket->data."=====";  
            $consumed += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }
        return PSFS_PASS_ON;
    }
}

/* Register our filter with PHP */
stream_filter_register("myfilter", "strtoupper_filter")
    or die("Failed to register filter");

$out = 'out';
$w = fopen($out,'a');
stream_filter_append($w, "myfilter");


$logdir = 'log';
foreach (new DirectoryIterator($logdir) as $fileInfo) {
    if($fileInfo->isDot()) continue;
    $filename = $fileInfo->getFilename();
    if(strpos($filename,'.gz')===false)continue;

    $in = $logdir.DIRECTORY_SEPARATOR.$filename;
    echo $in."\n";
    $r = gzopen($in,'r');
    echo 'result:'.stream_copy_to_stream($r,$w)."\n";
    gzclose($r);
}





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

