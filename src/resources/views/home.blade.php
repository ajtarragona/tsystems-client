@extends('ajtarragona-web-components::layout/master-sidebar')

@section('title')
	@lang('Tsystems Home')
@endsection



@section('breadcrumb')
    @breadcrumb([
    	'items'=> [
    		['name'=>("Home")]
    	]
    ])
@endsection


@section('menu')
   @include('tsystems::menu')
@endsection


@section('body')
	<div class="pt-3">
		<ul class="list-group">
			<a class="list-group-item" href="{{ route('tsystems.tercers.home')}}">
				@icon('user') @lang('Tercers')
			</a>
			<a class="list-group-item" href="{{ route('tsystems.vialer.home')}}">
				@icon('road') @lang('Vialer')
			</a>
			<a class="list-group-item" href="{{ route('tsystems.padro.home')}}">
				@icon('walking') @lang('Padró')
			</a>
			<a class="list-group-item" href="{{ route('tsystems.expedients.home')}}">
				@icon('folder') @lang('Expedients')
			</a>
		</ul>
	</div>
@endsection

{{-- 
@section('style')
	<link href="{{ asset('vendor/ajtarragona/css/accede.css') }}" rel="stylesheet">
@endsection


@section('js')
	<script src="{{ asset('vendor/ajtarragona/js/accede.js')}}" language="JavaScript"></script>
@endsection --}}
