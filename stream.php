<?php
require 'vendor/autoload.php';

m();

//--------------------------------------------------------
// 定义logger
//--------------------------------------------------------
$log = new Monolog\Logger('name');
$log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING));


//--------------------------------------------------------
// 开启流处理器，注册ob
//--------------------------------------------------------
$subject = Shang\StreamSubject::singleton();
$hitTopOb = new Shang\HitTopOb();
$timeOb = new Shang\TimeOb();
$subject->attach($hitTopOb);
$subject->attach($timeOb);



//--------------------------------------------------------
// 注册自定义filter
//--------------------------------------------------------
stream_filter_register("myfilter", "Shang\StreamFilter")
    or die("Failed to register filter");

//--------------------------------------------------------
// 定义输出流,增加write过滤器
//--------------------------------------------------------
$out = 'out';
$w = fopen($out,'w');
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
    break;
}


$hitTopOb->count();
$timeOb->count();


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