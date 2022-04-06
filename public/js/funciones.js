$(document).ready(function(){
     $('#btnGetPass').click(function(){
     
 			var tamanyo_password				=	9;			// definimos el tamaño que tendrá nuestro password

 			var caracteres_conseguidos			=	0;			// contador de los caracteres que hemos conseguido
 			var caracter_temporal				=	'';
			
 			var array_caracteres				=	new Array();// array para guardar los caracteres de forma temporal
				
 				for(var i = 0; i < tamanyo_password; i++){		// inicializamos el array con el valor null
 					array_caracteres[i]	=	null;
 				}

 			var password_definitivo				=	'';

 			var numero_minimo_letras_minusculas	=	1;			// en ésta y las siguientes variables definimos cuántos 
 			var numero_minimo_letras_mayusculas	=	1;			// caracteres de cada tipo queremos en cada 
 			var numero_minimo_numeros			=	1;
 			var numero_minimo_simbolos			=	1;

 			var letras_minusculas_conseguidas 	=	0;
 			var	letras_mayusculas_conseguidas	=	0;
 			var	numeros_conseguidos				=	0;
 			var	simbolos_conseguidos			=	0;


 			// función que genera un número aleatorio entre los límites superior e inferior pasados por parámetro
 			function genera_aleatorio(i_numero_inferior, i_numero_superior) {
 			    var     i_aleatorio  =   Math.floor((Math.random() * (i_numero_superior - i_numero_inferior + 1)) + i_numero_inferior);
 			    return  i_aleatorio;
 			}


 			// función que genera un tipo de caracter en base al tipo que se le pasa por parámetro (mayúscula, minúscula, número, símbolo o aleatorio)
 			function genera_caracter(tipo_de_caracter){
 				// hemos creado una lista de caracteres específica, que además no tiene algunos caracteres como la "i" mayúscula ni la "l" minúscula para evitar errores de transcripción
 				var lista_de_caracteres	=	'$+=?@_23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz';
 				var caracter_generado	=	'';
 				var valor_inferior		=	0;
 				var valor_superior		=	0;

 				switch (tipo_de_caracter){
 					case 'minúscula':
 						valor_inferior	=	38;
 						valor_superior	=	61;
 						break;
 					case 'mayúscula':
 						valor_inferior	=	14;
 						valor_superior	=	37;
 						break;
 					case 'número':
 						valor_inferior	=	6;
 						valor_superior	=	13;
 						break;
 					case 'símbolo':	
 						valor_inferior	=	0;
 						valor_superior	=	5;
 						break;
 					case 'aleatorio':
 						valor_inferior	=	0;
 						valor_superior	=	61;

 				} // fin del switch

 				caracter_generado	=	lista_de_caracteres.charAt(genera_aleatorio(valor_inferior, valor_superior));
 				return caracter_generado;
 			} // fin de la función genera_caracter()


 			// función que guarda en una posición vacía aleatoria el caracter pasado por parámetro
 			function guarda_caracter_en_posicion_aleatoria(caracter_pasado_por_parametro){
 				var guardado_en_posicion_vacia	=	false;
 				var posicion_en_array			=	0;

 				while(guardado_en_posicion_vacia	!=	true){
 					posicion_en_array	=	genera_aleatorio(0, tamanyo_password-1);	// generamos un aleatorio en el rango del tamaño del password

 					// el array ha sido inicializado con null en sus posiciones. Si es una posición vacía, guardamos el caracter
 					if(array_caracteres[posicion_en_array] == null){
 						array_caracteres[posicion_en_array]	=	caracter_pasado_por_parametro;
 						guardado_en_posicion_vacia			=	true;
 					}
 				}
 			}


 			// función que se inicia una vez que la página se ha cargado
 			

 				// generamos los distintos tipos de caracteres y los metemos en un password_temporal
 				while (letras_minusculas_conseguidas < numero_minimo_letras_minusculas){
 					caracter_temporal	=	genera_caracter('minúscula');
 					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
 					letras_minusculas_conseguidas++;
 					caracteres_conseguidos++;
 				}

 				while (letras_mayusculas_conseguidas < numero_minimo_letras_mayusculas){
 					caracter_temporal	=	genera_caracter('mayúscula');
 					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
 					letras_mayusculas_conseguidas++;
 					caracteres_conseguidos++;
 				}

 				while (numeros_conseguidos < numero_minimo_numeros){
 					caracter_temporal	=	genera_caracter('número');
 					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
 					numeros_conseguidos++;
 					caracteres_conseguidos++;
 				}

 				while (simbolos_conseguidos < numero_minimo_simbolos){
 					caracter_temporal	=	genera_caracter('símbolo');
 					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
 					simbolos_conseguidos++;
 					caracteres_conseguidos++;
 				}

 				// si no hemos generado todos los caracteres que necesitamos, de forma aleatoria añadimos los que nos falten
 				// hasta llegar al tamaño de password que nos interesa
 				while (caracteres_conseguidos < tamanyo_password){
 					caracter_temporal	=	genera_caracter('aleatorio');
 					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
 					caracteres_conseguidos++;
 				}

 				// ahora pasamos el contenido del array a la variable password_definitivo
 				for(var i=0; i < array_caracteres.length; i++){
 					password_definitivo	=	password_definitivo + array_caracteres[i];
 				}

 				// indicamos los parámetros con los que hemos generado la contraseña
 				// document.write('Tamaño total de la contraseña: ' 	+ tamanyo_password + '<br>');
 				// document.write('Cantidad de minúsculas: '			+ numero_minimo_letras_minusculas + '<br>');
 				// document.write('Cantidad de mayúsculas: ' 			+ numero_minimo_letras_mayusculas + '<br>');
 				// document.write('Cantidad de números: ' 				+ numero_minimo_numeros + '<br>');
 				// document.write('Cantidad de símbolos: ' 			+ numero_minimo_simbolos + '<br>');
 				// document.write('El resto de caracteres hasta llegar al tamaño de la contraseña se completa con caracteres aleatorios.<br>');

                 // y ahora simplemente lo mostramos por pantalla
                 
 				document.getElementById('password').value=password_definitivo;
                document.getElementById('password-confirm').value=password_definitivo;
 				// e indicamos que al recargar la página se generará uno nuevo
 				// document.write('Pulse F5 para generar una nueva contraseña')
             
            
         });
	 });
	 
//verificacion rut empresa
	 $(document).ready(function(){
		$('#rut').blur(function(){
			/* validación de rut */
		var rut=$('#rut').val();
    if (rut.toString().trim() != '' && rut.toString().indexOf('-') > 0) {
        var caracteres = new Array();
        var serie = new Array(2, 3, 4, 5, 6, 7);
        var dig = rut.toString().substr(rut.toString().length - 1, 1);
        rut = rut.toString().substr(0, rut.toString().length - 2);

        for (var i = 0; i < rut.length; i++) {
            caracteres[i] = parseInt(rut.charAt((rut.length - (i + 1))));
        }

        var sumatoria = 0;
        var k = 0;
        var resto = 0;

        for (var j = 0; j < caracteres.length; j++) {
            if (k == 6) {
                k = 0;
            }
            sumatoria += parseInt(caracteres[j]) * parseInt(serie[k]);
            k++;
        }

        resto = sumatoria % 11;
        dv = 11 - resto;

        if (dv == 10) {
            dv = "K";
        }
        else if (dv == 11) {
            dv = 0;
        }

        if (dv.toString().trim().toUpperCase() == dig.toString().trim().toUpperCase()){
		
			$.get('/api/datos/'+rut+'/Empresa/',function(array){
				
			
            
				// Swal.fire({
				// 	type: 'error',
				// 	title: 'Empresa ya Creada...',
				// 	text: 'Something went wrong!',
					
				//   })
				
			
		});
		}else{
		//inicio
		Swal.fire({
			type: 'error',
			title: 'Oops...',
			text: 'Something went wrong!',
			footer: '<a href>Why do I have this issue?</a>'
		  })
		//fin
		}
    }
    else {
		Swal.fire({
			type: 'error',
			title: 'Error...',
			text: 'El Rut no existe!',
			
		  })
    }



/* fin */
		});
	 });
//fin verificacion rut empresa
//verificacion rut rep
$(document).ready(function(){
	$('#rutRep').blur(function(){
		/* validación de rut */
	var rut=$('#rutRep').val();
if (rut.toString().trim() != '' && rut.toString().indexOf('-') > 0) {
	var caracteres = new Array();
	var serie = new Array(2, 3, 4, 5, 6, 7);
	var dig = rut.toString().substr(rut.toString().length - 1, 1);
	rut = rut.toString().substr(0, rut.toString().length - 2);

	for (var i = 0; i < rut.length; i++) {
		caracteres[i] = parseInt(rut.charAt((rut.length - (i + 1))));
	}

	var sumatoria = 0;
	var k = 0;
	var resto = 0;

	for (var j = 0; j < caracteres.length; j++) {
		if (k == 6) {
			k = 0;
		}
		sumatoria += parseInt(caracteres[j]) * parseInt(serie[k]);
		k++;
	}

	resto = sumatoria % 11;
	dv = 11 - resto;

	if (dv == 10) {
		dv = "K";
	}
	else if (dv == 11) {
		dv = 0;
	}

	if (dv.toString().trim().toUpperCase() == dig.toString().trim().toUpperCase()){
		//alert('bueno');
		
	}else{
	//inicio
	Swal.fire({
		type: 'error',
		title: 'Oops...',
		text: 'Something went wrong!',
		footer: '<a href>Why do I have this issue?</a>'
	  })
	//fin
	}
}
else {
	Swal.fire({
		type: 'error',
		title: 'Error...',
		text: 'El Rut no existe!',
		
	  })
}



/* fin */
	});
 });
//fin verificacion rut rep

$(document).ready(function(){
	$('#selectEmpresa').change(function(){
		var idEmpresa = $('#selectEmpresa').val();
			alert(resultado);
		$.get('/api/proyectos/'+idEmpresa+'/empresa/',function(resultado){
		
		});
	});
});


// select dinámicos para la selección de Empresa arroja Proyectos 
$(function(){
	$('#empresa_id').on('change', Cambio_Seleccion);
	$('#proyecto_id').on('change', Cambio_proyecto);
	$('#contratista_id').on('change',Cambio_contratista);
    // $('#tipo_personal').on('change',cambiotipopersonal);
    // $('#select_area').on('change',trabajadores_sepp_caidaA);
});

function Cambio_Seleccion(){
	
	var id = $(this).val();
  
    $.get('/api/Listaproyectos/'+id+'/empresa', function(info){
         var html_select ='<option value=""></option>';
         for (var i=0; i<info.length; ++i){
             html_select +='<option value="'+info[i].id+'">'+info[i].proyecto+'</option>';
             $('#proyecto_id').html(html_select);
         }    
     });
}


function Cambio_proyecto(){
	var id = $(this).val();
	$.get('/api/ListaEmpresas/'+id+'/proyecto',function(dato){
		
		var html_select ='<option value=""></option>';
         for (var i=0; i<dato.length; ++i){
             html_select +='<option value="'+dato[i].empresa.id+'">'+dato[i].empresa.rut+','+dato[i].empresa.nombre+'</option>';
             $('#contratista_id').html(html_select);
         }   



	})
}



function Cambio_contratista(){
	var id = $(this).val();
	var proy_id = $('#proyecto_id').val();
	$.get('/api/Lista/'+proy_id+'/'+id+'/Empresa',function(dato){
		
		var html_select ='<option value=""></option>';
         for (var i=0; i<dato.length; ++i){
             html_select +='<option value="'+dato[i].contrato+'">'+dato[i].contrato+'</option>';
             $('#contrato_id').html(html_select);
         }   

	})
	
}

// datatable de agregar contratistas a los proyectos
$(document).ready(function(){
	$('#tablaProyectos').DataTable()
});

$(document).ready(function(){
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
		]
		
	});
	$('#DatatableZip').DataTable({
		language:{search:"Buscar"},
		"pageLength": 100,
		paging: true,
		searching: true,
		dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
		]
	});

	
});

 $(document).ready(function(){
//    $('#zipped').click(function(){
// 		var table = $('#DatatableZip').DataTable({});

// 		function selectOnlyFiltered(){
// 			var filteredRows = table.rows({filter: 'applied'});
// 			alert(filteredRows)
// 		}
//   
$("#zipped").click(function(){
	oTable = $("#DatatableZip").dataTable();

	var secondCellArray=[];
	$.each( oTable.fnGetData(), function(i, row){
	secondCellArray.push( row[1]);
	})
	
	console.log(secondCellArray)
 });
 });





function AsignarTags(ids){
	
	
	$.get('/api/NombreTag/'+ids+'/tags',function(nombre){
		
	
	var text = $('#inputTags').val();
	var matriz = text.split(",");
	var matrizLargo = matriz.length;
	for (var i = 0; i < matrizLargo; i++) {
		if (matriz[i]==nombre){
			
			swal("Etiqueta ya Registrada...");
			Break;	
		}
	}

	if (text==''){
		document.getElementById("inputTags").value=nombre+",";
	}
	else{
		document.getElementById("inputTags").value=text+nombre+",";
	}
		
	});
	
}

function QuitarTags(ids){


	$.get('/api/NombreTag/'+ids+'/tags',function(nombre){
			
			var text = $('#inputTags').val();

			var matriz = text.split(",");
			var matrizLargo = matriz.length;
			var matrizNueva=[];
			//alert(matriz);
			var pos = 0;
			for (var i = 0; i < matrizLargo; i++) {
				if (matriz[i]==nombre){
					//matriz.splice(i, 1);
				}else{
					matrizNueva[pos]=matriz[i];
					pos++;
				}
			}
			//alert(matrizNueva);
			var matrizLargoNuevo = matrizNueva.length;
			//alert(matrizLargoNuevo);
			document.getElementById("inputTags").value='';
			for (var i = 0; i < matrizLargoNuevo; i++) {
				var text = $('#inputTags').val();
				if(text==''){

					document.getElementById("inputTags").value=matrizNueva[i];
				}else{
					document.getElementById("inputTags").value=text+','+matrizNueva[i];
				}
				
			}
	});
}


//agregar etiquetas de grupo
function AsignarTagsGroups(ids){
	var group_id = $('#groups').val();


	$.get('/api/NombreGroupsTag/'+group_id+'/tags',function(nombre){
	
		var text = $('#inputTags').val();
		
		if (text=='')
		{
			document.getElementById("inputTags").value=nombre;
		}else{
			//document.getElementById("inputTags").value=text+",";
			var text = $('#inputTags').val();
			var matriz = text.split(",");
			//var matriz = matriz.filter(Boolean);
			var matrizLargo = matriz.length - 1;
			
			var tagsNuevos=nombre.split(",");
			//var tagsNuevos = tagsNuevos.filter(Boolean);
			var largo = tagsNuevos.length - 1;


			for (var i = 0; i < largo; i++)
			{
				var comprobacion=0;
				for (var j = 0; j < matrizLargo; j++){
					
					if(tagsNuevos[i]==matriz[j])
					{
						comprobacion++;
						swal("Etiqueta ya Registrada...");
					}
				}
				if(comprobacion==0){
					var text = $('#inputTags').val();
					document.getElementById("inputTags").value=text+tagsNuevos[i]+",";
				}
				
			}
			
		}
			
	});
}
//fin

// quitar etiquetas del grupo
function QuitarTagsgroups(){
	var group_id = $('#groups').val();

	$.get('/api/NombreGroupsQuitarTag/'+group_id+'/tags',function(nombre){
		
		var text = $('#inputTags').val();
		
		if (nombre==text)
		{
			document.getElementById("inputTags").value='';	
			Break;
		}else{
			//document.getElementById("inputTags").value=text+",";
			var text = $('#inputTags').val();
			var matriz = text.split(",");
			//var matriz = matriz.filter(Boolean);
			var matrizLargo = matriz.length - 1;
			
			var tagsNuevos=nombre.split(",");
			//var tagsNuevos = tagsNuevos.filter(Boolean);
			var largo = tagsNuevos.length - 1;

			var nuevoContenido='';
			var comprobacion=0;
			for (var i = 0; i <  matrizLargo; i++)
			{
				//alert(matriz[i])
				
				 var comprobacion=0;
				 for (var j = 0; j < largo; j++){
					//alert(tagsNuevos[j]);
				 	if(matriz[i]==tagsNuevos[j])
				 	{
				 		comprobacion++;
				 	}
				 }
				 if(comprobacion==0){
				 	if (matriz[i]!=''){
				 		nuevoContenido=nuevoContenido+matriz[i]+",";
				 	}
				 }
				
			}

			document.getElementById("inputTags").value=nuevoContenido;


		}
		
		
	});
}

function btnReporte(){
	var idRegistro = $('#idRegistro').val();


	$.get('/api/listado/'+idRegistro+'/reporte',function(info){
		$("#tablaReporte tr").remove(); 
	if (info.length>0){
			//alert(info);	
			
			for (i=0;i<=info.length-1;i++)
        {
            
            $("#tablaReporte").find('tbody')
                .append($('<tr>')

                   
                    // .append($('<th>')
                    //     .append($('<input>')
                    //         .attr('type', 'text')
                    //         .text('prueba')
                    //         .attr('class','form-control')
                    //         /*.attr('value',tr_area[num2].trabajador_id)*/
                    //         .attr('value',info[i].id)
                    //         .attr('size','1')
                    //         .attr('readonly','readonly')
                    //         .attr('name','ruts[]')
                    //     )
                    // )

                  
                    // .append($('<th>')
                    //     .append($('<input>')
                    //         .attr('type', 'text')
                    //         .text('prueba')
                    //         .attr('class','form-control')
                    //         .attr('value',info[i].registro_id)
                    //         .attr('size','1')
                    //         .attr('readonly','readonly')
                    //         .attr('name','nombres[]')
                    //     )
					// )
					
						.append($('<th>')
						.append($('<input>')
							.attr('type', 'text')
							.text('prueba')
							.attr('class','form-control')
							.attr('value',info[i].detalle)
							.attr('size','5')
							.attr('readonly','readonly')
							.attr('name','nombres[]')
						)
					)

						.append($('<th>')
						.append($('<input>')
							.attr('type', 'text')
							.text('prueba')
							.attr('class','form-control')
							.attr('value',info[i].nombreArchivo)
							.attr('size','5')
							.attr('readonly','readonly')
							.attr('name','nombres[]')
						)
					)

                   
                )
                            
        }		 
	}
		
	});

}

// Eliminar documentos de la carga
function btnEliminaCarga(id)

{
  Swal.fire({
  title: "ELIMINAR DOCUMENTOS DE LA CARGA",
  text: "¿ Desea Eliminar la Documentos de la carga... ?",
  type: 'warning',
  showCancelButton: true,
  allowOutsideClick: false,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, borrar'
    }).then((result) => {
       
        if (result.value) {
			var idCarga = $('#idRegistroEliminar').val();
        $.get('/api/eliminar/'+idCarga+'/documentos/carga/masiva',function(retorno){
            if (retorno==1){
              Swal.fire({
                title: 'Documento Borrado',
                text: 'Pueden Continuar...',
                type: 'success',
                confirmButtonText: 'Ok',
                showConfirmButton: false,
                timer: 1500,
              })

            }else{
              Swal.fire({
                title: 'Documento NO Borrado',
                text: 'Pueden Continuar...',
                type: 'error',
                confirmButtonText: 'Ok',
                showConfirmButton: false,
                timer: 1500,
              })
            }
              

                 setTimeout ("location.reload();", 1500); 
               
        });
       
        } 
       
    })
}
// fin eliminar documentos de la carga

function reintegrarSolicitud(id){
	//alert(id);
	$.get('/api/restaurar/'+id+'/solicitud',function(retorno){
		if (retorno==1){
			Swal.fire({
			  title: 'Solicitud Restaurada',
			  text: 'Pueden Continuar...',
			  type: 'success',
			  confirmButtonText: 'Ok',
			  showConfirmButton: false,
			  timer: 1500,
			})

		}else{
			Swal.fire({
			  title: 'Solicitud no Restaurada, ya Existe en el Periodo',
			  text: 'Pueden Continuar...',
			  type: 'error',
			  confirmButtonText: 'Ok',
			  showConfirmButton: false,
			  timer: 1500,
			})
		}
			

			   setTimeout ("location.reload();", 1500); 
	})

}



function btnAsignarContratistaDirectamente(){
	var empresa_id = $('#empresa_id').val();
	var proyecto_id = $('#proyecto_id').val();
	var cliente_id = $('#cliente_id').val();
	var contratistaSubcontrato_id = $('#contratistaSubcontrato_id').val();
	var contratoContratista =$('#contratoContratista').val();
	var fechaingresoContratista = $('#fechaingresoContratista').val();
	
	if (empresa_id===' ' || proyecto_id===' ' || cliente_id===' '){
		Swal.fire({
		  title: 'Error de Datos',
		  text: 'Faltan datos para asignar el Contratista...',
		  type: 'error',
		  confirmButtonText: 'Ok',
		  showConfirmButton: false,
		  timer: 1500,
		});
	}
	
	if (contratoContratista ==='' || fechaingresoContratista ===''){
		Swal.fire({
		  title: 'Error de Datos',
		  text: 'Falta Contrato o Fecha de Ingreso...',
		  type: 'error',
		  confirmButtonText: 'Ok',
		  showConfirmButton: false,
		  timer: 1500,
		})
	}
	//alert(contratistaSubcontrato_id);
	$.get('/api/mandante/'+empresa_id+'/proyecto/'+proyecto_id+'/cliente/'+cliente_id+'/contratista/'+contratistaSubcontrato_id+'/contrato/'+contratoContratista+'/fechaIngreso/'+fechaingresoContratista+'/asignacion/',function(resp){
		//alert(resp);
		
		if (resp==0){
			Swal.fire({
				title: 'Error de Registro',
				text: 'Ya existe el Contratista...',
				type: 'error',
				confirmButtonText: 'Ok',
				showConfirmButton: false,
				timer: 1500,
			  })
		}
		if(resp==1){
			Swal.fire({
				title: 'Contratista Ingresado',
				text: 'Se guardó correctamente el Contratista...',
				type: 'success',
				confirmButtonText: 'Ok',
				showConfirmButton: false,
				timer: 1500,
			  })
		}
	});

	
}

function btnAgregarContratista(){
	var empresa_id = $('#empresa_id').val();
	var proyecto_id = $('#proyecto_id').val();
	var cliente_id = $('#cliente_id').val();
	var contratistaSubcontrato_id = $('#contratistaSubcontrato_id').val();
	var contratoContratista =$('#contratoContratista').val();
	var fechaingresoContratista = $('#fechaingresoContratista').val();
	alert (empresa_id+proyecto_id+cliente_id+contratistaSubcontrato_id);
	$.get('/api/agrega_lista/mandante/'+empresa_id+'/proyecto/'+proyecto_id+'/cliente/'+cliente_id+'/contratista/'+contratistaSubcontrato_id+'/contrato/'+contratoContratista+'/fechaIngreso/'+fechaingresoContratista+'/asignacion/',function(resp){
	});
	
}

// $(document).ready(function(){
// 	$('.select_estructuras').change(function(){
// 		var proyecto_id = $('.select_estructuras').val();
// 		$.get('/api/empresas/'+proyecto_id+'/porproyecto',function(resultado){
// 			if (resultado.length>0){
// 					//$("#tb-empresasxproyecto tr").remove(); 
// 					//document.getElementById("tb-empresasxproyecto").insertRow(-1).innerHTML = '<td></td><td></td><td></td><td></td>';
// 				//$("#tb-empresasxproyecto tr").remove(); 
// 				for (i=0;i<=resultado.length-1;i++)
//         		{
// 					document.getElementById("tb-empresasxproyecto").insertRow(-1).innerHTML = '<td>'+resultado[i].id+'</td><td>'+resultado[i].empresa.nombre+'</td><td>'+resultado[i].proyecto.proyecto+'</td><td>'+resultado[i].contrato+'</td><td><center><input type="checkbox" checked name="estructurasseleccionadas[]" value="'+resultado[i].id+'"><center></td>'; //<td><select class="form-control name="formularios"><option value="1">1.- Certificación Laboral</option><option value="2">2.- Auditoría Documental</option><option value="1">3.- Ambos Formularios</option></select></td>
// 				}
// 			}
// 		});
		
// 	});
// });

$(document).ready(function(){
	$('#btnClonar').click(function(){
		var actual_usuario_id = $('#actual_usuario_id').val();
		var destino_usuario_id = $('#destino_usuario_id').val();

		$.get('/api/clonacion/'+actual_usuario_id+'/permisos/'+destino_usuario_id+'/usuarios/',function(result){
			Swal.fire({
				title: 'Perfil Clonado...',
				text: 'puede continuar...',
				type: 'success',
				confirmButtonText: 'Ok',
				showConfirmButton: false,
				timer: 1500,
			  })
		});
		
	})
});


$(document).ready(function(){
	$('#desmarcarTodos').click(function(){
		var proyecto_id = $('.select_estructuras').val();
		$.get('/api/empresas/'+proyecto_id+'/porproyecto',function(resultado){
			// $("#tb-empresasxproyecto tr").empty(); 
			if (resultado.length>0){
					
					//document.getElementById("tb-empresasxproyecto").insertRow(-1).innerHTML = '<td></td><td></td><td></td><td></td>';
				//$("#tb-empresasxproyecto tr").remove(); 
				for (i=0;i<=resultado.length-1;i++)
        		{
					document.getElementById("tb-empresasxproyecto").insertRow(-1).innerHTML = '<td>'+resultado[i].id+'</td><td>'+resultado[i].empresa.nombre+'</td><td>'+resultado[i].proyecto.proyecto+'</td><td>'+resultado[i].contrato+'</td><td><center><input type="checkbox"  name="estructurasseleccionadas[]" value="'+resultado[i].id+'"><center></td>'; //<td><select class="form-control name="formularios"><option value="1">1.- Certificación Laboral</option><option value="2">2.- Auditoría Documental</option><option value="1">3.- Ambos Formularios</option></select></td>
				}
			}
		});
		
	});
});

$(document).ready(function(){
	$('#marcarTodos').click(function(){
		var proyecto_id = $('.select_estructuras').val();
		$.get('/api/empresas/'+proyecto_id+'/porproyecto',function(resultado){
			// $("#tb-empresasxproyecto tr").empty(); 
			if (resultado.length>0){
					
					//document.getElementById("tb-empresasxproyecto").insertRow(-1).innerHTML = '<td></td><td></td><td></td><td></td>';
				//$("#tb-empresasxproyecto tr").remove(); 
				for (i=0;i<=resultado.length-1;i++)
        		{
					document.getElementById("tb-empresasxproyecto").insertRow(-1).innerHTML = '<td>'+resultado[i].id+'</td><td>'+resultado[i].empresa.nombre+'</td><td>'+resultado[i].proyecto.proyecto+'</td><td>'+resultado[i].contrato+'</td><td><center><input type="checkbox" checked name="estructurasseleccionadas[]" value="'+resultado[i].id+'"><center></td>'; //<td><select class="form-control name="formularios"><option value="1">1.- Certificación Laboral</option><option value="2">2.- Auditoría Documental</option><option value="1">3.- Ambos Formularios</option></select></td>
				}
			}
		});
		
	});
});

// function btnZIP(solicitud_id){
// 		//alert(solicitud_id)
// 		$.get('/api/btn/'+solicitud_id+'/zip/',function(resultado){
// 			alert(resultado);
// 			Swal.fire({
// 				title: 'Compresión de Archivos',
// 				text: 'Compresión Finalizada...',
// 				type: 'success',
// 				confirmButtonText: 'Ok',
// 				showConfirmButton: false,
// 				timer: 1500,
// 			  });
// 		});
// 	}

