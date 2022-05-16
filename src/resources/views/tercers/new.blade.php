@extends('ajtarragona-web-components::layout/master-sidebar')

@section('title')
	@lang('Accede: nou tercer')
@endsection



@section('breadcrumb')

    @breadcrumb([
    	'items'=> [
    		['name'=>__("Tercers"), "url"=>route('accede.tercer.search')],
    		['name'=> "Nou tercer"]
    	]

    ])
	
@endsection
            

@section('body')
	<div class="pt-3">

		@row
			@col(['size'=>3])
				@include('accede-client::menu')
			@endcol


			@col(['size'=>9])
			
				@form(['method'=>'POST','action'=>route('accede.tercer.store')])
			
					@include('accede-client::tercers._fields',["readonly"=>false])
				
					@button(['type'=>'submit','size'=>'sm']) @icon('check') Crear @endbutton

				@endform
				
			@endcol
		@endrow
	</div>
@endsection

