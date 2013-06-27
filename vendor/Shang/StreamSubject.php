<?php
namespace Shang;

/**
 * 日志流读取
 *
 * @package default
 * @author zhiliang
 **/
class StreamSubject implements \SplSubject
{
	private $obs;

	/**
	 * in 输入流，只读
	 * out 输出流，只写
	 * buffer 缓冲内容
	 */
	public $in=array(),$out,$buffer;

	/**
	 * 构造方法
	 *
	 * @return void
	 * @author zhiliang
	 **/
	public function __construct()
	{
		$this->obs = array();
	}


	/**
	 * 处理数据
	 *
	 * @return void
	 * @author zhiliang
	 **/
	public function run()
	{
		$this->buffer = 'asdasdasd';
		$this->notify();
	}
	/**
	 * 增加观察者
	 *
	 * @return void
	 * @author zhiliang
	 **/
	public function attach(\SplObserver $obclass)
	{
		$this->obs[] = $obclass;
	}

	public function detach(\SplObserver $obclass)
	{
		if($idx = array_search($obclass,$this->obs,true))
		unset($this->obs[$ids]);
	}

	public function notify()
	{
		foreach ($this->obs as $value) {
			$value->update($this);
		}
	}
} // END class StreamSubject implement SplSubject