@extends('ajtarragona-web-components::layout/modal')

@section('title')
	@lang('Accede: nou domicili tercer')
@endsection

     

@section('body')

	
	
			
		@tabs(['align'=>'center','underlined'=>true])
			@tab(['href'=>'#tab-domicili-search','active'=>true])
				@icon('search') Buscar domicilis
			@endtab
			@tab(['href'=>'#tab-domicili-new'])
				@icon('plus') Nou domicili
			@endtab
			
		@endtabs			




		@tabcontent(['responsive'=>true,'class'=>'mt-3'])
			
			@tabpane(['active'=>true,'id'=>'tab-domicili-search'])
				
				@form([
				    'method' => 'POST', 
				    'id'=>'search-domicilis-form', 
				    'action' => route('accede.tercer.domicilis.dosearch',[$tercer->codigoTercero]),
				    'data' =>[
				    	'target'=> '#domicilis-search-results'
				    ]
				])  
					{{-- @dump($domicilisfilter) --}}
					@include('accede-client::domicilis._fields',["readonly"=>false])
					

					@button(['type'=>'submit','class'=>'btn-light','size'=>'sm']) @icon('search') Buscar @endbutton

				@endform
				<div id="domicilis-search-results"></div>
{{-- 				<hr/>
				<div class="text-right">
					@button(['type'=>'submit','size'=>'sm']) @icon('check') Afegir domicilis marcats @endbutton
				</div>
 --}}

			@endtabpane

			@tabpane(['id'=>'tab-domicili-new'])
				
				@form(['method'=>'POST','action'=>route('accede.tercer.domicilis.store',[$tercer->codigoTercero])])

					@include('accede-client::domicilis._fields',["readonly"=>false])
		
					<hr/>
					<div class="text-right">
						@button(['type'=>'submit','class'=>'btn-primary', 'size'=>'sm']) @icon('check') Afegir nou domicili @endbutton
					</div>

				@endform

			@endtabpane
			
		@endtabcontent

	
	
	
@endsection
