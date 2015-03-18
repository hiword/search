<?php
namespace Searchs;
use Illuminate\Support\Facades\DB;
class Resolve {
	
	/*
	 
	 field:[
	 	id,title,sql
	 ]
	 where:[
	 	['where','id','=',abc],
	 	['orWhere','id','=',abc],
	 	['orWhere','id','=',abc],
 		[	'orWhere',
	 		['where','id','=',3],
	 		['where','is_delete','=',1]
	 	]
	 ]
	 limit:[0,15]
	 order:[id,desc],
	 join:[
	 	on:[
	 		[on,a1,=,a2],
	 		[orOn,a1,=,a2]
	 	]
 		where:[
 			//同上
 		]
	 ]
	 
	 */
	
	protected $param = array();
	protected $data = array();
	protected $model = array();
	protected $options = ['field'=>[],'where'=>[],'order'=>[],'limit'=>[]];
	
	public function __construct(array $param) {
		$this->param = $param;
	}
	
	/**
	 * 字符串转换到数组
	 * @param unknown $param
	 * @return multitype:
	 */
	protected function stringToArray($data,$delimiter = ',') {
		//解析字符串形式的
		if (is_string($data) && $data) {
			$data = explode($delimiter,trim($data,$delimiter));
		}
		return $data;
	}
	
	/**
	 * 解析字段
	 * @param string|array $field
	 * @return \Searchs\Resolve
	 */
	protected function field($field) {
		$this->options['field'] = $this->stringToArray($field);
		return $this;
	}
	
	/**
	 * 解析order
	 * @param string|array $order
	 * @return \Searchs\Resolve
	 */
	protected function order($order) {
		$this->options['order'] = $this->stringToArray($order);
		return $this;
	}
	
	/**
	 * 解析Limit
	 * @param array|string $limit
	 * @return \Searchs\Resolve
	 */
	protected function limit($limit) {
		
		$limit = $this->stringToArray($limit);
		
		//如果只有一个参数，则默认从0开始
		if (count($limit) === 1) {
			$limit[1] = $limit[0];
			$limit[0] = 0;
		}
		
		$this->options['limit'] = $limit;
		
		return $this;
	}
	
	/**
	 * 解析Where
	 * @param array|string $where
	 * @return \Searchs\Resolve
	 */
	protected function where($where) {
		$this->options['where'] = $where;
		return $this;
	}
	
	/**
	 * 获取解析结果
	 * @return multitype:multitype:
	 */
	public function getResolve() {
		foreach (array_keys($this->options) as $method) {
			!empty($this->param[$method]) && $this->$method($this->param[$method]);
		} 
		return $this->options;
	}
	
}