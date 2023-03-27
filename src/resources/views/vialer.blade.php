@extends('ajtarragona-web-components::layout/master-sidebar')

@section('title')
	@lang('Accede Home')
@endsection



@section('breadcrumb')
    @breadcrumb([
    	'items'=> [
    		['name'=>("Vialer")]
    	]
    ])
@endsection


@section('menu')
   @include('tsystems::menu')
@endsection


@section('body')
	<div class="pt-3">
		
		@form(['method'=>'POST','action'=>route('accede.home')])
			<div 
				class="vialer-container" 
				data-current-pais="{{ $currentPais->codigoPais }}" 
				data-current-provincia="{{ $currentProvincia->codigoProvincia }}" 
				data-current-municipi="{{ $currentMunicipi->codigoMunicipio }}"
				data-fields=""
			>
				<input type="hidden" name="vialer-value" class="form-control"/>
				
						
				@select([
					"name"=>"pais",
					"required"=>false,
					'class' => 'field_pais',
					"label"=>"Pais",
					"options"=>[],
					'data'=>['width'=>'100%','live-search'=>true,'show-deselector'=>true],
					
				])
				
			
				@select([
					"name"=>"provincia",
					"required"=>false,
					'class' => 'field_provincia',
					"label"=>"Provincia",
					"options"=>[],
					'disabled'=>true,
					'data'=>['width'=>'100%','live-search'=>true,'show-deselector'=>true],
					
				])
				
			
				@select([
					"name"=>"municipi",
					"required"=>false,
					'class' => 'field_municipi',
					"label"=>"Municipi",
					"options"=>[],
					'disabled'=>true,
					'data'=>['width'=>'100%','live-search'=>true,'show-deselector'=>true],
					
				])
				
					
				<div class="adreca_codificada">
					
						
					@input([
						'label'=>'Carrer', 
						'name'=>'carrer',
						'class'=> 'field_carrer autocomplete form-control',
						'value' => '',
						'data' => [
							'multiple'=> false,
							'url' => route('accede.vies.combo',[$currentProvincia->codigoProvincia,$currentMunicipi->codigoMunicipio
							]),
							'value' => '',
							'savevalue' => true,
							'showvalue' => false,
						],
						'icon' => 'map-marker-alt'
					])

							
					@row(['class'=>'gap-sm'])	
					
						@col
							@select([
								"name"=>"numero",
								"required"=>false,
								'class' => 'field_numero',
								"label"=>"Numero",
								"disabled" =>true,
								"options"=>[],
								'data'=>['width'=>'100%','live-search'=>true,'show-deselector'=>true],
								
							])
						@endcol
						@col
							@select([
								"name"=>"lletra",
								"required"=>false,
								'class' => 'field_lletra',
								"label"=>"Lletra",
								"disabled" =>true,
								"options"=>[],
								'data'=>['width'=>'100%','live-search'=>true,'show-deselector'=>true],
								
							])
						@endcol

						@col
							@select([
								"name"=>"bloc",
								"required"=>false,
								'class' => 'field_bloc',
								"label"=>"Bloc",
								"disabled" =>true,
								"options"=>[],
								'data'=>['width'=>'100%','live-search'=>false,'show-deselector'=>true],
								
							])
						@endcol
						@col
							@select([
								"name"=>"escala",
								"required"=>false,
								'class' => 'field_escala',
								"label"=>"Escala",
								"disabled" =>true,
								"options"=>[],
								'data'=>['width'=>'100%','live-search'=>false,'show-deselector'=>true],
								
							])
						@endcol
						

						@col
							@select([
								"name"=>"planta",
								"required"=>false,
								'class' => 'field_planta',
								"label"=>"Planta",
								"disabled" =>true,
								"options"=>[],
								'data'=>['width'=>'100%','live-search'=>false,'show-deselector'=>true],
								
							])
						@endcol
						@col
							@select([
								"name"=>"porta",
								"required"=>false,
								'class' => 'field_porta',
								"label"=>"Porta",
								"disabled" =>true,
								"options"=>[],
								'data'=>['width'=>'100%','live-search'=>false,'show-deselector'=>true],
								
							])
						@endcol
						
						@col
							@input([
								"name"=>"km",
								"required"=>false,
								'class' => 'field_km form-control',
								"label"=>"Km.",
								"disabled" =>false,
							])
						@endcol


						@col
							@select([
								"name"=>"codipostal",
								"required"=>false,
								'class' => 'field_codipostal',
								"label"=>"Codi Postal",
								"disabled" =>true,
								"options"=>[],
								'data'=>['width'=>'100%','live-search'=>false,'show-deselector'=>true],
								
							])
						@endcol
					@endrow
				</div>
				<div class="adreca_lliure">
					@input([
						'label'=>'Adreça', 
						'name'=>'adreca_lliure',
						'class'=> 'field_adreca form-control',
						'value' => '',
						'icon' => 'map-marker-alt'
					])
				</div>
			</div>
			
		@endform
	</div>
@endsection


@section('style')
	<link href="{{ asset('vendor/ajtarragona/css/accede.css') }}" rel="stylesheet">
@endsection


@section('js')
	<script src="{{ asset('vendor/ajtarragona/js/accede.js')}}" language="JavaScript"></script>
@endsection
