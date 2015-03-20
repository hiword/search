<?php
namespace Searchs;
abstract class SearchBuilder  {
	
	/**
	 * 解析选项
	 * @var array
	 */
	protected $options = [];
	
	/**
	 * 需要解析的Model 必须为 Object
	 * @var Object
	 */
	protected $model = null;
	
	/**
	 * 设置数据集
	 * @param Object $model
	 * @param array $options
	 * @return SearchBuilder
	 */
	public function set($model,array $options) {
		$this->options = $options;
		$this->model = $model;
		return $this;
	}
	
	/**
	 * 获取最后模型
	 * @return object
	 */
	public function get() {
		
		foreach ($this->options as $method=>$values) {
			if (empty($values)) {
				continue;
			}
			$this->$method($values);
		}
		
		return $this->model;
	}
	
	/**
	 * where条件设置
	 */
	abstract protected function where(array $where = array(),$model = null);
	
	/**
	 * limit
	 */
	abstract protected function limit();
	
	/**
	 * field
	 */
	abstract protected function field();
	
	/**
	 * order
	 */
	abstract protected function order();
	
	/**
	 * join
	 */
	abstract protected function join();
}