@extends('ajtarragona-web-components::layout/master-sidebar')

@section('title')
	@lang('Padró')
@endsection


@section('breadcrumb')
    @breadcrumb([
    	'items'=> [
    		['name'=>__("Home"), 'route'=> 'tsystems.home'],
    		['name'=>__("Padró")]
    	]
    ])
	
@endsection

@section('menu')
   @include('tsystems::menu')
@endsection


@section('body')
<div class="pt-3">

	@row
		@col(['size'=>5])
			
			@include('tsystems::padro._filterfields')
				
				

		@endcol
		@col(['size'=>7])
			@include('tsystems::padro._searchresults')
		@endcol
	@endrow

</div>		

@endsection

