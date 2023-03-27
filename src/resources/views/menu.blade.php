
<div id="main-menu">

@nav([
	"navigation"=> 'drilldown',
	'class'=>'nav-dark',
	'fullwidth'=>true,
	"items"=> [
		[
			"title" => 'Tercers'  ,
			"icon" => 'user',
			"route" => 'tsystems.tercers.home',
			"activeroute" => 'tsystems.tercers.*'

		],
		[
			"title" => ('Vialer' ) ,
			"icon" => 'road',
			"route" => 'tsystems.vialer.home',
			"activeroute" => 'tsystems.vialer.*'
		],
		[
			"title" => ('Padró' ) ,
			"icon" => 'walking',
			"route" => 'tsystems.padro.home',
			"activeroute" => 'tsystems.padro.*'
		],
		[
			"title" => ('Expedients' ) ,
			"icon" => 'folder',
			"route" => 'tsystems.expedients.home',
			"activeroute" => 'tsystems.expedients.*'
		],
		// [
		// 	"title" => ('Registre' ) ,
		// 	"icon" => 'users',
		// 	"route" => 'tsystems.registre.home',
		// 	"activeroute" => 'tsystems.registre.*'
		// ],
	]
	
])

</div>