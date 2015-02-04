<?php
namespace Searchs;
use Illuminate\Support\Facades\DB;
class Resolve {
	
	protected $param = array();
	protected $data = array();
	protected $model = array();
	protected $resolveOptions = array('field','order','where','limit');
	
	
	public function set($param) {
		$this->param = $this->resolveParamFormat($param);
		return $this;
	}
	
	public function get() {
		return $this->param;
	}
	
	public function resolve($param = null) {
		empty($param) && $param = $this->param;

		foreach ($param as $key=>&$values) {
			
			$values = $this->resolveSingle($values);
			
			if (!empty($values['_has_one'])) {
				$this->resolve($values['_has_one']);
			}
			
		}
		return $param;
	}
	
	/**
	 * 解析Order
	 * @param array $data
	 */
	protected function resolveOrder($order) {
	
		$order = $this->stringToArray($order);
		
		if(count($order) === 1) {
			$order[1] = 'desc';
		}
	
		return $order;
	}
	
	/**
	 * 解析单条数据
	 * @param array $options
	 * @return array
	 */
	protected function resolveSingle(array $options) {
		foreach ($options as $key=>&$value) {
			
			if (empty($value) || !in_array($key, $this->resolveOptions,true)) continue;
			
			$method = 'resolve'.ucfirst($key);
			$value = $this->$method($value);
			
		}
		
		return $options;
	}
	
	/**
	 * 解析Field
	 * @param array|string $field
	 * @return array
	 */
	protected function resolveField($field) {
		
		return $this->stringToArray($field);
		
	}
	
	/**
	 * 字符串转换到数组
	 * @param unknown $param
	 * @return multitype:
	 */
	protected function stringToArray($param) {
		//解析字符串形式的
		if (is_string($param)) {
			$param = explode(',',trim($param,','));
		}
		return $param;
	}
	
	/**
	 * 解析初始化数据
	 * @param string|array $param
	 * @return Ambigous <void, multitype:>
	 */
	protected function resolveParamFormat($param) {
		
		if (!is_array($param)) {
			parse_str(rawurldecode(base64_decode($param)),$param);
		}
		
		return $param;
	}
	
}