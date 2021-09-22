<?php

namespace Ajtarragona\Tsystems\Models;

use Illuminate\Support\Arr;

class TSModel
{
    protected static $namespace="ns2";
    protected static $root_node="root";

    public $dboid;

    public static function cast($object)
    {
        
        if(is_array($object)) $object=to_object($object);

        // dump("CAST",$object);
        // dump(static::$namespace.":".strtoupper(static::$root_node));
        if(isset($object->{(static::$namespace.":".strtoupper(static::$root_node))})){
            $attributes= $object->{(static::$namespace.":".strtoupper(static::$root_node))} ?? null;
        }else{
            $attributes=$object;
        }
        
        // dd($attributes);
        if(!$attributes) return null;

        $classname=get_called_class();
        $classattributes= get_class_vars($classname);
        $classattributes=Arr::except($classattributes, ["namespace","root_node"]);
        // dump($classattributes);
        $new = new $classname;
        
        foreach($classattributes as $property=>$value)
        {
            $object_property=self::$namespace.":".strtoupper($property);
            if(isset($attributes->{$object_property})) $new->$property =  $attributes->{$object_property} ?? null;

            
        }

        return $new;
    }

    
}