<?php
/**
* @param Obtenha os detalhes do cliente para uma variedade de pedidos. 
Substancialmente diferente do GetOrder, que recupera os itens da ordem de uma ordem.
*/
namespace SRC\TEST\SALES_ORDER\GET;

require_once "../../../../SRC/genericGet.php";

class getOrder extends \SRC\get\genericGet
{
	public function call()
	{
		$this->CreatedAfterSet('2016-01-01 00:00:00');
		return $this->search('GetOrders');
	}
}
