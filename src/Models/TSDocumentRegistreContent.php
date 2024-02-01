<?php

namespace Ajtarragona\Tsystems\Models;


class TSDocumentRegistreContent extends TSModel
{
    
    
    protected static $root_node="Documentcontent";

    
       public $dboid;
       public $cud;
       public $ntielaboration;
       public $ntiorigin;
       public $mimetype;
       public $addtype;
       public $itemrequired;
       public $signrequired;
       public $signed;
       public $espublico;
    
}