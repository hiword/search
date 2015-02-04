<?php
namespace Searchs;
class Verify {
	
	protected $param = array();
	
	/**
	 * 解析参数
	 * @param array|string $param
	 * @return \Searchs\Verify
	 */
	public function resolve($param) {
		
		if (!is_array($param)) {
			$param = parse_str(rawurldecode(base64_decode($param)),$param);
		}
		
		$this->param = $param;
		
		return $this;
	}
	
// 	public function 
	
}