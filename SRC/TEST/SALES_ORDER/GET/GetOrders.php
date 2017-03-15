<?php
/**
* @param Obtenha os detalhes do cliente para uma variedade de pedidos. 
Substancialmente diferente do GetOrder, que recupera os itens da ordem de uma ordem.
*/
namespace SRC\TEST\SALES_ORDER\GET;

require_once "../../../../SRC/genericGet.php";

class getOrder extends \SRC\get\genericGet
{
	public function call($dt)
	{
		$this->CreatedAfterSet($dt);
		return $this->search('GetOrders');
	}
}

$get = new \SRC\TEST\SALES_ORDER\GET\getOrder;
$get->call('2016-01-01 00:00:00');

$array = simplexml_load_string($xml[0])->Body->Orders->Order;