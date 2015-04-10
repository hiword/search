<?php
namespace Searchs\Driver;
use Searchs\SearchBuilder;
class LaravelSearch extends SearchBuilder {
	
	/* (non-PHPdoc)
	 * @see \Searchs\SearchBuilder::where()
	 */
	protected function where(array $where = array(), $model = null) {
		// TODO Auto-generated method stub
		//设置默认值
		empty($where) && $where = $this->options['where'];
		
		//一维转二维数组
		count($where)===count($where,true) && $where = [$where];

		foreach ($where as $values) {
			//获取解析方法
			$method = array_shift($values);
				
			if (is_array($values[0])) {
				$this->model = call_user_func(array($this->model,$method),
						function ($query) use ($values){
							$this->where($values,$query);
						}
				);
			} else {
				$this->model = call_user_func_array(array($model ? $model : $this->model,$method),$values);
			}
		}
		
		return $this->model;
	}

	/* (non-PHPdoc)
	 * @see \Searchs\SearchBuilder::limit()
	 */
	protected function limit() {
		// TODO Auto-generated method stub
		$this->model = $this->model->take($this->options['limit'][1])->skip($this->options['limit'][0]);
		
		return $this->model;
	}

	/* (non-PHPdoc)
	 * @see \Searchs\SearchBuilder::field()
	 */
	protected function field() {
		// TODO Auto-generated method stub
		$this->model = $this->model->select($this->options['field']);
		
		return $this->model;
	}

	/* (non-PHPdoc)
	 * @see \Searchs\SearchBuilder::order()
	 */
	protected function order() {
		// TODO Auto-generated method stub
		$this->model = $this->model->orderBy($this->options['order'][0],$this->options['order'][1]);
		 
		return $this->model;
	}

	/* (non-PHPdoc)
	 * @see \Searchs\SearchBuilder::join()
	 */
	protected function join() {
		// TODO Auto-generated method stub
		
	}


}