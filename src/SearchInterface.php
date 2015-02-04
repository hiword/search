<?php
namespace Searchs;
interface SearchInterface {
	
	public function resolveModel($table);
	
	public function resolveWhere(array $where);
	
	public function resolveLimit(array $limit);
	
	public function resolveField(array $field);
	
	public function resolveOrder(array $order);
	
	public function resolveHasOne();
	
	public function resolveHasMany();
	
}