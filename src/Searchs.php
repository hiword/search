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
	
	protected function getResult($options) {
		if (isset($options['page'])) {
			
		} else {
			
		}
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
		
		if (!empty($data['page'])) {
			$pageResult = $this->resolvePagination($data['page']);
			$result['data'] = $pageResult->items();
			$result['page'] = $pageResult->render();
		} else {
			if (!empty($data['limit'])) {
				$this->resolveLimit($data['limit']);
			}
// 			$result['data'] = $this->selectModel->get();
		}
		
		return $result;
	}
	
	public function resolve($param = null) {
		empty($param) && $param = $this->param;
		
		foreach ($param as $key=>$values) {
			
			$this->resolveSingle($key, $values);
				
				
	
			$this->_result[$key] = $result = $this->_model->get();
				
			if (!empty($values['_has_one'])) {
				$this->resolveHasOne($values['_has_one'],$result);
			}
			// 			if (empty($keys)) {
			// 				$result = $this->_result[$key] = $this->_model->get();
			// 			} else {
			// 				$result = $this->_result[$key][$keys] = $this->_model->get();
			// 			}
				
			// 			foreach ($this->_result[$key] as $values) {
			// 				$d = $values->toArray();
			// 				print_r($d);exit();
			// 				//$this->result[$key] =
			// 				echo $values->id;exit();
			// 			}
	
			/* if (!empty($values['_has_one'])) {
			 $this->_result[$keys]['_has_one'][$key] = $result;
			$this->resolveHasOne($values['_has_one'],$result,$key);
	
			} else {
			$this->_result[$key] = $result;
			} */
				
			// 			$this->getModel($key,$rel);
			//$this->_result[$key] = $this->_model->get();
				
			// 			$this->_result[$key] = $this->_model->get();
			// 			$result = $this->_model->get();
			// 			foreach ($result as $values) {
			// 				var_dump($result);exit();
			// 				echo $values->title;
			// 				echo '<br />';
			// 				echo $values->content;
			// 				exit();
			// 			}
			// 			echo DB::getQueryLog();exit();
			
		}
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
	
	abstract protected function resolveHasMany();
	
}