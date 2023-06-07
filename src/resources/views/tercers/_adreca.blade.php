{{-- @dump($adreca) --}}
<tr>
    <td>{{ $adreca->dboid }}</td>
    <td>{{ $adreca->fulladdress }}</td>
    {{-- <td>

        @form([
            'method'=>'POST',
            'action'=>route('accede.tercer.domicilis.update',[$tercer->codigoTercero,$domicili->codigoDomicilio]),
            'data'=>['confirm'=>'Segur?']
        ])


            @button(['type'=>'submit','size'=>'xs','class'=>'btn-light','name'=>'submitaction','value'=>'setprincipal','disabled'=>$domicili->esPrincipal()]) @icon('check') Fer principal @endbutton

            @button(['type'=>'submit','size'=>'xs','class'=>'btn-danger','name'=>'submitaction','value'=>'remove']) @icon('times') @endbutton

        @endform
    </td> --}}
</tr>