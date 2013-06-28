<?php
namespace Shang;
/**
* 点击量排行
*/
class HitTopOb implements \SplObserver
{
	public $t=0,$buffer;
	public function update(\SplSubject $subject) {
		$this->buffer = $subject->getBuffer();
        $this->t++;
        echo __CLASS__ . ' - ' . $this->t."\n";
    }
}