<?php
namespace Searchs;

class Search {

	protected $search = null;
	
	public function __construct(SearchBuilder $search,$model,array $data = array()) {
		$this->search = $search;
		$this->set($model,$data);
	}
	
	public function set($model,array $data = array()) {
		//解析条件
		$Resolve = new Resolve($data);
		$options = $Resolve->getResolve();
		$this->search->set($model, $options);
	}
	
	public function get() {
		return $this->search->get();
	}
	
}