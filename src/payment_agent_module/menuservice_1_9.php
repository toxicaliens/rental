<?php
/*
* CITY COUNCIL EBPPP PROJECT
* MenuService Class Ver. 1.9
* 
* NEW FEATURES:
*
*
* --Additional field for inputs that need encryption (Password style asterik) and 
* disabling auto-complete....
*
*
* Author: Jairus Obuhatsa
* Date: 09/08/2011
*/

define("XMLPATH","http://192.168.100.13/bibi/"); //This will later change to the live server IP
define("DEBUGMODE","0"); //This setting allows you to print debugging information or hide it...

$service_type_url =XMLPATH."serviceTypeXMLNode.xml";
$services_url =XMLPATH."serviceXMLNode.xml";
$options_url =XMLPATH."optionXMLNode.xml";
$inputs_url =XMLPATH."inputsXMLNode.xml";

/*DEBUG CODE...*/
if(DEBUGMODE)
{
	$menu = new MenuService($service_type_url,$services_url,$options_url,$inputs_url);
	$menu->getAllServiceTypes();
	echo "<hr><hr>";
	$menu->getAllServicesInServiceType("1");
	echo "<hr><hr>";
	$menu->getAllOptionsInService("200");
	echo "<hr><hr>";
	$menu->getAllOptionsInOption("8");
	echo "<hr><hr>";
	$menu->getAllInputsInOption("9");
}

class MenuService{
	
	private $service_type_url;
	private $services_url;
	private $options_url;
	private $inputs_url;
	
	function MenuService($service_type_url,$services_url,$options_url,$inputs_url)
	{
		$this->service_type_url = $service_type_url;
		$this->services_url = $services_url;
		$this->options_url = $options_url;
		$this->inputs_url = $inputs_url;
	}
	
	function getOptionDetails($option)
	{
		$details = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($this->options_url);		
		$x=$xmlDoc->getElementsByTagName('Option');
		
		for($i=0; $i<($x->length); $i++)
  		{
		  $a=$x->item($i)->getElementsByTagName('ServiceID');
		  $b=$x->item($i)->getElementsByTagName('OptionID');
		  $c=$x->item($i)->getElementsByTagName('ParentOptionID');
		  $d=$x->item($i)->getElementsByTagName('OptionName');
		  $e=$x->item($i)->getElementsByTagName('OptionDescription');
		  $f=$x->item($i)->getElementsByTagName('OptionCode');
		  $g=$x->item($i)->getElementsByTagName('KeyWord');
		  $h=$x->item($i)->getElementsByTagName('Leaf');
		 // $i=$x->item($i)->getElementsByTagName('PrePost');
		  $j=$x->item($i)->getElementsByTagName('Amount');
		  $k=$x->item($i)->getElementsByTagName('LastUpdate');
		  
		  if($b->item(0)->childNodes->item(0)->nodeValue == $option)
		  { 
			  $details['ServiceID'] = $a->item(0)->childNodes->item(0)->nodeValue;
			  $details['OptionID'] = $b->item(0)->childNodes->item(0)->nodeValue;
			  $details['ParentOptionID'] = $c->item(0)->childNodes->item(0)->nodeValue;
			  $details['OptionName'] = $d->item(0)->childNodes->item(0)->nodeValue;
			  $details['OptionDescription'] = $e->item(0)->childNodes->item(0)->nodeValue;
			  $details['OptionCode'] = $f->item(0)->childNodes->item(0)->nodeValue;
			  $details['KeyWord'] = $g->item(0)->childNodes->item(0)->nodeValue;
			  $details['Leaf'] = $h->item(0)->childNodes->item(0)->nodeValue;
						  // $i->item(0)->childNodes->item(0)->nodeValue."*".
			  $details['Amount'] = $j->item(0)->childNodes->item(0)->nodeValue;
			  $details['LastUpdate'] = $k->item(0)->childNodes->item(0)->nodeValue;
						   
				
				if(DEBUGMODE)
				{				
					echo $a->item(0)->childNodes->item(0)->nodeValue."*".
						   $b->item(0)->childNodes->item(0)->nodeValue."*".
						   $c->item(0)->childNodes->item(0)->nodeValue."*".
						   $d->item(0)->childNodes->item(0)->nodeValue."*".
						  $e->item(0)->childNodes->item(0)->nodeValue."*".
							$f->item(0)->childNodes->item(0)->nodeValue."*".
						   $g->item(0)->childNodes->item(0)->nodeValue."*".
						   $h->item(0)->childNodes->item(0)->nodeValue."*".
						  // $i->item(0)->childNodes->item(0)->nodeValue."*".
						   $j->item(0)->childNodes->item(0)->nodeValue."*".
						   $k->item(0)->childNodes->item(0)->nodeValue."<hr>";
				}
			break;
		  }
		}
		return $details;
	}

	
	function getServiceDetails($service)
	{
		$details = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($this->options_url);		
		$x=$xmlDoc->getElementsByTagName('Service');
		
		for($i=0; $i<($x->length); $i++)
  		{
		  $a=$x->item($i)->getElementsByTagName('ServiceID');
		  $b=$x->item($i)->getElementsByTagName('OptionID');
		  $c=$x->item($i)->getElementsByTagName('ParentOptionID');
		  $d=$x->item($i)->getElementsByTagName('OptionName');
		  $e=$x->item($i)->getElementsByTagName('OptionDescription');
		  $f=$x->item($i)->getElementsByTagName('OptionCode');
		  $g=$x->item($i)->getElementsByTagName('KeyWord');
		  $h=$x->item($i)->getElementsByTagName('Leaf');
		 // $i=$x->item($i)->getElementsByTagName('PrePost');
		  $j=$x->item($i)->getElementsByTagName('Amount');
		  $k=$x->item($i)->getElementsByTagName('LastUpdate');
		  
		  if($b->item(0)->childNodes->item(0)->nodeValue == $option)
		  { 
			  $details['ServiceID'] = $a->item(0)->childNodes->item(0)->nodeValue;
			  $details['OptionID'] = $b->item(0)->childNodes->item(0)->nodeValue;
			  $details['ParentOptionID'] = $c->item(0)->childNodes->item(0)->nodeValue;
			  $details['OptionName'] = $d->item(0)->childNodes->item(0)->nodeValue;
			  $details['OptionDescription'] = $e->item(0)->childNodes->item(0)->nodeValue;
			  $details['OptionCode'] = $f->item(0)->childNodes->item(0)->nodeValue;
			  $details['KeyWord'] = $g->item(0)->childNodes->item(0)->nodeValue;
			  $details['Leaf'] = $h->item(0)->childNodes->item(0)->nodeValue;
						  // $i->item(0)->childNodes->item(0)->nodeValue."*".
			  $details['Amount'] = $j->item(0)->childNodes->item(0)->nodeValue;
			  $details['LastUpdate'] = $k->item(0)->childNodes->item(0)->nodeValue;
						   
				
				if(DEBUGMODE)
				{				
					echo $a->item(0)->childNodes->item(0)->nodeValue."*".
						   $b->item(0)->childNodes->item(0)->nodeValue."*".
						   $c->item(0)->childNodes->item(0)->nodeValue."*".
						   $d->item(0)->childNodes->item(0)->nodeValue."*".
						  $e->item(0)->childNodes->item(0)->nodeValue."*".
							$f->item(0)->childNodes->item(0)->nodeValue."*".
						   $g->item(0)->childNodes->item(0)->nodeValue."*".
						   $h->item(0)->childNodes->item(0)->nodeValue."*".
						  // $i->item(0)->childNodes->item(0)->nodeValue."*".
						   $j->item(0)->childNodes->item(0)->nodeValue."*".
						   $k->item(0)->childNodes->item(0)->nodeValue."<hr>";
				}
			break;
		  }
		}
		return $details;
	}

	
	function getAllServiceTypes()
	{
		$array = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($this->service_type_url);		
		$x=$xmlDoc->getElementsByTagName('ServiceType');
		
		for($i=0; $i<($x->length); $i++)
  		{
		  $a=$x->item($i)->getElementsByTagName('ServiceTypeID');
		  $b=$x->item($i)->getElementsByTagName('Name');
		  $c=$x->item($i)->getElementsByTagName('Description');
		  
		  $array[$i] = $a->item(0)->childNodes->item(0)->nodeValue."*".
		  			   $b->item(0)->childNodes->item(0)->nodeValue."*".
					   $c->item(0)->childNodes->item(0)->nodeValue;
			if(DEBUGMODE)
				{	echo  $a->item(0)->childNodes->item(0)->nodeValue."*".
		  			   $b->item(0)->childNodes->item(0)->nodeValue."*".
					   $c->item(0)->childNodes->item(0)->nodeValue ."<hr>";
				}
		}		
		return $array;
	}
	
	function getAllServicesInServiceType($service_type)
	{
		$array = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($this->services_url);		
		$x=$xmlDoc->getElementsByTagName('Service');
		$counter = 0;	
		for($i=0; $i<($x->length); $i++)
  		{
		  
		  $a=$x->item($i)->getElementsByTagName('ServiceTypeID');
		  $b=$x->item($i)->getElementsByTagName('ServiceID');
		  $c=$x->item($i)->getElementsByTagName('ServiceName');
		  $d=$x->item($i)->getElementsByTagName('ServiceDescription');
		  
		  if($a->item(0)->childNodes->item(0)->nodeValue == $service_type)
		  { 
			  $array[$counter] = $a->item(0)->childNodes->item(0)->nodeValue."*".
						   $b->item(0)->childNodes->item(0)->nodeValue."*".
						   $c->item(0)->childNodes->item(0)->nodeValue."*".
						   $d->item(0)->childNodes->item(0)->nodeValue;
			  $counter++;	
			  
			  if(DEBUGMODE)
				{	
				  echo $a->item(0)->childNodes->item(0)->nodeValue."*".
							   $b->item(0)->childNodes->item(0)->nodeValue."*".
							   $c->item(0)->childNodes->item(0)->nodeValue."*".
							   $d->item(0)->childNodes->item(0)->nodeValue . "<hr>";
				}
		  }
		}
		return $array;
	}
	
	function getAllOptionsInService($service)
	{
		$array = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($this->options_url);		
		$x=$xmlDoc->getElementsByTagName('Option');
		$counter = 0;	
		for($i=0; $i<($x->length); $i++)
  		{
		  
		  	
		  $a=$x->item($i)->getElementsByTagName('ServiceID');
		  $b=$x->item($i)->getElementsByTagName('OptionID');
		  $c=$x->item($i)->getElementsByTagName('ParentOptionID');
		  $d=$x->item($i)->getElementsByTagName('OptionName');
		  $e=$x->item($i)->getElementsByTagName('OptionDescription');
		  $f=$x->item($i)->getElementsByTagName('OptionCode');
		  $g=$x->item($i)->getElementsByTagName('KeyWord');
		  $h=$x->item($i)->getElementsByTagName('Leaf');
		 // $i=$x->item($i)->getElementsByTagName('PrePost');
		  $j=$x->item($i)->getElementsByTagName('Amount');
		  $k=$x->item($i)->getElementsByTagName('LastUpdate');
		  
		  if(($a->item(0)->childNodes->item(0)->nodeValue == $service) && ($c->item(0)->childNodes->item(0)->nodeValue == 0))
		  { 
			  $array[$counter] = $a->item(0)->childNodes->item(0)->nodeValue."*".
						   $b->item(0)->childNodes->item(0)->nodeValue."*".
						   $c->item(0)->childNodes->item(0)->nodeValue."*".
						   $d->item(0)->childNodes->item(0)->nodeValue."*".
						   $e->item(0)->childNodes->item(0)->nodeValue."*".
						   $f->item(0)->childNodes->item(0)->nodeValue."*".
						   $g->item(0)->childNodes->item(0)->nodeValue."*".
						   $h->item(0)->childNodes->item(0)->nodeValue."*".
						  // $i->item(0)->childNodes->item(0)->nodeValue."*".
						   $j->item(0)->childNodes->item(0)->nodeValue."*".
						   $k->item(0)->childNodes->item(0)->nodeValue;
				
				$counter++;
						   
				if(DEBUGMODE)
				{	
					echo $a->item(0)->childNodes->item(0)->nodeValue."*".
							   $b->item(0)->childNodes->item(0)->nodeValue."*".
							   $c->item(0)->childNodes->item(0)->nodeValue."*".
							   $d->item(0)->childNodes->item(0)->nodeValue."*".
							  $e->item(0)->childNodes->item(0)->nodeValue."*".
								$f->item(0)->childNodes->item(0)->nodeValue."*".
							   $g->item(0)->childNodes->item(0)->nodeValue."*".
							   $h->item(0)->childNodes->item(0)->nodeValue."*".
							  // $i->item(0)->childNodes->item(0)->nodeValue."*".
							   $j->item(0)->childNodes->item(0)->nodeValue."*".
							   $k->item(0)->childNodes->item(0)->nodeValue."<hr>";
				}
		  }
		}
		return $array;
	}
	
	function getAllOptionsInOption($option=1)
	{
		$array = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($this->options_url);		
		$x=$xmlDoc->getElementsByTagName('Option');
		$counter = 0;	
		for($i=0; $i<($x->length); $i++)
  		{
		  
		  
		  $a=$x->item($i)->getElementsByTagName('ServiceID');
		  $b=$x->item($i)->getElementsByTagName('OptionID');
		  $c=$x->item($i)->getElementsByTagName('ParentOptionID');
		  $d=$x->item($i)->getElementsByTagName('OptionName');
		  $e=$x->item($i)->getElementsByTagName('OptionDescription');
		  $f=$x->item($i)->getElementsByTagName('OptionCode');
		  $g=$x->item($i)->getElementsByTagName('KeyWord');
		  $h=$x->item($i)->getElementsByTagName('Leaf');
		 // $i=$x->item($i)->getElementsByTagName('PrePost');
		  $j=$x->item($i)->getElementsByTagName('Amount');
		  $k=$x->item($i)->getElementsByTagName('LastUpdate');
		  
		  if($c->item(0)->childNodes->item(0)->nodeValue == $option)
		  { 
			  $array[$counter] = $a->item(0)->childNodes->item(0)->nodeValue."*".
						   $b->item(0)->childNodes->item(0)->nodeValue."*".
						   $c->item(0)->childNodes->item(0)->nodeValue."*".
						   $d->item(0)->childNodes->item(0)->nodeValue."*".
						   $e->item(0)->childNodes->item(0)->nodeValue."*".
						   $f->item(0)->childNodes->item(0)->nodeValue."*".
						   $g->item(0)->childNodes->item(0)->nodeValue."*".
						   $h->item(0)->childNodes->item(0)->nodeValue."*".
						  // $i->item(0)->childNodes->item(0)->nodeValue."*".
						   $j->item(0)->childNodes->item(0)->nodeValue."*".
						   $k->item(0)->childNodes->item(0)->nodeValue;
				
				$counter++;	
						   
				if(DEBUGMODE)
				{	
					echo $a->item(0)->childNodes->item(0)->nodeValue."*".
							   $b->item(0)->childNodes->item(0)->nodeValue."*".
							   $c->item(0)->childNodes->item(0)->nodeValue."*".
							   $d->item(0)->childNodes->item(0)->nodeValue."*".
							  $e->item(0)->childNodes->item(0)->nodeValue."*".
								$f->item(0)->childNodes->item(0)->nodeValue."*".
							   $g->item(0)->childNodes->item(0)->nodeValue."*".
							   $h->item(0)->childNodes->item(0)->nodeValue."*".
							  // $i->item(0)->childNodes->item(0)->nodeValue."*".
							   $j->item(0)->childNodes->item(0)->nodeValue."*".
							   $k->item(0)->childNodes->item(0)->nodeValue."<hr>";
				}
		  }
		}
		return $array;
	}
	
	function getAllInputsInOption($option)
	{
		$array = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($this->inputs_url);		
		$x=$xmlDoc->getElementsByTagName('OptionInput');
		$counter = 0;	
		for($i=0; $i<($x->length); $i++)
  		{
		  
		  $a=$x->item($i)->getElementsByTagName('OptionID');
		  $b=$x->item($i)->getElementsByTagName('InputID');
		  $c=$x->item($i)->getElementsByTagName('DataType');
		  $d=$x->item($i)->getElementsByTagName('MaxInput');
		  $e=$x->item($i)->getElementsByTagName('MinInput');
		  $f=$x->item($i)->getElementsByTagName('Mask');
		  $g=$x->item($i)->getElementsByTagName('Mandatory');
		  $h=$x->item($i)->getElementsByTagName('Name');
		 // $i=$x->item($i)->getElementsByTagName('Description');
		  $j=$x->item($i)->getElementsByTagName('Default');
		  $k=$x->item($i)->getElementsByTagName('Sequence');
		  $l=$x->item($i)->getElementsByTagName('Password');
				  
		  if($a->item(0)->childNodes->item(0)->nodeValue == $option)
		  { 
			 $array[$counter] = $a->item(0)->childNodes->item(0)->nodeValue."*".
						   $b->item(0)->childNodes->item(0)->nodeValue."*".
						   $c->item(0)->childNodes->item(0)->nodeValue."*".
						   $d->item(0)->childNodes->item(0)->nodeValue."*".
						   $e->item(0)->childNodes->item(0)->nodeValue."*".
						   $f->item(0)->childNodes->item(0)->nodeValue."*".
						   $g->item(0)->childNodes->item(0)->nodeValue."*".
						   $h->item(0)->childNodes->item(0)->nodeValue."*".
						   //$i->item(0)->childNodes->item(0)->nodeValue."*";
						   $j->item(0)->childNodes->item(0)->nodeValue."*".
						   $k->item(0)->childNodes->item(0)->nodeValue."*".
						   $l->item(0)->childNodes->item(0)->nodeValue;
						   
			 $counter++;	
			 
			 if(DEBUGMODE)
				{	
					echo $a->item(0)->childNodes->item(0)->nodeValue."*".
								   $b->item(0)->childNodes->item(0)->nodeValue."*".
								   $c->item(0)->childNodes->item(0)->nodeValue."*".
								   $d->item(0)->childNodes->item(0)->nodeValue."*".
								   $e->item(0)->childNodes->item(0)->nodeValue."*".
								   $f->item(0)->childNodes->item(0)->nodeValue."*".
								   $g->item(0)->childNodes->item(0)->nodeValue."*".
								   $h->item(0)->childNodes->item(0)->nodeValue."*".
								   //$i->item(0)->childNodes->item(0)->nodeValue."*".
								   $j->item(0)->childNodes->item(0)->nodeValue."*".
								   $k->item(0)->childNodes->item(0)->nodeValue."*".
								   $l->item(0)->childNodes->item(0)->nodeValue . "<hr>";
				}
		  }
		}
		return $array;
	}	
	
	function getServiceTypeNameByOptionID($option_id)
	{
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($this->options_url);		
		$x=$xmlDoc->getElementsByTagName('Option');
			
		for($i=0; $i<($x->length); $i++)
  		{
		  $a=$x->item($i)->getElementsByTagName('ServiceID');
		  $b=$x->item($i)->getElementsByTagName('OptionID');
		  
		  if($b->item(0)->childNodes->item(0)->nodeValue == $option_id)
		  { 
				$service_id = $a->item(0)->childNodes->item(0)->nodeValue;
				//echo "---".$service_id;
				$xmlDoc->load($this->services_url);		
				$x=$xmlDoc->getElementsByTagName('Service');
				
				for($i=0; $i<($x->length); $i++)
				{
				  $a=$x->item($i)->getElementsByTagName('ServiceTypeID');
		  		  $b=$x->item($i)->getElementsByTagName('ServiceID');
				  
				  if($b->item(0)->childNodes->item(0)->nodeValue == $service_id)
				  { 
						$service_type_id = $a->item(0)->childNodes->item(0)->nodeValue;
						//echo "---".$service_type_id;
						$xmlDoc = new DOMDocument();
						$xmlDoc->load($this->service_type_url);		
						$x=$xmlDoc->getElementsByTagName('ServiceType');
						
						for($i=0; $i<($x->length); $i++)
						{
						  $a=$x->item($i)->getElementsByTagName('ServiceTypeID');
						  $b=$x->item($i)->getElementsByTagName('Name');
						  if($a->item(0)->childNodes->item(0)->nodeValue == $service_type_id)
				  		  {
							   return $b->item(0)->childNodes->item(0)->nodeValue;
						  }						  
						}
				   }				  
				 }
		   }
		}
		return "NOT FOUND";
	}
	
	
	function getNumberOfInputsInOptionCode($option_id)
	{
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($this->inputs_url);		
		$x=$xmlDoc->getElementsByTagName('OptionInput');
		$counter = 0;	
		for($i=0; $i<($x->length); $i++)
  		{
		  
		  $a=$x->item($i)->getElementsByTagName('OptionID');
		  $b=$x->item($i)->getElementsByTagName('InputID');
		  $c=$x->item($i)->getElementsByTagName('DataType');
		  $d=$x->item($i)->getElementsByTagName('MaxInput');
		  $e=$x->item($i)->getElementsByTagName('MinInput');
		  $f=$x->item($i)->getElementsByTagName('Mask');
		  $g=$x->item($i)->getElementsByTagName('Mandatory');
		  $h=$x->item($i)->getElementsByTagName('Name');
		 // $i=$x->item($i)->getElementsByTagName('Description');
		  $j=$x->item($i)->getElementsByTagName('Default');
		  $k=$x->item($i)->getElementsByTagName('Sequence');
				  
		  if($a->item(0)->childNodes->item(0)->nodeValue == $option_id)
		  { 
						  
			 $counter++;				 

		  }
		}
		return $counter;
	}
}

?> 
