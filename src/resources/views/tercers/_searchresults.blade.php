	{{-- @dump($tercers) --}}
		@if(isset($tercers))
			
			
			
			<table class="table table-striped table-sm mt-3">
				<thead>
					<th>DBOID</th>
					<th>Document</th>
					<th>Persona</th>
					<th>Nombre</th>
					<th>Apellido1</th>
					<th>Apellido2</th>
					<th>Nombre completo</th>
				</thead>
				<tbody>
					@foreach($tercers as $tercer)
						{{-- @dump($tercer) --}}
						<tr>
							<td><a href="{{ route('tsystems.tercers.show',[$tercer->dboid]) }}">{{ $tercer->dboid }}</a></td>
							<td>{{ $tercer->idnumber }}{{ $tercer->ctrldigit }}</td>
							<td>{{ $tercer->persontype }}</td>
							<td>{{ $tercer->name }}</td>
							<td>{{ $tercer->famnamepart }} {{ $tercer->familyname }}</td>
							<td>{{ $tercer->secnamepart }} {{ $tercer->secondname }}</td>
							<td>{{ $tercer->fullname }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			{{-- @pagination(['collection'=>$tercers])  --}}
			<ul class="pagination">
				@if($page>1)
					<li class="page-item" aria-label="« First">
						<a class="page-link" href="{{ route('tsystems.tercers.home',['page'=>1])}}">@icon('angle-double-left')</a>
					</li>
					<li class="page-item" aria-label="« Anterior">
						<a class="page-link"  href="{{ route('tsystems.tercers.home',['page'=>$page-1])}}">@icon('chevron-left') Anterior</a>
					</li>
					
				@endif
				
				@if($tercers && count($tercers) == $pagesize)
					<li class="page-item" aria-label="« Següent">
						<a class="page-link" href="{{ route('tsystems.tercers.home',['page'=>$page+1])}}">Següent @icon('chevron-right') </a>
					</li>
					
				@endif
			</ul>
			
		@endif
