<?php
namespace Searchs;
abstract class Searchs {
	
	protected static $instance = null;
	protected $resolve = null;
	protected $param = array();
	protected $model = null;
	protected $resolveOptions = array('field','limit','order');
	
	public function __construct() {
		$this->resolve = new Resolve();
	}
	
	public function set($param) {
		$this->param = $this->resolve->set($param)->get();
	}
	
	public function get() {
		return $this->resolve();
	}
	
	protected function resolveSingle($table,$options) {
		//model
		$this->resolveModel($table);
		
		//options
		foreach ($options as $key=>$value) {
			$method = "resolve".ucwords($key);
			if(in_array($value, $this->resolveOptions,true) && method_exists($this, $method)) {
				$this->$method($value);
			}
		}
		
		//get result
		$result = array();
		
		if (isset($options['page'])) {
			$pageResult = $this->resolvePage($options['page']);
			$result['data'] = $pageResult->items();
			$result['page'] = $pageResult->render();
		} else {
			$result['data'] = $this->model->get();
			$result['page'] = null;
		}
		
		return $result;
	}
	
	protected function resolve($param = null) {
		
		static $result;
		
		empty($param) && $param = $this->param;
		
		foreach ($param as $key=>$values) {
			
			$result[$key] = $this->resolveSingle($key, $values);
				
		}
		return $result;
	}
	
	/**
	 * 返回搜索的实例接口
	 * @param string $instance
	 */
	public static function instance($instance = null) {
		if (empty($instance)) {
			return self::$instance;
		}
		
		$class = '\Searchs\Driver\\'.ucwords($instance);
		self::$instance = new $class;
		
		return self::$instance;
	}
	
	
	abstract protected function resolveModel($table);
	
	abstract protected function resolveWhere(array $where);
	
	abstract protected function resolveLimit(array $limit);
	
	abstract protected function resolveField(array $field);
	
	abstract protected function resolveOrder(array $order);
	
	abstract protected function resolveHasOne();
	
	abstract protected function resolvePage($page);
	
	abstract protected function resolveHasMany();
	
}