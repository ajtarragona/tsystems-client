@form(['method'=>'POST','action'=>route('tsystems.expedients.search')])
	{{-- @dump($tipus_search) --}}
	{{-- <div class="input-group"> --}}
		
		@input([
			'label'=>'Codi Expedient (any/num/SERIE)',
			'name'=>'nom',
			'value' => $expedientsfilter->nom??'',
		])
		@input([
			'label'=>'DNI',
			'name'=>'dni',
			'value' => $expedientsfilter->dni??'',
		])
		
	{{-- </div> --}}

	

	@button(['type'=>'submit','size'=>'sm']) @icon('search') Buscar @endbutton

@endform

