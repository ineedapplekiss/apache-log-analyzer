<?php
namespace Shang;
/**
* 点击量排行
*/
class HitTopOb implements \SplObserver
{
	public $t=0,$buffer,$result;
	public function update(\SplSubject $subject) {
		$this->buffer = $subject->getBuffer();
        $this->t++;
        $lineArr = explode("\n",$this->buffer);
        foreach ($lineArr as $key => $value) {
        	//$this->result[] = $value;
        	$this->result++;
        }
    }

    /**
     * undocumented function
     *
     * @return void
     * @author zhiliang
     **/
    public function count()
    {
    	echo $this->result."<br>\n";
    }
}