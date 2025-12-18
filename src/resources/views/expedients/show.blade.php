@extends('ajtarragona-web-components::layout/master-sidebar')

@section('title')
	@lang($expedient ? __('Expedient :id', ['id'=>$expedient->dboid]) : 'No Expedient')
@endsection


@section('breadcrumb')

    @breadcrumb([
    	'items'=> [
    		['name'=>"Home", 'route'=> 'tsystems.home'],
    		['name'=>"Expedients", 'route'=> 'tsystems.expedients.home' ],
    		['name'=>( $expedient ? __("Expedient :id", ['id'=>$expedient->dboid]) : 'No Expedient' ) ]
    	]

    ])
	
@endsection
            


@section('actions')
	<a class="btn btn-sm btn-light" href="https://iris.ajtarragona.es/mytao/escritorioPlegado.do?url=https%3A%2F%2Firis.ajtarragona.es%2Fmytao%2Fmotores%2Fmtrprc%2FexpedienteDetailAction.do%3Fdboid%3D{{$expedient->dboid}}" target="_blank">@icon('bi-box-arrow-up-right') Obrir a IRIS</a>
@endsection



@section('menu')
   @include('tsystems::menu')
@endsection



@section('body')
	<div class="pt-3">

		<div class="row">
				<div class="col-sm-6">
					@include('tsystems::_obj-detail', ['object'=>$expedient])
				</div>
				<div class="col-sm-6">
					
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="documents-tab" data-toggle="tab" data-target="#documents-tabcontent" type="button" role="tab"  aria-selected="true">Documents</button>
						</li>
						
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="tasks-tab" data-toggle="tab" data-target="#tasks-tabcontent" type="button" role="tab"  aria-selected="false">Tasques</button>
						</li>
						
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="related-tab" data-toggle="tab" data-target="#related-tabcontent" type="button" role="tab"  aria-selected="false">Exp.relacionsts</button>
						</li>
						
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="annot-tab" data-toggle="tab" data-target="#annot-tabcontent" type="button" role="tab"  aria-selected="false">Registres</button>
						</li>
						
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="terminis-tab" data-toggle="tab" data-target="#terminis-tabcontent" type="button" role="tab"  aria-selected="false">Terminis</button>
						</li>
						
						
					</ul>	
					<div class="tab-content">
						<div class="tab-pane active" id="documents-tabcontent" role="tabpanel" aria-labelledby="documents-tab">
							@if($documents = $expedient->getDocumentos())
								<ul class="accordion list-group mt-2" id="docsAccordion">

									@foreach($documents as $document)
										<li class="list-group-item  ">
											<div id="heading-{{$document->CUD}}">
												
												<a class="text-left" type="button" data-toggle="collapse" data-target="#collapse-{{$document->CUD}}" aria-expanded="true" aria-controls="collapse-{{$document->CUD}}">
													@icon('file') <strong>{{ $document->TipoDocumento }}</strong> - {{ $document->Descripcion }} ({{ $document->Nombre }})
												</a>
												
											</div>

											<div id="collapse-{{$document->CUD}}" class="collapse" aria-labelledby="heading-{{$document->CUD}}" data-parent="#docsAccordion">
												<div class="card-body">
													@include('tsystems::_obj-detail', ['object'=>$document])
													
												</div>
											</div>
										</li>
										
							
									@endforeach
								</ul>
							@else
								No hi ha documents
							@endif
						</div>
						<div class="tab-pane" id="tasks-tabcontent" role="tabpanel" aria-labelledby="tasks-tab">
	
							@if($tareas = $expedient->getTareas())
								<ul class="list-group mt-2" >

									@foreach($tareas as $tarea)
										<li class="list-group-item  ">
											<strong>{{$tarea->NODENAME}}</strong> | {{$tarea->EXECGROUPNAME}} | <span class="text-muted">{{$tarea->ESTADO_TRAM}}</span>
										</li>
										
							
									@endforeach
								</ul>
							@else
								No hi ha tasques
							@endif
						
						</div>
						<div class="tab-pane" id="related-tabcontent" role="tabpanel" aria-labelledby="related-tab">
	
							@if($expedients_rel = $expedient->getExpAsociados())
								<ul class="accordion list-group mt-2" id="relatedAccordion">

									@foreach($expedients_rel as $expedient_rel)
										<li class="list-group-item  ">
											<div id="heading-{{$loop->index}}">
												<div class="d-flex justify-content-between align-items-center">
																										
													<a class="text-left" type="button" data-toggle="collapse" data-target="#collapse-{{$loop->index}}" aria-expanded="true" aria-controls="collapse-{{$loop->index}}">
														@icon('folder') <strong>{{ $expedient_rel->NumeroFormateado }}</strong> 
													</a>

													<div>
														<a href="{{ route('tsystems.expedients.show', ['id'=>$expedient_rel->dboid]) }}" class="btn btn-sm btn-light" >@icon('external-link') Obrir </a>
													</div>
												</div>												
											</div>

											<div id="collapse-{{$loop->index}}" class="collapse" aria-labelledby="heading-{{$loop->index}}" data-parent="#relatedAccordion">
												<div class="card-body">
													@include('tsystems::_obj-detail', ['object'=>$expedient_rel])
												</div>
											</div>
										</li>
										
							
									@endforeach
								</ul>
							@else
								No hi ha expedients relacionats
							@endif
						
						</div>

						<div class="tab-pane" id="annot-tabcontent" role="tabpanel" aria-labelledby="annot-tab">
	
							@if($registres = $expedient->getAnnotations())
								<ul class="accordion list-group mt-2" id="annotAccordion">

									@foreach($registres as $registre)
										<li class="list-group-item  ">
											<div id="heading-{{$loop->index}}">
												<div class="d-flex justify-content-between align-items-center">
																										
													<a class="text-left" type="button" data-toggle="collapse" data-target="#collapse-{{$loop->index}}" aria-expanded="true" aria-controls="collapse-{{$loop->index}}">
														@icon('folder') <strong>{{ $registre->VisibleNum }}</strong> 
													</a>

													{{-- <div>
														<a href="{{ route('tsystems.expedients.show', ['id'=>$expedient_rel->dboid]) }}" class="btn btn-sm btn-light" >@icon('external-link') Obrir </a>
													</div> --}}
												</div>												
											</div>

											<div id="collapse-{{$loop->index}}" class="collapse" aria-labelledby="heading-{{$loop->index}}" data-parent="#annotAccordion">
												<div class="card-body">
													@include('tsystems::_obj-detail', ['object'=>$registre])
												</div>
											</div>
										</li>
										
							
									@endforeach
								</ul>
							@else
								No hi ha anotacions
							@endif
						
						</div>

						<div class="tab-pane" id="terminis-tabcontent" role="tabpanel" aria-labelledby="terminis-tab">
	
							@if($terminis = $expedient->getPlazos())
								<table class="table table-sm table-bordered border bg-white mt-2" >
									<thead>
										<tr>
											<th>Tipus termini</th>
											<th>Inici</th>
											<th>Fi</th>
											<th>Consecució</th>
											<th>Estat</th>
										</tr>
									<tbody>
										@foreach($terminis as $termini)
											<tr>
												<td>{{$termini->TipoPlazo->Descripcion}}</td>
												<td>{{ts_formatdate($termini->PlazoInicial)}}</td>
												<td>{{ts_formatdate($termini->PlazoFinal)}}</td>
												<td>{{ts_formatdate($termini->FechaConsecucion)}}</td>
												<td>{{ removeHTML($termini->Estado) }}</td>
											</tr>
											
								
										@endforeach
									</tbody>
								</table>
							@else
								No hi ha terminis
							@endif
						
						</div>
					</div>
							
						
							{{-- @button(['type'=>'submit','size'=>'sm','id'=>'save-tercer-btn','hidden'=>true]) @icon('disk') Guardar @endbutton --}}

						{{-- @endform --}}
				</div>
		</div>
		
	</div>
@endsection
