<?php

namespace Ajtarragona\Tsystems\Models;


class TSDocumentRegistre extends TSModel
{
    
    
    protected static $root_node="Document";

    public $name;
    public $documenttype;
    public $documenttypecode;
    public $description;
    public $documentcontent;
    public $docdescription;
    
    public $espublico;
    public $cud;
    public $dboid;
    public $mimetype;
    public $ntielaboration;
    public $ntiorigin;
    public $filename;
    public $fileextension;
          
    // protected $model_cast = [
    //     'documentcontent' => '\Ajtarragona\Tsystems\Models\TSDocumentRegistreContent'
    //   ];
//    DOCUMENTCONTENT&gt;
//         &lt;DBOID&gt;2013600057735094207659&lt;\/DBOID&gt;
//         &lt;CUD&gt;15246261223272477327&lt;\/CUD&gt;
//         &lt;NTIELABORATION&gt;EE01&lt;\/NTIELABORATION&gt;
//         &lt;NTIORIGIN&gt;1&lt;\/NTIORIGIN&gt;
//         &lt;MIMETYPE&gt;application\/pdf&lt;\/MIMETYPE&gt;
//         &lt;ADDTYPE&gt;S&lt;\/ADDTYPE&gt;
//         &lt;ITEMREQUIRED&gt;false&lt;\/ITEMREQUIRED&gt;
//         &lt;SIGNREQUIRED&gt;true&lt;\/SIGNREQUIRED&gt;
//         &lt;SIGNED&gt;true&lt;\/SIGNED&gt;
//         &lt;ESPUBLICO&gt;true&lt;\/ESPUBLICO&gt;
    
}