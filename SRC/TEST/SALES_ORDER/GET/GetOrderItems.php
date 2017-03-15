<?php
/**
* @param GetMultipleOrderItems: Retorna os itens para uma ou mais ordens.
* @param getGetOrderItems: Retorna os itens para uma ordem.
*/
namespace SRC\TEST\SALES_ORDER\GET;

require_once "../../../../SRC/genericGet.php";

class GetOrderItems extends \SRC\get\genericGet
{
	public function call($id,$method)
	{
		$this->OrderIdSet($id);
		return $this->search($method);
	}
}

$get = new \SRC\TEST\SALES_ORDER\GET\GetOrderItems;

$marketplaceOrderId = 1;
$xml = $get->call($marketplaceOrderId,"GetOrderItems");


for ($i=0; $i < count($xml) ; $i++) { 
	print_r($xml[$i]);
}
