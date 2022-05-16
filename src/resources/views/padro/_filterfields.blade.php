@form(['method'=>'POST','action'=>route('tsystems.padro.search')])
	{{-- @dump($tipus_search) --}}
	<div class="input-group">
		
		@input([
			'label'=>'Nom',
			'name'=>'nom',
			'value' => $padrofilter->nom,
		])
		@input([
			'label'=>'Cognom1',
			'name'=>'cognom1',
			'value' => $padrofilter->cognom1,
		])
		@input([
			'label'=>'Cognom2',
			'name'=>'cognom2',
			'value' => $padrofilter->cognom2,
		])
	</div>

	@input([
		'label'=>'DNI',
		'name'=>'dni',
		'value' => $padrofilter->dni,
	])

	@button(['type'=>'submit','size'=>'sm']) @icon('search') Buscar @endbutton

@endform

