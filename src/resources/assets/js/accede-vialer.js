// var al=function(msg){
// 	console.log(msg);
// }

//var 
$.fn.enableSelect = function(){
	this.prop('disabled',false);
	this.closest('.form-group').removeClass("disabled");
	this.selectpicker('refresh');
     		
	return this;

}

$.fn.disableSelect = function(){
	this.prop('disabled',true);
	this.closest('.form-group').addClass("disabled");
	this.selectpicker('refresh');
    return this;
}



$.fn.initVialerField = function(){
    return this.each(function(){
         al('initVialerField');
         var o=this;
         o.freeAddress =false;

         o.currentPais=$(this).data("current-pais");
         o.currentProvincia=$(this).data("current-provincia");
         o.currentMunicipi=$(this).data("current-municipi");
        // al(o.currentPais);
		 o.$container=$(o);
         o.$input=$(o).find("[name='vialer-value']");
		 o.$paises=$(o).find('select.field_pais');
		 o.$provincies=$(o).find('select.field_provincia');
		 o.$municipis=$(o).find('select.field_municipi');
		 o.$carrer=$(o).find('.field_carrer');
		 o.$adreca=$(o).find('.field_adreca');
		 o.$numeros=$(o).find('select.field_numero');
		 o.$lletres=$(o).find('select.field_lletra');
		 o.$escales=$(o).find('select.field_escala');
		 o.$blocs=$(o).find('select.field_bloc');
		 o.$plantes=$(o).find('select.field_planta');
		 o.$portes=$(o).find('select.field_porta');
		 o.$codispostals=$(o).find('select.field_codipostal');
		 o.$km=$(o).find('input.field_km');

		 
		 o.defaultCodificadors = function(){
		 	return {
			 	numeros: [],
				lletres: [],
				escales: [],
				blocs: [],
				plantes: [],
				portes: [],
				cpostals: []
			 };
		 }

		 o.codificadors=o.defaultCodificadors();


//al(o.$numeros);

		o.save = function(){
			//al(o.$carrer);
			var val=o.toJson();

			//al(val);
			o.$input.val(JSON.stringify(val));
		}
		
		o.toJson = function(){
			var obj={
				pais: {
					code: o.$paises.val(),
					name: o.$paises.find("option:selected").text()
				},
 				provincia: {
 					code: o.$provincies.val(),
 					name: o.$provincies.find("option:selected").text()
 				},
				municipi: {
					code: o.$municipis.val(),
					name: o.$municipis.find("option:selected").text()
				},
				carrer: {
					code: null,
					name: null,
				},
				numero: {
					code: null,
					name: null
				},
				lletra: {
					code: null,
					name: null
				},
				escala: {
					code: null,
					name: null
				},
				bloc: {
					code: null,
					name: null
				},
				planta: {
					code: null,
					name: null
				},
				porta: {
					code: null,
					name: null
				},
				codipostal: {
					code: null,
					name: null
				},
				km: null,
				adreca: o.$adreca.val()
			};


			if(!o.freeAddress){
				obj.carrer = {
					code: o.$carrer.closest('.form-group').find('input[type=hidden]').val(),
					name: o.$carrer.closest('.form-group').find('input[name=content_carrer]').val(),
				};
				
				obj.numero = {
					code: o.$numeros.val(),
					name: o.$numeros.find("option:selected").text()
				};

				obj.lletra = {
					code: o.$lletres.val(),
					name: o.$lletres.find("option:selected").text()
				};
				
				obj.escala = {
					code: o.$escales.val(),
					name: o.$escales.find("option:selected").text()
				};
				
				obj.bloc = {
					code: o.$blocs.val(),
					name: o.$blocs.find("option:selected").text()
				};
				
				obj.planta = {
					code: o.$plantes.val(),
					name: o.$plantes.find("option:selected").text()
				};
				
				obj.porta = {
					code: o.$portes.val(),
					name: o.$portes.find("option:selected").text()
				};
				
				obj.codipostal = {
					code: o.$codispostals.val(),
					name: o.$codispostals.find("option:selected").text()
				};

				obj.km=o.$km.val();

				obj.adreca=o.montaAdreca(obj);
			}

			return obj;
		}

		o.montaAdreca = function(values){
			var ret=[];
			al(values);
			if(values.carrer.name) ret.push(values.carrer.name);
			if(values.numero.name) ret.push("Núm:" + values.numero.name);
			if(values.lletra.name) ret.push(values.lletra.name);
			if(values.escala.name) ret.push("Esc:"+values.escala.name);
			if(values.bloc.name) ret.push("Bloc: "+values.bloc.name);
			if(values.planta.name) ret.push("Planta: "+values.planta.name);
			if(values.porta.name) ret.push("Porta: "+values.porta.name);
			if(values.km) ret.push("Km: "+values.km);
			if(values.codipostal.name) ret.push("CP: "+values.codipostal.name);
			if(values.municipi.name) ret.push(values.municipi.name);
			if(values.provincia.name) ret.push(values.provincia.name);
			if(values.pais.name) ret.push(values.pais.name);

			return ret.join(" ");
		}



        o.refreshPaisos = function(){
         	//al("refreshPaisos");
			o.$paises.closest(".form-group").startLoading();
			//al(o.$paises);
         	var url= laroute.route('accede.paisos');
         	//al(url);
         	$.getJSON(url,function(data){
         		o.$paises.empty();
         		$.each(data,function(i){
         			o.$paises.append($('<option value="'+this.codigoPais+'">'+this.nombrePais+'</option>'));
         		});

         		o.$paises.enableSelect();
         		o.$paises.selectpicker('val', o.currentPais);
         		
         	}).fail(function() {
			    o.$paises.empty().disableSelect();

			}).always(function() {

			   o.$paises.closest(".form-group").stopLoading();
			   o.save();
			});
        }

        o.refreshProvincies = function(){
         	//al("refreshProvincies");
         	// al(o.$paises.val());
         	// al(o.currentPais);
         	if(o.$paises.val()==o.currentPais){
         		//al("SI");
	         	o.$provincies.closest(".form-group").startLoading();
	         	var url= laroute.route('accede.provincies');
	         	
	         	$.getJSON(url,function(data){
	         		o.$provincies.empty();
	         		$.each(data,function(i){
	         			o.$provincies.append($('<option value="'+this.codigoProvincia+'">'+this.nombreProvincia+'</option>'));
	         		});


	         		o.$provincies.enableSelect();
	         		o.$provincies.selectpicker('val', o.currentProvincia);
	         		o.refreshMunicipis(o.$provincies.val());

	         	}).fail(function() {
				    o.$provincies.empty().disableSelect();
				}).always(function() {
				   o.$provincies.closest(".form-group").stopLoading();
				   o.save();
				});
         	}else{
         		//al("NO");
         		o.$provincies.empty().prop('disabled',true);
	         	o.$provincies.selectpicker('refresh');
				o.$provincies.closest('.form-group').addClass("disabled");
				o.$provincies.closest(".form-group").stopLoading();

				o.$municipis.empty().prop('disabled',true);
	         	o.$municipis.selectpicker('refresh');
				o.$municipis.closest('.form-group').addClass("disabled");
				o.$municipis.closest(".form-group").stopLoading();

				o.toggleAdreca(false);
         	}
         }



        o.refreshMunicipis = function(codigoProvincia){
         	if(codigoProvincia){
         		o.$municipis.closest(".form-group").startLoading();

	         	var url= laroute.route('accede.municipis',{codigoProvincia:codigoProvincia});
	         	//al('refreshMunicipis:'+url);

	         	$.getJSON(url,function(data){
	         		o.$municipis.empty();
	         		$.each(data,function(i){
	         			o.$municipis.append($('<option value="'+this.codigoMunicipio+'">'+this.nombreMunicipio+'</option>'));
	         		});
	         		o.$municipis.enableSelect();
	         		if(o.$provincies.val()==o.currentProvincia){
	         			o.$municipis.selectpicker('val', o.currentMunicipi);
	         		}
	         		o.$municipis.trigger('change');
	         		
	         		
	         	}).fail(function() {
				    
				    o.$municipis.disableSelect();

				}).always(function() {
				   //al("OK");
				   //al(o.$municipis);
				   o.$municipis.closest(".form-group").stopLoading();
				   o.save();
				});
			}else{
				o.$municipis.disableSelect();
				o.$municipis.closest(".form-group").stopLoading();
				o.save();
			}
        }




        o.refreshNumeros = function(codigoIneVia){
        	o.refreshComponent(o.$numeros,o.codificadors.numeros);
        }


		o.refreshEscales = function(codigoIneVia, numero){
			o.refreshComponent(o.$escales,o.codificadors.escales);	
        }

		o.refreshLletres = function(codigoIneVia, numero){
			o.refreshComponent(o.$lletres,o.codificadors.lletres);	
        }



        o.refreshBlocs = function(codigoIneVia){
         	o.refreshComponent(o.$blocs,o.codificadors.blocs);	
        }


        o.refreshPlantes = function(codigoIneVia, numero){
        	o.refreshComponent(o.$plantes,o.codificadors.plantes);	
		}


		o.refreshPortes = function(codigoIneVia, numero, planta){
			o.refreshComponent(o.$portes,o.codificadors.portes);	
        }


        o.refreshCodispostals = function(codigoIneVia, numero){
			o.refreshComponent(o.$codispostals,o.codificadors.cpostals);	
        }


        o.refreshComponent = function($component,data){
        	$component.empty();
        	$component.closest(".form-group").stopLoading();
    		al('refreshComponent');
        	//al($component);
        	//al(data);
        	//al(data.length);
     		if( data && data.length > 0 ){
         		$.each(data,function(key, item){
         			//al(key);
         			//al(item);
         			$component.append($('<option value="'+item.value+'">'+item.name+'</option>'));
         		});
         		$component.enableSelect();
         		if(data.length==1) $component.selectpicker('val', data[0].value);
         	}else{
         		$component.disableSelect();

         	}
        }	


        o.loadCodificadors = function(codigoIneVia, numero, planta, callback){
        	
        	if(codigoIneVia){
        		
        		//$component.closest(".form-group").startLoading();

         		var params={codigoIneVia:codigoIneVia};
         		
         		if(numero) params.numero=numero;
         		else params.numero=false;

         		if(planta) params.nombrePlanta=planta;

         		//al(params);
	         	var url= laroute.route('accede.codificadors',params);
	         	//al('refreshComponent:'+url);

	         	$.getJSON(url, function(data){
	         		//al(o.codificadors);
	         		//al(data);
	         		o.codificadors=data;
	         		executeCallback(callback);
	         	}).fail(function() {
				    //$component.disableSelect();
				}).always(function() {
				   //$component.closest(".form-group").stopLoading();
				   o.save();
				});

         	}else{
         		o.codificadors=o.defaultCodificadors();
         		//$component.empty();
	         	//$component.disableSelect();
	         	o.save();
	         	executeCallback(callback);
         	}
        }
        

        o.toggleAdreca = function(codigoMunicipio){
          	//al('toggleAdreca');
          	if(codigoMunicipio == o.currentMunicipi){
          		o.freeAddress=false;
          		$('.adreca_lliure').hide();
          		$('.adreca_codificada').show();
          	}else{
          		o.freeAddress=true;
          		$('.adreca_lliure').show();
          		$('.adreca_codificada').hide();
          	}
          	o.save();
         }

        o.refreshAll = function(){
        	var carrerval=o.$carrer.closest('.form-group').find('input[type=hidden]').val();
			var numero=o.$numeros.val();
				
			
			
			o.$numeros.closest(".form-group").startLoading();
			o.$lletres.closest(".form-group").startLoading();
			o.$blocs.closest(".form-group").startLoading();
			o.$escales.closest(".form-group").startLoading();
			o.$plantes.closest(".form-group").startLoading();
			o.$codispostals.closest(".form-group").startLoading();
			o.$portes.closest(".form-group").startLoading();

			o.loadCodificadors(carrerval,false, false, function(){
				 o.refreshNumeros();
				 o.refreshLletres();
				 o.refreshBlocs();
				 o.refreshEscales();
				 o.refreshPlantes();
				 o.refreshCodispostals();
				 o.refreshPortes();
			});
			
        }
        o.refreshSecondary = function(){
         	var carrerval=o.$carrer.closest('.form-group').find('input[type=hidden]').val();
			var numero=o.$numeros.val();
			
			o.$blocs.closest(".form-group").startLoading();
			o.$escales.closest(".form-group").startLoading();
			o.$plantes.closest(".form-group").startLoading();
			o.$codispostals.closest(".form-group").startLoading();
			o.$portes.closest(".form-group").startLoading();

			o.loadCodificadors(carrerval,numero, false, function(){
				 
				 o.refreshBlocs();
				 o.refreshEscales();
				 o.refreshPlantes();
				 o.refreshCodispostals();
				 o.refreshPortes();
			});
			

        }

        o.init = function(){
         	o.refreshPaisos();
         	//o.toggleAdreca(false);

         	o.$paises.on('change',function(){
         		o.refreshProvincies();
         	});


         	o.$provincies.on('change',function(){
         		o.refreshMunicipis($(this).val());
         	});


         	o.$municipis.on('change',function(){
         		o.toggleAdreca($(this).val());
         	});

         	
			o.$carrer.bind('typeahead:select', function(ev, suggestion) {
				o.refreshAll();
            });

			o.$numeros.on('change', function() {
				o.refreshSecondary();
            });


			// o.$lletres.on('change', function() {
			// 	o.refreshAll(false);
   //          });

   //          o.$blocs.on('change', function() {
			// 	o.refreshAll(true);
			// });

			

            o.$plantes.on('change', function() {
				var carrerval= o.$carrer.closest('.form-group').find('input[type=hidden]').val();
				//al(o.$numero);
				var numero= o.$numeros.val();
				var planta= $(this).val();

				o.$portes.closest(".form-group").startLoading();

				o.loadCodificadors(carrerval,numero, planta, function(){
					 o.refreshPortes();
				});

            });


            o.$portes.on('change', function() {
				o.save();
            });

 				
 			o.$escales.on('change', function() {
				o.save();
            });

            o.$codispostals.on('change', function() {
				o.save();
            });

            o.$adreca.on('keyup',function(){
             	o.save();
            });

            o.$km.on('keyup',function(){
             	o.save();
            });
        }

        o.init();
    })
}



$(window).on('load',function(){
	//alert("VAMOS");
	$(".vialer-container").initVialerField();

});