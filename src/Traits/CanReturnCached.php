<?php

namespace Ajtarragona\Tsystems\Traits;


use Cache;
use Illuminate\Support\Str;

trait CanReturnCached{

    protected $cache_time= 360;

	protected function getHash($function, $token, $parameters=[]){
        
		return Str::snake(str_replace("\\","_",get_class($this))."_".$function."_".$token."_".md5(serialize($parameters)));
	}

	protected function returnCached($hash, $callable){
		if(is_callable($callable)){
			// dd($this->cache_time);
			return Cache::remember($hash, $this->cache_time, function () use ($callable) {
				return $callable();
			});
		}
		return $callable;
	}
	
}
   
