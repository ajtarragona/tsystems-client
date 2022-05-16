@extends('ajtarragona-web-components::layout/master-sidebar')

@section('title')
	@lang($expedient ? __('Expedient :id', ['id'=>$expedient->dboid]) : 'No Expedient')
@endsection


@section('breadcrumb')

    @breadcrumb([
    	'items'=> [
    		['name'=>__("Home"), 'route'=> 'tsystems.home'],
    		['name'=>__("Expedients"), 'route'=> 'tsystems.expedients.home'],
    		['name'=> $expedient ? __("Expedient :id", ['id'=>$expedient->dboid)]) : __('No Expedient') ]
    	]

    ])
	
@endsection
            


@section('actions')
	
@endsection



@section('menu')
   @include('tsystems::menu')
@endsection



@section('body')
	<div class="pt-3">


		
			
					@dump($expedient)
				
					{{-- @button(['type'=>'submit','size'=>'sm','id'=>'save-tercer-btn','hidden'=>true]) @icon('disk') Guardar @endbutton --}}

				{{-- @endform --}}
				
		
	</div>
@endsection
