	@if(isset($empadronats))
		{{-- @dd($empadronats) --}}
			
			
			
			<table class="table table-striped table-sm mt-3">
				<thead>
					<th>DBOID</th>
					<th>Document</th>
					<th>Nombre</th>
					<th>Apellido1</th>
					<th>Apellido2</th>
				</thead>
				<tbody>
					@foreach($empadronats as $empadronat)

						<tr>
							<td><a href="{{ route('tsystems.padro.show',[$empadronat->habcodind]) }}">{{ $empadronat->habcodind }}</a></td>
							<td>{{ $empadronat->getDni() }}</td>
							<td>{{ $empadronat->getNom() }}</td>
							<td>{{ $empadronat->getCognom1()  }}</td>
							<td>{{ $empadronat->getCognom2()  }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			
			@if(isset($page))

				<ul class="pagination">
					@if($page>1)
						<li class="page-item" aria-label="« First">
							<a class="page-link" href="{{ route('tsystems.padro.home',['page'=>1])}}">@icon('angle-double-left')</a>
						</li>
						<li class="page-item" aria-label="« Anterior">
							<a class="page-link"  href="{{ route('tsystems.padro.home',['page'=>$page-1])}}">@icon('chevron-left') Anterior</a>
						</li>
						
					@endif
					
					@if($empadronats && count($empadronats) == $pagesize)
						<li class="page-item" aria-label="« Següent">
							<a class="page-link" href="{{ route('tsystems.padro.home',['page'=>$page+1])}}">Següent @icon('chevron-right') </a>
						</li>
						
					@endif
				</ul>
			@endif
		@endif
