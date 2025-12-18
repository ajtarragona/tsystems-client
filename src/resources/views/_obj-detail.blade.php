<ul class="list-group">
					
    @foreach($object as $key => $value)
        <li class="list-group-item d-flex ">		
            <div class="w-25"><strong>{{ reverseCamelCase($key) }}</strong> </div>
            <div>{{ $value }}</div>
        </li>
    @endforeach
</ul>