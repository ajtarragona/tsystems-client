@extends('ajtarragona-web-components::layout/master-sidebar')

@section('title')
	@lang('Expedients')
@endsection


@section('breadcrumb')
    @breadcrumb([
    	'items'=> [
    		['name'=>("Home"), 'route'=> 'tsystems.home'],
    		['name'=>("Expedients")]
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
			
			@include('tsystems::expedients._filterfields')
				
			

		@endcol
		@col(['size'=>7])
			@if(isset($error))
				@alert(['type'=>'danger'])
				<pre>{!! nl2br($error) !!}</pre>
				@endalert
			@endif
			@include('tsystems::expedients._searchresults')

		@endcol
	@endrow

</div>		

@endsection

