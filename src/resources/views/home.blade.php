@extends('ajtarragona-web-components::layout/master-sidebar')

@section('title')
	@lang('Tsystems Home')
@endsection



@section('breadcrumb')
    @breadcrumb([
    	'items'=> [
    		['name'=>__("Home")]
    	]
    ])
@endsection


@section('menu')
   @include('tsystems::menu')
@endsection


@section('body')
	<div class="pt-3">
		<a href="{{ route('tsystems.tercers.home')}}">
			@lang('Tercers')
		</a>
		<a href="{{ route('tsystems.padro.home')}}">
			@lang('Padró')
		</a>
	</div>
@endsection

{{-- 
@section('style')
	<link href="{{ asset('vendor/ajtarragona/css/accede.css') }}" rel="stylesheet">
@endsection


@section('js')
	<script src="{{ asset('vendor/ajtarragona/js/accede.js')}}" language="JavaScript"></script>
@endsection --}}
