@extends('ajtarragona-web-components::layout/master-sidebar')

@section('title')
	@lang($empadronat ? __(':id : :name', ['id'=>$empadronat->getDni(), 'name'=>$empadronat->getNomComplet()]) : 'No Empadronat')
@endsection


@section('breadcrumb')

    @breadcrumb([
    	'items'=> [
    		['name'=>("Home"), 'route'=> 'tsystems.home'],
    		['name'=>("Padró"), 'route'=> 'tsystems.padro.home'],
    		['name'=> $empadronat ? __(":id : :name", ['id'=>$empadronat->getDni(), 'name'=>$empadronat->getNomComplet()]) : ('No Empadronat') ]
    	]

    ])
	
@endsection
            


@section('actions')
	{{-- <label for="save-tercer-btn" role="button" class="btn btn-primary btn-sm" tabindex="1">
		 @icon('save') @lang('Guardar')
	</label> --}}

	{{-- @form([
		'method'=>'DELETE',
		'class' => 'd-inline-block',
		'action'=>route('accede.tercer.delete',[$tercer->codigoTercero]),
		'data'=>['confirm'=>('S&apos;esborrarà definitivament el tercer. N&apos;estàs segur?')]
	])
		@button(['type'=>'submit','size'=>'sm','style'=>'danger']) @icon('disk') @icon('trash') Eliminar tercer @endbutton
	@endform --}}
@endsection



@section('menu')
   @include('tsystems::menu')
@endsection



@section('body')
	<div class="pt-3">


		@row
			@col(['size'=>5])
				{{-- @form([
					'method'=>'POST',
					'action'=>route('accede.padro.save',[$tercer->dboid])
				]) --}}
			
					@include('tsystems::padro._fields',["readonly"=>true])
				
					{{-- @button(['type'=>'submit','size'=>'sm','id'=>'save-tercer-btn','hidden'=>true]) @icon('disk') Guardar @endbutton --}}

				{{-- @endform --}}
				
			@endcol


			@col(['size'=>7])
				
				@tabs(['underlined'=>true])
					
					@tab(['href'=>'#padro-adreces','active'=>true,'persist'=>'padro'])
						Adreces
					@endtab
					@tab(['href'=>'#padro-familia','persist'=>'padro'])
						Familiars
					@endtab
				@endtabs

				@tabcontent
				
					@tabpane(['id'=>'padro-adreces','active'=>true,'persist'=>'padro'])
						<ul class="list-group mt-3">
						@if(is_array($empadronat->direccion))
							@foreach($empadronat->direccion as $direccion)
								@include('tsystems::padro._adreca',['adreca'=>$direccion])
							@endforeach
						@else
							@include('tsystems::padro._adreca',['adreca'=>$empadronat->direccion])
						@endif
						</ul>
					@endtabpane
					@tabpane(['id'=>'padro-familia','persist'=>'padro'])
						@include('tsystems::padro._searchresults',['empadronats'=>$familiars])
					
					@endtabpane
				@endtabcontent

			@endcol
		@endrow
	</div>
@endsection
