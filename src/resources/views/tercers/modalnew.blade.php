@extends('ajtarragona-web-components::layout/modal')

@section('title')
	@lang('Accede: nou tercer')
@endsection

     

@section('body')

	
	@form(['method'=>'POST','action'=>route('accede.tercer.store')])

		@include('accede-client::tercers._fields',["readonly"=>false])
		<hr/>
		<div class="text-right">
			@button(['type'=>'submit','size'=>'sm']) @icon('check') Crear tercer @endbutton
		</div>

	@endform
	
	
@endsection
