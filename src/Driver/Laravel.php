<?php
namespace Searchs\Driver;
use Searchs\Searchs;
use Illuminate\Support\Facades\DB;
class Laravel extends Searchs {
	
	protected function resolveModel($table) {
		$this->model = DB::table($table);
	}
	
	protected function resolveField(array $field) {
		$this->model->select($field);
	}
	
	 protected function resolveWhere(array $where) {
	 	
	 }
	 
	 protected function resolveLimit(array $limit) {
	 	
	 }
	 
	 protected function resolveOrder(array $order) {
	 	$this->model->orderBy($order[0],$order[1]);
	 }
	 
	 protected function resolveHasOne() {
	 	
	 }
	 protected function resolveHasMany() {
	 	
	 }
}