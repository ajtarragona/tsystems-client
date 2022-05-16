@form(['method'=>'POST','action'=>route('tsystems.expedients.search')])
	{{-- @dump($tipus_search) --}}
	<div class="input-group">
		
		@input([
			'label'=>'Nom',
			'name'=>'nom',
			'value' => $expedientsfilter->nom,
		])
		
	</div>

	

	@button(['type'=>'submit','size'=>'sm']) @icon('search') Buscar @endbutton

@endform

