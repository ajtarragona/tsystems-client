@extends('ajtarragona-web-components::layout/master-sidebar')

@section('title')
	@lang($expedient ? __('Expedient :id', ['id'=>$expedient->dboid]) : 'No Expedient')
@endsection


@section('breadcrumb')

    @breadcrumb([
    	'items'=> [
    		['name'=>"Home", 'route'=> 'tsystems.home'],
    		['name'=>"Expedients", 'route'=> 'tsystems.expedients.home' ],
    		['name'=>( $expedient ? __("Expedient :id", ['id'=>$expedient->dboid]) : 'No Expedient' ) ]
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
					
					@if($documents = $expedient->getDocumentos())
						Documents
						@dump($documents)
					@endif
					@if($tareas = $expedient->getTareas())
						Tasques
						@dump($tareas)
					@endif
				
					{{-- @button(['type'=>'submit','size'=>'sm','id'=>'save-tercer-btn','hidden'=>true]) @icon('disk') Guardar @endbutton --}}

				{{-- @endform --}}
				
		
	</div>
@endsection
