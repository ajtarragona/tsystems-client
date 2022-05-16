{{-- @dump($domicili)
@dump($plantes)
 --}}
 	@row(['class'=>'gap-xs'])
 		
		@col
			@input([
				'label'=>'Documento', 
				'name'=>'dni',
				'value' => $empadronat->getDni()
			])
		@endcol
	@endrow

	 @row(['class'=>'gap-0'])	
		 @col(['size'=>3])
			@input([
				'label'=>'Nombre', 
				'name'=>'nombre',
				'value' => $empadronat->getNom(),
			])
		@endcol
		@col(['size'=>3])
			@input([
				'label'=>'Apellido1', 
				'name'=>'apellido1',
				'value' => $empadronat->getCognom1(),
			])
		@endcol
		@col(['size'=>3])
			@input([
				'label'=>'Apellido2', 
				'name'=>'apellido2',
				'value' => $empadronat->getCognom2(),
			])
		@endcol
	@endrow

