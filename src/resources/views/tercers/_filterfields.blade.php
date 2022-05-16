@form(['method'=>'POST','action'=>route('tsystems.tercers.search')])
	{{-- @dump($tipus_search) --}}
	<div class="input-group">
		@select([
			'name'=>'search_type',
			'options'=>$tipus_search,
			'selected'=>$tercersfilter->search_type,
			'show-deselector'=>false
		])
		@input([
			'icon'=>'search', 
			'label'=>'',
			'name'=>'term',
			'value' => $tercersfilter->term,
		])
	</div>

	@button(['type'=>'submit','size'=>'sm']) @icon('search') Buscar @endbutton

@endform

