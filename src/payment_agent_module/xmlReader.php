<?php

class menu{

function getServiceTypes(){


		// consuming service types

		global $length;
		$serviceTypes = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load('http://192.168.100.13/ccnwap/serviceTypes.xml');
		$x=$xmlDoc->getElementsByTagName('ServiceTypes');

		$length=$x->length;

	for($i=0; $i<($length); $i++)
  		{

		$a=$xmlDoc->getElementsByTagName('ServiceTypeID');
		$b=$xmlDoc->getElementsByTagName('ServiceTypeName');
		$c=$xmlDoc->getElementsByTagName('Description');
		$d=$xmlDoc->getElementsByTagName('OptionCode');
		$e=$xmlDoc->getElementsByTagName('InputId');
		$f=$xmlDoc->getElementsByTagName('Price');
		$g=$xmlDoc->getElementsByTagName('CategoryIdentifier');
		$h=$xmlDoc->getElementsByTagName('Image');



				$serviceTypes[$i]=  $a->item($i)->nodeValue."*".
									$b->item($i)->nodeValue."*".
									$c->item($i)->nodeValue."*".
									$d->item($i)->nodeValue."*".
									$e->item($i)->nodeValue."*".
									$f->item($i)->nodeValue."*".
									$g->item($i)->nodeValue."*".
									$h->item($i)->nodeValue."#";


		}
return $serviceTypes;
}

function getServices($serviceTypeId){


		// consuming services

		global $lengthServices;
		$services = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load('http://192.168.100.13/ccnwap/services.xml');
		$x=$xmlDoc->getElementsByTagName('Services');


		$lengthServices=$x->length;
		for($i=0; $i<($lengthServices); $i++)
  		{

		$a=$xmlDoc->getElementsByTagName('ServiceTypeId');
		$b=$xmlDoc->getElementsByTagName('ServiceId');
		$c=$xmlDoc->getElementsByTagName('ServiceName');
		$d=$xmlDoc->getElementsByTagName('Description');
		$e=$xmlDoc->getElementsByTagName('OptionCode');
		$f=$xmlDoc->getElementsByTagName('InputId');
		$g=$xmlDoc->getElementsByTagName('Price');
		$h=$xmlDoc->getElementsByTagName('CategoryIdentifier');

			if($a->item($i)->nodeValue==$serviceTypeId){
							$services[$i]= $a->item($i)->nodeValue."*".
											$b->item($i)->nodeValue."*".
											$c->item($i)->nodeValue."*".
											$d->item($i)->nodeValue."*".
											$e->item($i)->nodeValue."*".
											$f->item($i)->nodeValue."*".
											$g->item($i)->nodeValue."*".
											$g->item($i)->nodeValue."#";

		 												}



		}
return $services;
}

function getOptions($serviceId){


		// consuming options

		global $lengthOptions;
		$options = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load('http://192.168.100.13/ccnwap/options.xml');
		$x=$xmlDoc->getElementsByTagName('Options');

		$lengthOptions=$x->length;
		for($i=0; $i<($lengthOptions); $i++)
  		{

		$a=$xmlDoc->getElementsByTagName('ServiceId');
		$b=$xmlDoc->getElementsByTagName('OptionId');
		$c=$xmlDoc->getElementsByTagName('OptionName');
		$d=$xmlDoc->getElementsByTagName('Price');
		$e=$xmlDoc->getElementsByTagName('Description');
		$f=$xmlDoc->getElementsByTagName('OptionCode');
		$g=$xmlDoc->getElementsByTagName('InputId');
		$h=$xmlDoc->getElementsByTagName('CategoryIdentifier');

					if($a->item($i)->nodeValue==$serviceId){

							$options[$i]= $a->item($i)->nodeValue."*".
											$b->item($i)->nodeValue."*".
											$c->item($i)->nodeValue."*".
											$d->item($i)->nodeValue."*".
											$e->item($i)->nodeValue."*".
											$f->item($i)->nodeValue."*".
											$g->item($i)->nodeValue."*".
											$h->item($i)->nodeValue."#";
		 										}


		}
return $options;
}

function getSubOptions($optionId){


		// consuming sub options

		global $lengthSubOptions;
		$subOptions = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load('http://192.168.100.13/ccnwap/subOptions.xml');
		$x=$xmlDoc->getElementsByTagName('SubOptions');

		$lengthSubOptions=$x->length;
		for($i=0; $i<($lengthSubOptions); $i++)
  		{

		$a=$xmlDoc->getElementsByTagName('OptionId');
		$b=$xmlDoc->getElementsByTagName('SubOptionId');
		$c=$xmlDoc->getElementsByTagName('SubOptionName');
		$d=$xmlDoc->getElementsByTagName('Description');
		$e=$xmlDoc->getElementsByTagName('OptionCode');
		$f=$xmlDoc->getElementsByTagName('InputId');
		$g=$xmlDoc->getElementsByTagName('Price');

					if($a->item($i)->nodeValue==$optionId){
							$subOptions[$i]= $a->item($i)->nodeValue."*".
												$b->item($i)->nodeValue."*".
												$c->item($i)->nodeValue."*".
												$d->item($i)->nodeValue."*".
												$e->item($i)->nodeValue."*".
												$f->item($i)->nodeValue."*".
												$g->item($i)->nodeValue."#";

		 													}

		}
return $subOptions;
}

function getSubSubOptions($optionId){


		// consuming sub sub options

		global $lengthSubOptions;
		$subSubOptions = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load('http://192.168.100.13/ccnwap/subSubOptions.xml');
		$x=$xmlDoc->getElementsByTagName('SubSubOptions');

		$lengthSubSubOptions=$x->length;
		for($i=0; $i<($lengthSubSubOptions); $i++)
  		{

		$a=$xmlDoc->getElementsByTagName('SubOptionId');
		$b=$xmlDoc->getElementsByTagName('SubSubOptionId');
		$c=$xmlDoc->getElementsByTagName('SubSubOptionName');
		$d=$xmlDoc->getElementsByTagName('Description');
		$e=$xmlDoc->getElementsByTagName('OptionCode');
		$f=$xmlDoc->getElementsByTagName('InputId');
		$g=$xmlDoc->getElementsByTagName('Price');

					if($a->item($i)->nodeValue==$optionId){
							$subSubOptions[$i]= $a->item($i)->nodeValue."*".
												$b->item($i)->nodeValue."*".
												$c->item($i)->nodeValue."*".
												$d->item($i)->nodeValue."*".
												$e->item($i)->nodeValue."*".
												$f->item($i)->nodeValue."*".
												$g->item($i)->nodeValue."#";

		 													}

		}
return $subSubOptions;
}



function getOptionInputs($originId){


		// option inputs

		global $lengthOptionsInputs;
		$array = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load('http://192.168.100.13/ccnwap/optionInputs.xml');
		$x=$xmlDoc->getElementsByTagName('OptionsInputs');


		$lengthOptionsInputs=$x->length;

		global $count;
		$count=0;
		for($i=0; $i<=($lengthOptionsInputs); $i++)
  		{


		$a=$xmlDoc->getElementsByTagName('InputName');
		$b=$xmlDoc->getElementsByTagName('Id');
		$c=$xmlDoc->getElementsByTagName('Type');
		$d=$xmlDoc->getElementsByTagName('MaxCharacter');
		$e=$xmlDoc->getElementsByTagName('Description');
		$f=$xmlDoc->getElementsByTagName('OriginId');
		$g=$xmlDoc->getElementsByTagName('Default');
		$h=$xmlDoc->getElementsByTagName('ReadOnly');




		if($x->item($i)->nodeValue==$originId)
		{
								$array[$count]=$a->item($i)->nodeValue."*".
										   $b->item($i)->nodeValue."*".
										   $c->item($i)->nodeValue."*".
										   $d->item($i)->nodeValue."*".
										   $e->item($i)->nodeValue."*".
										   $f->item($i)->nodeValue."*".
										   $g->item($i)->nodeValue."*".
										   $h->item($i)->nodeValue;
							$count++;

		}



		}
return $array;
}


function getFundsInputs($fundsSourceId){


		// consuming funds inputs

		global $lengthFundsInputs;
		$fundsInputs = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load('http://192.168.100.13/ccnwap/fundsInputs.xml');
		$x=$xmlDoc->getElementsByTagName('OriginId');

		$lengthOptionInputs=$x->length;
		for($i=0; $i<($lengthOptionInputs); $i++)
  		{

		$a=$xmlDoc->getElementsByTagName('OriginId');
		$b=$xmlDoc->getElementsByTagName('InputId');
		$c=$xmlDoc->getElementsByTagName('InputName');
		$d=$xmlDoc->getElementsByTagName('Id');
		$e=$xmlDoc->getElementsByTagName('Type');
		$f=$xmlDoc->getElementsByTagName('MaxCharacter');
		$g=$xmlDoc->getElementsByTagName('Default');
		$h=$xmlDoc->getElementsByTagName('Description');
		$i=$xmlDoc->getElementsByTagName('Order');

				if($a->item($i)->nodeValue==$fundsSourceId){
							$fundsInputs[$i]= $a->item($i)->nodeValue."*".
												$b->item($i)->nodeValue."*".
												$c->item($i)->nodeValue."*".
												$d->item($i)->nodeValue."*".
												$e->item($i)->nodeValue."*".
												$f->item($i)->nodeValue."*".
												$g->item($i)->nodeValue."*".
												$h->item($i)->nodeValue."*".
												$i->item($i)->nodeValue."#";
		 													}

		}
return $fundsInputs;
}

function getKeyWords($optionCode){


		// consuming options junction

		global $lengthKeywords;
		$kewords = Array();
		$xmlDoc = new DOMDocument();
		$xmlDoc->load('http://192.168.100.13/ccnwap/optionsJunction.xml');
		$x=$xmlDoc->getElementsByTagName('OptionsJunction');

		$lengthKeywords=$x->length;
		$c=0;
		for($i=0; $i<($lengthKeywords); $i++)
  		{

		$a=$xmlDoc->getElementsByTagName('KeyWord');
		$b=$xmlDoc->getElementsByTagName('OptionCode');
		$d=$xmlDoc->getElementsByTagName('OptionId');

				if($b->item($i)->nodeValue==$optionCode){
							$kewords[$c]= $a->item($i)->nodeValue."*".
											$b->item($i)->nodeValue."*".
											$d->item($i)->nodeValue."#";
		 													}
		$C++;
		}
return $kewords;
	}

}// end of the class menu


?>
