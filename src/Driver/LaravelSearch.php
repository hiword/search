<?php
namespace Searchs\Driver;
use Searchs\SearchBuilder;
class LaravelSearch extends SearchBuilder {
	
	/**
	 * where加工方法
	 * @param array $where
	 * @param unknown $model
	 * @param string $tempModel
	 * @return mixed
	 */
	private function whereFactory(array $where,$model,$tempModel = null) {
		
		foreach ($where as $values) {
			//获取解析方法
			$method = array_shift($values);
		
			if (is_array($values[0])) {
				$model = call_user_func(array($model,$method),
						function ($query) use ($values,$model){
							$this->whereFactory($values,$model,$query);
						}
				);
			} else {
				$model = call_user_func_array(array($tempModel ? $tempModel : $model,$method),$values);
			}
		}
		
		return $model;
	}
	
	/* (non-PHPdoc)
	 * @see \Searchs\SearchBuilder::where()
	 * 
	 * [
	 * 		['where','users.create_userid','=',$this->session->id]
	 * 		['orWhere','users.create_userid','=',$this->session->id]
	 * 		[
	 * 			'where',
	 * 			[where,'users.create_userid','=',$this->session->id]
	 * 			[whereIn,id,[1,2,3,4]]
	 * 		]
	 * ]
	 */
	protected function where() {
		// TODO Auto-generated method stub
		//设置默认值
		
		//一维转二维数组
		count($this->options['where'])===count($this->options['where'],true) && $this->options['where'] = [$this->options['where']];
		
		$this->model = $this->whereFactory($this->options['where'], $this->model);
		
		return $this->model;
	}
	
	
	/**注意下面注释方法勿删除，上面两个方法是从下面演化而来的**/
	
// 	/* (non-PHPdoc)
// 	 * @see \Searchs\SearchBuilder::where()
// 	 */
// 	protected function where(array $where = array(), $tempModel = null,$model = null) {
// 		// TODO Auto-generated method stub
// 		//设置默认值
// 		empty($where) && $where = $this->options['where'];
		
// 		if (empty($model)) {
// 			$model = $this->model;
// 			$assignment = true;
// 		}
		
// 		//一维转二维数组
// 		count($where)===count($where,true) && $where = [$where];

// 		foreach ($where as $values) {
// 			//获取解析方法
// 			$method = array_shift($values);
				
// 			if (is_array($values[0])) {
// 				$model = call_user_func(array($model,$method),
// 						function ($query) use ($values){
// 							$this->where($values,$query);
// 						}
// 				);
// 			} else {
// 				$model = call_user_func_array(array($tempModel ? $tempModel : $model,$method),$values);
// 			}
// 		}
		
// 		//
// 		if (isset($assignment)) {
// 			return $this->model = $model;
// 		} else {
// 			return $model;
// 		}
// 	}

	/* (non-PHPdoc)
	 * @see \Searchs\SearchBuilder::limit()
	 * 
	 * [0,1]
	 * [10,1]
	 */
	protected function limit() {
		// TODO Auto-generated method stub
		$this->model = $this->model->take($this->options['limit'][1])->skip($this->options['limit'][0]);
		
		return $this->model;
	}

	/* (non-PHPdoc)
	 * @see \Searchs\SearchBuilder::field()
	 * 
	 * [field1,field2,field3]
	 */
	protected function field() {
		// TODO Auto-generated method stub
		$this->model = $this->model->select($this->options['field']);
		
		return $this->model;
	}

	/* (non-PHPdoc)
	 * @see \Searchs\SearchBuilder::order()
	 * 
	 * [id,desc]
	 */
	protected function order() {
		// TODO Auto-generated method stub
		$this->model = $this->model->orderBy($this->options['order'][0],$this->options['order'][1]);
		 
		return $this->model;
	}

	/* (non-PHPdoc)
	 * @see \Searchs\SearchBuilder::join()
	 * 
	 * 'user_datas'=>[
				'leftjoin',
				['on','users.id','=','user_datas.userid'],
				['orOn','users.id','=','user_datas.userid'],
				'where'=>[
					['where','create_userid','=',$this->session->id]
				]
			],
	 */
	protected function join() {
		// TODO Auto-generated method stub
		
		foreach ($this->options['join'] as $table=>$join) {
			
			$joinType = is_array($join[0]) ? 'join' : array_shift($join);
			
			$this->model = $this->model->$joinType($table,function($joinObject) use ($join){
				
				//get where
				if (isset($join['where'])) {
					$where = $join['where'];
					unset($join['where']);
				}
				
				//set on or on
				foreach ($join as $on) {
					$joinObject = call_user_func_array([$joinObject,array_shift($on)], $on);
				} 
				
				//set where last index
				isset($where) && $joinObject = $this->whereFactory($where,$joinObject);
				
			});
		}
		

// 		if ())
		//dd($this->options['join']);
	}


}