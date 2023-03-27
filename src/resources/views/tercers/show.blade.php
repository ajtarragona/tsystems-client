@extends('ajtarragona-web-components::layout/master-sidebar')

@section('title')
	@lang($tercer ? __('Tercer :id', ['id'=>$tercer->dboid]) : 'No tercer')
@endsection


@section('breadcrumb')

    @breadcrumb([
    	'items'=> [
    		['name'=>("Home"), 'route'=> 'tsystems.home'],
    		['name'=>("Tercers"), 'route'=> 'tsystems.tercers.home'],
    		['name'=> $tercer ? __("Tercer :id", ['id'=>$tercer->dboid]) : ('No tercer') ]
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
		'data'=>['confirm'=>__('S&apos;esborrarà definitivament el tercer. N&apos;estàs segur?')]
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
				@form([
					'method'=>'POST',
					'action'=>route('accede.tercer.save',[$tercer->dboid])
				])
			
					@include('tsystems::tercers._fields',["readonly"=>true])
				
					{{-- @button(['type'=>'submit','size'=>'sm','id'=>'save-tercer-btn','hidden'=>true]) @icon('disk') Guardar @endbutton --}}

				@endform
				
			@endcol


			@col(['size'=>7])
				
					@include('tsystems::tercers._domicilis',["adreces"=>$tercer->addresses])

				    {{-- <a href="{{ route('accede.tercer.domicilis.addmodal',[$tercer->codigoTercero]) }}" class="btn btn-light btn-sm tgn-modal-opener" data-size="lg">@icon('plus') Afegir domicili</a> --}}


			@endcol
		@endrow
	</div>
@endsection
