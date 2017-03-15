<?php
/**
* @param Crie um ou vários produtos novos.
*/
namespace SRC\TEST\PRODUCT\POST;

require_once "../../../../SRC/genericPost.php";
require_once "../../../../SRC/genericGet.php";

class ProductCreate extends \SRC\post\genericPost
{
	public function selectCategory() 
	{
		$cat = new \SRC\get\genericGet();
		return simplexml_load_string($cat->search('GetCategoryTree')[0]);
	}
	public function send($call, array $xml)
	{
		return $this->create($call, $xml);
	}
}
