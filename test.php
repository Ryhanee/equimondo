<?php
ini_set('soap.wsdl_cache_enabled',"0");
	$login = "EquiMondo";
	
	$password = '5jLk$cdF(7';
	
	$wsdl = "https://ws3g.ifce.fr/services/HorseEsperiProServices?WSDL";
	/****** Connexion api soap ****** **/
	$soapClients = new SoapClient($wsdl,array( 'trace' => true,
	'exceptions' => true,'login' =>$login,'password'=>$password));
	$valueId= '52816545L';
	
	$typeId="SIRE_KEY";
	$param= new StdClass();
	$param->context = new StdClass();
	$param->context->isoLangage = "fr";
	$param->context->Langage = "fr";
	$param->context->utilisateurID = "EquiMondo";
	$param->valueId = new StdClass();
	$param->valueId =$valueId;
	$param->typeId = new StdClass();
	$param->typeId =$typeId;
	/******* fnctin recherche info cheval *******/

	  $resultat=$soapClients->horseInformation($param);
      $array = json_decode(json_encode($resultat), true);
      var_dump($array);

      ?>