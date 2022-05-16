
<div id="main-menu">

@nav([
	"navigation"=> 'drilldown',
	'class'=>'nav-dark',
	'fullwidth'=>true,
	"items"=> [
		[
			"title" => __('Tercers' ) ,
			"icon" => 'user',
			"route" => 'tsystems.tercers.home',
			"activeroute" => 'tsystems.tercers.*'

		],
		[
			"title" => __('Vialer' ) ,
			"icon" => 'road',
			"route" => 'tsystems.vialer.home',
			"activeroute" => 'tsystems.vialer.*'
		],
		[
			"title" => __('Padró' ) ,
			"icon" => 'walking',
			"route" => 'tsystems.padro.home',
			"activeroute" => 'tsystems.padro.*'
		],
		[
			"title" => __('Expedients' ) ,
			"icon" => 'folder',
			"route" => 'tsystems.expedients.home',
			"activeroute" => 'tsystems.expedients.*'
		],
		[
			"title" => __('Registre' ) ,
			"icon" => 'users',
			"route" => 'tsystems.registre.home',
			"activeroute" => 'tsystems.registre.*'
		],
	]
	
])

</div>