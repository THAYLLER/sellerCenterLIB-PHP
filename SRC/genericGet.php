<?php
/**
* @param classe generica para chamadas get
*/
namespace SRC\get;

require_once "base.php";

class genericGet extends \SRC\base
{
	function __construct()
	{
		$this->start();
	}
	public function search($action)
	{
		$this->actionSet($action);
		$this->actionGet();
		$this->formatDate();
		$this->toChargeParameters();
		$this->url();
		return ($this->callApi('get',array('')));
	}
}