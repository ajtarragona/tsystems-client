@extends('ajtarragona-web-components::layout/master-sidebar')

@section('title')
	@lang('Vialer')
@endsection


@section('breadcrumb')
    @breadcrumb([
    	'items'=> [
    		['name'=>("Home"), 'route'=> 'tsystems.home'],
    		['name'=>("Vialer")]
    	]
    ])
	
@endsection

@section('menu')
   @include('tsystems::menu')
@endsection

@section('actions')
@endsection

@section('body')
<div class="pt-3">

	@row
		@col(['size'=>3])
			
			@form(['method'=>'POST','action'=>route('tsystems.vialer.search')])
				{{-- @dump($tipus_search) --}}
				<div class="input-group">
					@input([
						'icon'=>'search', 
						'label'=>'',
						'name'=>'term',
						'value' => $term,
					])
				</div>
			
				@button(['type'=>'submit','size'=>'sm']) @icon('search') Buscar @endbutton
			
			@endform
		
	
				
			{{-- @input([
				'label'=>'Vialer', 
				'name'=>'codigoCalle',
				'class'=> 'autocomplete form-control',
				'value' => '',
				'data' => [
					'multiple'=> false,
					'url' => route('tsystems.vialer.combo'),
					'value' => '',
					'savevalue' => true,
					'showvalue' => false,
					'min-length' => 3
				],
				'icon' => 'search'
			])  --}}

		@endcol
		@col(['size'=>9])
			@include('tsystems::vialer._searchresults')
		@endcol
	@endrow

</div>		

@endsection

