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
	private $obs=array(),$buffer;
	private static $instance;

	/**
	 * 构造方法
	 *
	 * @return void
	 * @author zhiliang
	 **/
	private function __construct()
	{
		return ;
	}
	private function __clone()
	{
		return ;
	}

	/**
	 * 单例
	 */
	public static function singleton()
	{
		if(!isset(self::$instance)){
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	/**
	 * 触发事件
	 *
	 * @return void
	 * @author zhiliang
	 **/
	public function setBuffer($buffer)
	{
		$this->buffer = $buffer;
		$this->notify();
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author zhiliang
	 **/
	public function getBuffer()
	{
		return $this->buffer;
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