<?php
namespace Shang;

/**
* 日志流过滤器
*/
class StreamFilter extends \php_user_filter
{
	public $buffer = '';
    function filter($in, $out, &$consumed, $closing)
    {
        while ($bucket = \stream_bucket_make_writeable($in)) {
            //$bucket->data = strtoupper($bucket->data);
            if(!empty($this->buffer))
            {
                $bucket->data = $this->buffer.$bucket->data;
            }
            $pos = \strrpos($bucket->data,"\n");
            if($pos!==false && $pos!==0)
            {
                $this->buffer = \substr($bucket->data,$pos);
                $bucket->data = \substr($bucket->data,0,$pos);
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
            $bucket->data = \preg_replace('#((?:\d{1,3}\.){3}\d{1,3}) - - (\[[^]]{20,30}\]) (\d{1,2}) (\"[^"]{0,1400}\") (\d{3}) (\"{0,1}[0-9-]{0,8}\"{0,1}) (\"{0,1}[^"]{0,1900}\"{0,1}) ([\\\"]{0,3}[^"]{0,1800}[\\\"]{0,3}) (\"{0,1}[^"]{0,1800}\"{0,1})#','\1 - - \2 \4 \5 \6 \7 \8',$bucket->data);
            //开启统计
			StreamSubject::singleton()->setBuffer($bucket->data);

            $consumed += $bucket->datalen;
            \stream_bucket_append($out, $bucket);
        }
        return PSFS_PASS_ON;
    }
}