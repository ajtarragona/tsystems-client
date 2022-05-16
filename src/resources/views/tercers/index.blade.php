@extends('ajtarragona-web-components::layout/master-sidebar')

@section('title')
	@lang('Tercers')
@endsection


@section('breadcrumb')
    @breadcrumb([
    	'items'=> [
    		['name'=>__("Home"), 'route'=> 'tsystems.home'],
    		['name'=>__("Tercers")]
    	]
    ])
	
@endsection

@section('menu')
   @include('tsystems::menu')
@endsection

@section('actions')
    <a href="#" class="btn btn-secondary btn-sm tgn-modal-opener" data-size="lg">@icon('plus') Nou tercer</a>
@endsection

@section('body')
<div class="pt-3">

	@row
		@col(['size'=>3])
			{{-- @dump($domicilisfilter) --}}

			@include('tsystems::tercers._filterfields')
				
				{{-- <hr/>
				<h3>Autocomplete</h3>

			@input([
				'label'=>'Tercer', 
				'name'=>'codigoTercero',
				'class'=> 'field_tercer autocomplete form-control',
				'value' => '',
				'data' => [
					'multiple'=> false,
					'url' => route('tsystems.tercers.combo'),
					'value' => '',
					'savevalue' => true,
					'showvalue' => false,
					'min-length' => 3
				],
				'icon' => 'search'
			]) --}}

		@endcol
		@col(['size'=>9])
			@include('tsystems::tercers._searchresults')
		@endcol
	@endrow

</div>		

@endsection

