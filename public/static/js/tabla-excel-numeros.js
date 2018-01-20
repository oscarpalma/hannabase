/* Codigo creado por Gojko Adzic, localizado en https://github.com/mindmup/editable-table 
y adaptado por Oscar Palma para el presente sistema
Nota: Las lineas comentadas son las que se agregaron y/o modificaron*/

$.fn.soloNumeros = function () {
	'use strict';
	var element = $(this),
		
		dataRows = element.find('tbody tr'),
		initialTotal = function () {
			/*Esta función solo se activa al cargar la tabla, o realizar alguna modificacion
			en la estructura de la misma*/
			//se crean las variables que seran utilizadas para la validación de numeros
			var column, total, valor, divisor, columnas;
				total = 0;
				//Se recorren cada una de las filas de la tabla
				dataRows.each(function () {
					//se obtiene la fila actual
					var row = $(this);
					//se guarda la cantidad de columnas de la fila
					columnas = row.find('td').length;
					//Se evalua el numero de columnas
					if (columnas==9){
						// si es 9 entonces se inicia en el indice 1
						column=1;
					}else{
						// si no es 9, entonces es 11 y se inicia en el indice 3
						column=3;
					}
					//se pone total y divisor en 0 para borrar el valor anterior		
					total = 0;
					divisor = 0;
					/* el siguiente ciclo for se utiliza para recorre las celdas
					de la fila actual para realizar la suma de todas las celdas*/
					for (column; column < (columnas-1); column++) {
						//Se obtiene el valor de la celda en el indice especificado
						valor = row.children().eq(column).text();
						/* se evalua que al convertir el valor a entero no devuelva NaN,
						es decir, que no devuelva que no es un valor númerico para evitar errores
						en la suma y cálculo del promedio*/
						if (!isNaN(parseInt(valor))){
							/* si la canversión es posible, se realiza la suma del valor de total
							mas el valor de la celda actual y se incrementa el divisor*/
							total += parseInt(valor);
							divisor++;
						}
					}
					/*se verifica que el divisor sea mayor a cero para evitar errores y se
					agrega el promedio de la suma a la ultima columna de la fila actual*/

					if(divisor>0)
						row.children().eq(column).text(total/divisor);


				});
				
		};
	//la siguiente funcion se activa cuando se realiza algun cambio en una celda
	element.find('td').on('change', function (evt) {
		//se crean las variables que seran utilizadas para la validación de numeros
		var column = 0,
			total = 0, divisor = 0, row, columnas;
		
		//se recorren las filas de la tabla
		$(this).parents("tr").each(function () {
			//se obtiene la fila
			row = $(this);
			// se obtiene el numero de celdas de la fila
			columnas = row.find('td').length;
			//se evalua el numero de celdas de la fila
			if (columnas==9){
				//si es nueve, se empieza en el indice 1
				column=1;
			}else{
				//si no es nueve entonces es 11 y se empieza en el indice 3
				column=3;
			}
			/* el siguiente ciclo for se utiliza para recorre las celdas
					de la fila actual para realizar la suma de todas las celdas*/
			for (column; column < (columnas-1); column++) {
				//Se obtiene el valor de la celda en el indice especificado
				var valor = row.children().eq(column).text();
				/* se evalua que al convertir el valor a entero no devuelva NaN,
						es decir, que no devuelva que no es un valor númerico para evitar errores
						en la suma y cálculo del promedio*/
				if (!isNaN(parseInt(valor))){
					total += parseInt(valor);
					divisor++;			
				}
				
			}
			
			
			
		});
		if (column === 1 && total > 50000) {
			$('.alert').show();
			return false; // changes can be rejected
		} else if(divisor>0) {
			/*se verifica que el divisor sea mayor a cero para evitar errores y se
					agrega el promedio de la suma a la ultima columna de la fila actual*/
			/* se obtiene el valor del atributo formula para aquellos logros que
			se requiere se sume en vez que se calcule promedio*/
			var formula = row.children().eq(0).attr('formula');
			if(formula!="suma"){
var promedio = total/divisor;
				row.children().eq(column).text(promedio.toFixed(2));
			}else{
				row.children().eq(column).text(total);
			}
		}
	}).on('validate', function (evt, value) {
		/* esta función se utiliza para validar el valor de una celda
		cuando esta se esta editando*/
		var cell = $(this),
			column = cell.index(), columnas;
		/* se obtiene el numero de celdas o columnas de la fila donde
		se encuentra la celda a validar*/
		columnas = cell.parent().find('td').length;
		/* si el numero de columnas es igual a 9 y el indice de la columna
		a validar es 0 entonces se devuelve el valor especificado*/
		if (columnas==9 && column === 0) {
			return !!value && value.trim().length > 0;
		}else if(columnas==11 && column <= 2){
			return !!value && value.trim().length > 0;
		}else {
			return !isNaN(parseFloat(value)) && isFinite(value);
		}
	});
	initialTotal();
	return this;
};