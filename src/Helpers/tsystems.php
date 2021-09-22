<?php

if (! function_exists('ts_tercers')) {
	function ts_tercers($options=false){
		return new \Ajtarragona\Tsystems\Services\TsystemsTercersService($options);
	}
}
if (! function_exists('ts_vialer')) {
	function ts_vialer($options=false){
		return new \Ajtarragona\Tsystems\Services\TsystemsVialerService($options);
	}
}
if (! function_exists('ts_padro')) {
	function ts_padro($options=false){
		return new \Ajtarragona\Tsystems\Services\TsystemsPadroService($options);
	}
}

if (! function_exists('array_to_xml')) {
	function array_to_xml($array, &$xml_user_info) {
		foreach($array as $key => $value) {
			if(is_array($value)) {
				if(!is_numeric($key)){
					$subnode = $xml_user_info->addChild("$key");
					array_to_xml($value, $subnode);
				}else{
					$subnode = $xml_user_info->addChild("item$key");
					array_to_xml($value, $subnode);
				}
			}else {
				$xml_user_info->addChild("$key",htmlspecialchars("$value"));
			}
		}
	}
}


if (! function_exists('to_xml')) {

	function to_xml($data, $options=null){

		$defaults=[
			"header" => true,
			"root_node" => "root",
			"encoding" => "UTF-8",
			"version" => "1.0",
			"case_sensitive" => false,
			"xmlns"=>false,
			"xmlns:xsd"=>false,
			"xmlns:xsi"=>false,
		];

		$options= is_array($options)? array_merge($defaults,$options) : $defaults;

		
		
		$xml_string="";

		$xml_string.= "<?xml version=\"".$options['version']."\" encoding=\"".$options['encoding']."\" ?>";
		$xml_string.="<".$options["root_node"]."";
		if($options['xmlns']) $xml_string.=' xmlns="'.$options['xmlns'].'" ';
		if($options['xmlns:xsd']) $xml_string.=' xmlns:xsd="'.$options['xmlns:xsd'].'"';
		if($options['xmlns:xsi']) $xml_string.=' xmlns:xsi="'.$options['xmlns:xsi'].'"';

		$xml_string.="></".$options["root_node"].">";
		
		$xml = new SimpleXMLElement($xml_string);
		// dump($xml->asXML(),$data);
		//function call to convert array to xml
		array_to_xml($data, $xml);
		
		if(!$options["header"]){
			$dom = dom_import_simplexml($xml);
			return $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement);
		}else{
			return $xml->asXML();
		}


	}
}

if (! function_exists('from_xml')) {
	function from_xml($xmlnode) {
		$root = (func_num_args() > 1 ? false : true);
		$jsnode = array();
	
		if (!$root) {
			if (count($xmlnode->attributes()) > 0){
				$jsnode["$"] = array();
				foreach($xmlnode->attributes() as $key => $value)
					$jsnode["$"][$key] = (string)$value;
			}
	
			$textcontent = trim((string)$xmlnode);
			if (strlen($textcontent) > 0)
				$jsnode["_"] = $textcontent;
	
			foreach ($xmlnode->children() as $childxmlnode) {
				$childname = $childxmlnode->getName();
				if (!array_key_exists($childname, $jsnode))
					$jsnode[$childname] = array();
				array_push($jsnode[$childname], from_xml($childxmlnode, true));
			}
			return $jsnode;
		} else {
			$nodename = $xmlnode->getName();
			$jsnode[$nodename] = array();
			array_push($jsnode[$nodename], from_xml($xmlnode, true));
			return json_encode($jsnode);
		}
	} 
}