
		@if(isset($adreces) && $adreces)
			{{-- @dd($adreces) --}}
			<h5>Adreces</h5>
			
			<table class="table table-striped table-sm mt-3">
				<thead>
					<th>DBOID</th>
					<th>Domicili</th>
					{{-- <th></th> --}}
				</thead>
				<tbody>
					@if(is_array($adreces))
						@foreach($adreces as $adreca)
							@include('tsystems::tercers._adreca')
						@endforeach
					@else
						@include('tsystems::tercers._adreca', ['adreca'=>$adreces])
					@endif
				</tbody>
			</table>
		@endif
