<?php
namespace Shang;
/**
* 点击量排行
*/
class HitTopOb implements \SplObserver
{
	public function update(\SplSubject $subject) {
        echo __CLASS__ . ' - ' . $subject->buffer;
    }
}