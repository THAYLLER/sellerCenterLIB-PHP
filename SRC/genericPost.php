<?php
/**
* @param classe generica para chamadas post
*/
namespace SRC\post;

require_once "base.php";

class genericPost extends \SRC\base
{
	private $xml;
	private $xmlRetorno;
	private $con;
	private $dtFim;

    function __construct(){
        $this->xml='';
        $this->dtFim='';
        $this->iniciar();
    }
    public function endDate()
    {
         $this->dtFim = new \DateTime(date('Y-m-d H:i:s', strtotime("+2 days",strtotime(date('Y-m-d H:i:s'))))); 
         $this->dtFim = $this->dtFim->format(\DateTime::ISO8601);
         return $this->dtFim;
    }
    private function setXml($product)
	{
		$this->xml = '<?xml version="1.0" encoding="UTF-8" ?>
				<Request>';
				$this->xml .= $product;
				$this->xml.='</Request>';

		return $this->xml;
	}
	public function xmlFeeds($SellerSku,$Name,$Description,$Price,$Variation,$PrimaryCategory,$data_atual,$data_fim,$SalePrice,$Quantity)
	{
		return $this->setXml('
		<Product>
		<SellerSku>'.$SellerSku.'</SellerSku>
		<Name>'.utf8_encode($Name).'</Name>
		<Variation>'.$Variation.'</Variation>
		<PrimaryCategory>'.$PrimaryCategory.'</PrimaryCategory>
		<Description><![CDATA['.utf8_encode($Description).']]></Description>
		<Brand>Sandro Dias</Brand>
		<Price>'.$SalePrice.'</Price>
		<SalePrice>'.$Price.'</SalePrice>
		<SaleStartDate>'.$data_atual.'</SaleStartDate>
		<SaleEndDate>'.$data_fim.'</SaleEndDate>
		<ProductData>
		<BoxHeight>10</BoxHeight>
		<BoxLength>10</BoxLength>
		<Weight>10</Weight>
		<BoxWidth>10</BoxWidth>
		<Color>Preto</Color>
		<ColorFamily>Preto</ColorFamily>
		<Gender>Masculino</Gender>
		<Model>um</Model>
		<Origin>Nacional</Origin>
		</ProductData>
		<Quantity>'.$Quantity.'</Quantity>
		</Product>
		');
	}
	public function create($tipo,array $xmlRetorno)
	{
		try{
	        	
		 	$this->actionSet($tipo);
        	$this->actionGet();
	        $this->currentDate();
	        $this->endDate();
	        $this->toChargeParameters();
	        $this->url();
		    return $this->callApi('post',$xmlRetorno);
	    } catch (Exception $e) {
    		return $e->getMessage();
    	}
	}
}