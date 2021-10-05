<?php

namespace Ajtarragona\Tsystems\Models;

use Ajtarragona\Tsystems\Helpers\TSHelpers;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TSModel
{
    protected static $namespace="";
    protected static $root_node="root";
    protected static $return_uppercase = true;

    protected $model_cast=null;

    public static function returnUpper($msg){
        if(static::$return_uppercase) return strtoupper($msg);
        else return $msg;
    }

    public static function namespacedTag($tagname){
        if(static::$namespace) return static::$namespace.":".self::returnUpper($tagname);
        else return self::returnUpper($tagname);
    }


   

    public static function cast($object)
    {
        
        // dd($object);
        if(is_assoc($object)) $object=to_object($object);
        TSHelpers::uppercaseKeys($object);
       
        // dump("CAST",$object);
        // dump(static::$namespace.":".strtoupper(static::$root_node));
        
        //si el root es el nom de l'objecte
        
       
        if(isset($object->{ self::namespacedTag(static::$root_node) })){
            $attributes= $object->{ self::namespacedTag(static::$root_node)} ?? null;
        }else{
            $attributes=$object;
        }
        
        
        if(!$attributes) return null;

        if(is_array($attributes)){
            //hay varios resultados
            $ret=[];
            foreach($attributes as $obj){
                $ret[]=static::cast($obj);
            }
            return $ret;
        }else{
            TSHelpers::removeNamespacesKeys($attributes);
            
            $classname=get_called_class();
            $classattributes= get_class_vars($classname);
            $classattributes=Arr::except($classattributes, ["namespace","root_node"]);
            // dump($classattributes);
            $new = new $classname;
            
            foreach($classattributes as $property=>$value)
            {
                $object_property= self::namespacedTag($property); //  self::$namespace ? (self::$namespace.":".self::returnUpper($property)) : self::returnUpper($property) ;
                // dump($property,$object_property);
                if(isset($attributes->{$object_property})) $new->$property =  $attributes->{$object_property} ?? null;

                
            }
            // dd($new->model_cast, $new);
            // dump($new);
            // dd($new);
            if($new->model_cast){
                foreach($new->model_cast  as $attr=>$classname){

                    if(isset($new->{$attr}) && $new->{$attr}){
                        $newmodel= new $classname;
                        // dd($newmodel);
                        if(isset($new->{$attr}->{strtoupper($newmodel::$root_node)})){
                            $values=$new->{$attr}->{strtoupper($newmodel::$root_node)};
                        }else{
                            $values=$new->{$attr};
                        }
                        // dd($values);
                        $tmp=[];
                        if(is_array($values)){
                            foreach($values as $value){
                                $tmp[]=$classname::cast($value);
                            }
                        }else{
                            // dd($values);
                            $tmp[]=$classname::cast($values);
                        }


                        $new->{$attr}=$tmp;
                    }

                }
            }

            return $new;
        }
    }

    
}