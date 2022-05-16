{{-- @dump($domicili)
@dump($plantes)
 --}}
 	@row(['class'=>'gap-xs'])
 		
		@col
			@input([
				'label'=>'Documento', 
				'name'=>'documento',
				'value' => $tercer->idnumber . $tercer->ctrldigit,
			])
		@endcol
	@endrow


	@input([
		'label'=>'Nombre', 
		'name'=>'nombre',
		'value' => $tercer->fullname,
	])

	{{-- @row(['class'=>'gap-0'])	
		
						
			@col(['size'=>3])
				@input([
					'label'=>'Particula 1', 
					'name'=>'particula1',
					'value' => $tercer->particula1,
				])
			@endcol


			@col(['size'=>9])
				@input([
					'label'=>'Apellido 1', 
					'name'=>'apellido1',
					'value' => $tercer->apellido1,
				])
			@endcol
	@endrow		


	@row(['class'=>'gap-0'])	
			@col(['size'=>3])
				@input([
					'label'=>'Particula 2', 
					'name'=>'particula2',
					'value' => $tercer->particula2,
				])
			@endcol


			@col(['size'=>9])
				@input([
					'label'=>'Apellido 2', 
					'name'=>'apellido2',
					'value' => $tercer->apellido2,
				])
			@endcol

			
	@endrow --}}

