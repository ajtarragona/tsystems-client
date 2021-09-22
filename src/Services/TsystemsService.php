<?php

namespace Ajtarragona\Tsystems\Services;

use Ajtarragona\Tsystems\Exceptions\TsystemsAuthException;
use Ajtarragona\Tsystems\Exceptions\TSystemsOperationException;
use Ajtarragona\Tsystems\Traits\CanReturnCached;
use App\Helpers\XML2Array;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SoapClient;
use SoapVar;


class TsystemsService
{

    use CanReturnCached;

    private $options;

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



    protected function call($method, $arguments=[]){

        $token =  $this->login();
        // dump($token);
        // $hash = $this->getHash($method, $token, $arguments);
		// return $this->returnCached($hash, function() use ($arguments, $token){

            
            $data=to_xml([
                $method => [
                    "Request"=>$arguments
                ]
            ],[
                "root_node"=>"BdtServices", 
                "header"=>true,
                 "xmlns"=>"http://dto.bdt.buroweb.conecta.es" ,
                 "xmlns:xsd"=>"http://www.w3.org/2001/XMLSchema",
                 "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance"
            ]);

            // dd($data);

            $data=str_replace("\n","",$data);


            $xml=to_xml([
                "application"=>"BUROWEB",
                "businessName"=>"BdtServices",
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
            // dd($results);
            return $this->parseResults($method,$results);
            
        // });
         
        
    }

    private function parseResults($method,$results){
        if(!$results->doOperationTAOReturn ) throw new TSystemsOperationException("Operation could not run");
        // dump($results->doOperationTAOReturn);
        // dump($results->doOperationTAOReturn);
        $response=XML2Array::createObject($results->doOperationTAOReturn);
       
        // dd($response);

        if(isset($response->taoServiceResponse) && $response->taoServiceResponse->resultCode =="OK"){
            // dump($response->taoServiceResponse->data);
            $data=XML2Array::createObject($response->taoServiceResponse->data->{"@value"}); //, 'SimpleXMLElement', LIBXML_NOCDATA);
            // dd($data);
            // var_dump($data->asXML());
            // die();
            // dd($data->{$method});

            $response=$data->{"ns2:BdtServices"}->{"ns2:".$method}->{"ns2:Response"} ?? null;

            if(!$response) throw new TSystemsOperationException("Error parsing response");

            if($response->ERROR){
                throw new TSystemsOperationException($response->ERROR->DESCRIPTION);
            }else{
                return $response;
            }


        }else{
            throw new TSystemsOperationException($response->resultMessage);
        }


    }
      

}