<?php
namespace Ajtarragona\Tsystems\Helpers;

use SimpleXMLElement;

class TSHelpers{

    public static function is_xml($content)
    {
        $content = trim($content);
        if (empty($content)) {
            return false;
        }
        //html go to hell!
        if (stripos($content, '<!DOCTYPE html>') !== false) {
            return false;
        }

        libxml_use_internal_errors(true);
        simplexml_load_string($content);
        $errors = libxml_get_errors();          
        libxml_clear_errors();  

        return empty($errors);
    }


    public static function array_to_xml($array, $options=[]) {
        return Array2XML::createXML($array, $options);
        // foreach ($array as $key => $value) {
        //     if (is_array($value)) {
        //         if (is_numeric($key)) {
        //             $key = $parent_key;
        //         }
        //         $subnode = $xml->addChild($key);
        //         self::array_to_xml($value, $subnode, $key);
        //     } else {
        //         $xml->addChild($key, $value);
        //     }
        // }
    }

    // public static function array_to_xml($array, &$xml_user_info) {
    //     foreach($array as $key => $value) {
    //         // dump($key, $value);
    //         if(is_array($value)) {
    //             if(!is_numeric($key)){
    //                 $subnode = $xml_user_info->addChild("$key");
    //                 self::array_to_xml($value, $subnode);
    //             }else{
    //                 $subnode = $xml_user_info->addChild("$key");
    //                 self::array_to_xml($value, $subnode);
    //             }
    //         }else {
    //             $xml_user_info->addChild("$key",htmlspecialchars("$value"));
    //         }
    //     }
    // }




    public static function to_xml($data, $options=null){

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

        if($options['xmlns']??false){
            $xml_array=[
                $options["root_node"] => array_merge([
                        '@attributes'=>[ 
                            'xmlns' => $options['xmlns'] ??''
                        ]
                    ],
                    $data
                )
            ];
        }else{
            $xml_array=[
                $options["root_node"] => $data
            ];
        }

        // dd($xml_array);
        /*$xml_string="";

        $xml_string.= "<?xml version=\"".$options['version']."\" encoding=\"".$options['encoding']."\" ?>";
        $xml_string.="<".$options["root_node"]."";
        if($options['xmlns']) $xml_string.=' xmlns="'.$options['xmlns'].'" ';
        if($options['xmlns:xsd']) $xml_string.=' xmlns:xsd="'.$options['xmlns:xsd'].'"';
        if($options['xmlns:xsi']) $xml_string.=' xmlns:xsi="'.$options['xmlns:xsi'].'"';
        // dd($xml_string);
        $xml_string.="></".$options["root_node"].">";*/
        // dump($xml_string);

        
        // $xml = new SimpleXMLElement($xml_string);
        // dump($xml->asXML(),$data);
        //function call to convert array to xml
        // dd($data);
        $xml=TSHelpers::array_to_xml($xml_array,$options);
        // dd("RET",$xml);
        // dd($xml, $xml->saveXML());
        // die();
        if(!$options["header"]){
            // $dom = dom_import_simplexml($xml);
            return $xml->saveXML($xml->documentElement);
        }else{
            return $xml->saveXML();
        }


    }



    public static function from_xml($xmlnode) {
        return XML2Array::createObject($xmlnode);
    } 




    /**
     * uppercase all keys
     */
    public static function uppercaseKeys(&$object){
        // dump($object, is_assoc($object));
        if(is_assoc($object)) $object=to_object($object);
        // dump($object);
        if(is_object($object)){
            foreach($object as $key=>$value){   
                // dump($key, $value);
                if(is_object($value) || is_assoc($value) ){
                    self::uppercaseKeys($value);
                }
                
                if($key!==strtoupper($key)){
                    $newkey=strtoupper($key);
                    $object->{$newkey}=$value;
                    unset($object->{$key});
                }
                

            }
        }
        // dump($object);

    }



    public static function removeNamespacesKeys(&$object){
        if(is_assoc($object)) $object=to_object($object);

        if(is_object($object)){
            foreach($object as $key=>$value){   
                // dump($key, $value);
                if(is_object($value)){
                    self::removeNamespacesKeys($value);
                }

                // dump(strpos($key,":"));
                if(strpos($key,":")!==false){
                    $newkey=substr($key, strpos($key,":") + 1);
                    $object->{$newkey}=$value;
                    unset($object->{$key});
                }

            }
        }

    }


    
    
}