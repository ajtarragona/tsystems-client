	@if(isset($expedients) )
		{{-- @dd($expedients) --}}
			
			
			
			<table class="table table-striped table-sm mt-3">
				<thead>
					<th>DBOID</th>
					
				</thead>
				<tbody>
					@foreach($expedients as $expedient)

						<tr>
							<td><a href="{{ route('tsystems.expedients.show',[$expedient->dboid]) }}">{{ $expedient->dboid }}</a></td>
							
						</tr>
					@endforeach
				</tbody>
			</table>
			
			@if(isset($page))

				<ul class="pagination">
					@if($page>1)
						<li class="page-item" aria-label="« First">
							<a class="page-link" href="{{ route('tsystems.expedients.home',['page'=>1])}}">@icon('angle-double-left')</a>
						</li>
						<li class="page-item" aria-label="« Anterior">
							<a class="page-link"  href="{{ route('tsystems.expedients.home',['page'=>$page-1])}}">@icon('chevron-left') Anterior</a>
						</li>
						
					@endif
					
					@if($expedients && count($expedients) == $pagesize)
						<li class="page-item" aria-label="« Següent">
							<a class="page-link" href="{{ route('tsystems.expedients.home',['page'=>$page+1])}}">Següent @icon('chevron-right') </a>
						</li>
						
					@endif
				</ul>
			@endif
		@endif
