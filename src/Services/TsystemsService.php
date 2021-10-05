<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Exceptions\TsystemsAuthException;
use Ajtarragona\Tsystems\Exceptions\TsystemsNoResultsException;
use Ajtarragona\Tsystems\Exceptions\TSystemsOperationException;
use Ajtarragona\Tsystems\Helpers\TSHelpers;
use Ajtarragona\Tsystems\Traits\CanReturnCached;
use Exception;
use Illuminate\Support\Str;
use SoapClient;
use SoapVar;


class TsystemsService
{

    use CanReturnCached;
    
    const ERROR_NO_RESULTS="0037";


    protected $options;
    protected static $business_name =  "";
    protected static $application =  "";
    protected static $xml_ns =  "";
    protected static $data_xml_rootnode =  "";
    
    public function __construct($options=array()) { 
		$opts=config('tsystems');
		if($options) $opts=array_merge($opts,$options);
		$this->options= json_decode(json_encode($opts), FALSE);

       
	}

        
    protected function client(){
        // dump($this->options->ws_url);
        return new SoapClient($this->options->ws_url.'?wsdl',
        array(
            
            'trace' => 1,
            "stream_context" => stream_context_create(
                array(
                    'ssl' => array(
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                    )
                )
            )
        ) );
    }
    /**
     * login
     *
     * @return string token
     */
    protected function login(){
       
        $ret=$this->client()->login(["user"=>$this->options->ws_user,"password"=>$this->options->ws_password]);

        $token=$ret->loginReturn ?? null;
        if(!$token) throw new TsystemsAuthException("Auth exception");

        if(Str::startsWith($token, "ERROR")){
            throw new TsystemsAuthException($token);
        }else{
            return $token;
        }
    }


    private static $default_options= [
        "lower_request" => false,
        "lower_response" => false,
        "request_method_prefix" => false,
        "response_method_prefix" => false,
    ];

 
    private function requestName($method, $options){
        $ret= $options["lower_request"] ? "request":"Request";
        if($options["request_method_prefix"]) $ret=$method.$ret;
        return $ret;

    }

    private function responseName($method, $options){
        $ret= $options["lower_response"] ? "response":"Response";
        if($options["response_method_prefix"]) $ret=$method.$ret;
        return $ret;

    }
    protected function call($method, $arguments=[], $options=[]){

        $options=array_merge(self::$default_options, $options);

        $token =  $this->login();
        // dump($token);
        // $hash = $this->getHash($method, $token, $arguments);
		// return $this->returnCached($hash, function() use ($arguments, $token){


            $data=TSHelpers::to_xml([
                $method => [
                    $this->requestName($method, $options) =>$arguments
                ]
            ],[
                "root_node"=> static::dataRootNodeName(), 
                "header"=>true,
                "xmlns"=>static::$xml_ns,
            ]);
            
            // dd($data);

            $data=str_replace("\n","",$data);


            $xml=TSHelpers::to_xml([
                "application"=>static::$application,
                "businessName"=>static::$business_name,
                "operationName"=>$method,
                "data"=>$data,
            ],["root_node"=>"taoServiceRequest", "header"=>false]);
            
            $client=$this->client();


            $xmltag = new SoapVar("<xmlIn><![CDATA[{$xml}]]></xmlIn>", XSD_ANYXML);
            $tokentag = new SoapVar("<token>{$token}</token>", XSD_ANYXML);
           
            
            $results=$client->doOperationTAO([
                'xmlIn' => $xmltag,
                'token' => $tokentag,
            ]);

            // echo "====== REQUEST HEADERS =====" . PHP_EOL;
            // dump($client->__getLastRequestHeaders());
            // echo "========= REQUEST ==========" . PHP_EOL;
            // dump($client->__getLastRequest());
            // echo "========= RESPONSE =========" . PHP_EOL;
            // dump($results);
            return $this->parseResults($method,$results,$options);
            
        // });
         
        
    }




    private static function dataRootNodeName(){
       return static::$data_xml_rootnode ? static::$data_xml_rootnode : static::$business_name;
    }

    
    private function throwErrorCode($error){
        switch($error->CODE){
            case self::ERROR_NO_RESULTS: $exception= new TsystemsNoResultsException($error->DESCRIPTION);break;
            default: $exception= new TSystemsOperationException($error->DESCRIPTION);break;
        }

        throw $exception;
    }

    private function parseResults($method,$results, $options=[]){
        // dd($results);
        if(!$results->doOperationTAOReturn ) throw new TSystemsOperationException("Operation could not run");
        // dump($results->doOperationTAOReturn);
        // dump($results->doOperationTAOReturn);
        $response=TSHelpers::from_xml($results->doOperationTAOReturn);
       
        // dd($response);
       
            if(isset($response->taoServiceResponse) && $response->taoServiceResponse->resultCode =="OK"){
                // dump($response->taoServiceResponse->data);
                $data=TSHelpers::from_xml($response->taoServiceResponse->data->{"@value"}); //, 'SimpleXMLElement', LIBXML_NOCDATA);
                
                TSHelpers::removeNamespacesKeys($data);
                // dd($data);
                if(!isset($data->{static::dataRootNodeName()}->{"".$method}->{ $this->responseName($method, $options)  })){
                    throw new TSystemsOperationException("Error parsing response");
                }else{
                    $response=$data->{static::dataRootNodeName()}->{"".$method}->{ $this->responseName($method, $options) };
                    // dump($response);
                    if($response===""){
                        throw new TsystemsNoResultsException();
                    }else{
                        TSHelpers::removeNamespacesKeys($response);

                        if(isset($response->ERROR)){
                            $this->throwErrorCode($response->ERROR);
                            
                        }else{
                            return $response;
                        }
                    }
                }


            }else{

                if(isset($response->resultMessage)){
                    throw new TSystemsOperationException($response->resultMessage);
                }else  if(isset($response->taoServiceResponse->resultMessage)){
                    throw new TSystemsOperationException($response->taoServiceResponse->resultMessage);
                }else{
                    throw new TSystemsOperationException();
                }

            }
        

    }
      

}