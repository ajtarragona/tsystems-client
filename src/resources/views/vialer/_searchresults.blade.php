	{{-- @dump($tercers) --}}
		@if(isset($carrers))
			
			
			
			<table class="table table-striped table-sm mt-3">
				<thead>
					<th>DBOID</th>
					<th>Code</th>
					<th>Acronym</th>
					<th>Carrer</th>
					
				</thead>
				<tbody>
					@foreach($carrers as $carrer)
						{{-- @dump($tercer) --}}
						<tr>
							<td>{{ $carrer->dboid }}</td>
							<td>{{ $carrer->code }}</td>
							<td>{{ $carrer->acronym }}</td>
							<td>{{ $carrer->stname }}</td>
							
						</tr>
					@endforeach
				</tbody>
			</table>

			
			
		@endif
