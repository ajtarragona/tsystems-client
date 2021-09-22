<?php

namespace Ajtarragona\Tsystems\Models;

class TSPerson extends TSModel
{
    protected static $root_node="person";

    public $vatacronym;
    public $idnumber;
    public $ctrldigit;
    public $name;
    public $fullname;
    public $familyname;
    public $famnamepart;
    public $secondname;
    public $secnamepart;
    public $cianame;
    public $persontype;

    public $addresses;

    
    public static function cast($object)
    {
        $person=parent::cast($object);

        
        if($person->addresses){
            $addresses=$person->addresses->{"ns2:ADDRESS"};
            $tmp=[];
            if(is_array($addresses)){
                foreach($addresses as $address){
                    $tmp[]=TSAddress::cast($address);
                }
            }else{
                $tmp[]=TSAddress::cast($person->addresses);
            }
            $person->addresses=$tmp;
        }
        return $person;
    }
}
