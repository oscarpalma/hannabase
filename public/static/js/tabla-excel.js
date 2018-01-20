/* Codigo creado por Gojko Adzic, localizado en https://github.com/mindmup/editable-table 
y adaptado por Oscar Palma para el presente sistema
Nota: Las lineas comentadas son las que se agregaron y/o modificaron*/

$.fn.tablaEditable = function (options) {
	'use strict';
	return $(this).each(function () {
		var buildDefaultOptions = function () {
				var opts = $.extend({}, $.fn.tablaEditable.defaultOptions);
				opts.editor = opts.editor.clone();
				return opts;
			},
			activeOptions = $.extend(buildDefaultOptions(), options),
			ARROW_LEFT = 37, ARROW_UP = 38, ARROW_RIGHT = 39, ARROW_DOWN = 40, ENTER = 13, ESC = 27, TAB = 9,
			element = $(this),
			editor = activeOptions.editor.css('position', 'absolute').hide().appendTo(element.parent().parent()),
			active,
			showEditor = function (select) {
				active = element.find('td:focus');
				if (active.length) {
					editor.val(active.text())
						.removeClass('error')
						.show()
						.offset(active.offset())
						.css(active.css(activeOptions.cloneProperties))
						.width(active.width())
						.height(active.height())
						.focus();
					if (select) {
						editor.select();
					}
				}
			},
			setActiveText = function () {
				var text = editor.val(),
					evt = $.Event('change'),
					originalContent;
				if (active.text() === text || editor.hasClass('error')) {
					return true;
				}
				originalContent = active.html();
				active.text(text).trigger(evt, text);
				if (evt.result === false) {
					active.html(originalContent);
				}
			},
			movement = function (element, keycode) {
				/* En esta función se evalua la tecla presionada para realizar
				el desplazamiento de celda */
				if (keycode === ARROW_RIGHT) {
					/* si se presiona la tecla derecha, se mueve a la celda de la
					derecha */
					return element.next('td');
				} else if (keycode === ARROW_LEFT) {
					/* se crea una variable para almacenar el numero de columnas
					 de la fila actual */
					var columnasActual = element.parent().find("td").length;
					/* se evalua que el numero de columnas de la fila actual 
					sea igual a 9 y si se encuentra	en la primer celda. Todo esto, debido a que,
					si se esta en la primera celda de una fila de 9 columnas y se desea desplazar a la
					izquierda, la celda de a lado no corresponde a la misma fila, sino a la fila que contiene la información
					de tipo de KPI y unidad */
					if (columnasActual==9 && element.index() == 0){
							/* se crea una variable con el valor de la fila anterior, 
							a la celda actual */
							var elemento = element.parent().prev();
							/*se obtiene el tamaño de la fila anterior*/
							var tamano = elemento.find("td").length;
							/* se realiza un ciclo para recorrer las filas anteriores
							a la actual, hasta encontrar una fila que su tamaño sea de 11,
							es decir, la fila que contiene el tipo de KPI y logro, la cual abarca 
							a la fila actual*/
							while(tamano == 9){
								/* se obtiene la fila anterior y el numero de columnas
								para evaluar la condición del while*/
								elemento=elemento.prev();
								tamano=elemento.find("td").length;
							}
							/* se devuelve la celda con indice 1, de la fila que engloba a la 
							fila actual*/
							return elemento.children().eq(1);
					}else{
						/* si no se cumple la condicion previa, se devuelve solamente
						la celda anterior a la actual*/
						return element.prev('td');
					}
				} else if (keycode === ARROW_UP) {
					/* se crean dos variables para almacenar el numero de columnas de la fila
					actual y de la fila anterior y una para almacenar el valor que se usará para
					sumar o restar al indice a devolver, dependiendo de la condición.*/
					var columnasActual = element.parent().find("td").length;
					var columnasAnterior = element.parent().prev().find("td").length;
					var valor=0;
					/* se evalua si el numero de columnas actual es menor al numero
					de columnas anterior. Si el numero de columnas actual es menor que el anterior,
					quiere decir que la fila anterior tiene 11 columnas, por ello el indice de la celda
					actual no corresponde al indice de la celda de la fila anterior que se encuentra 
					visiblemente encima de la celda actual. Por esto es necesario realizar un
					ajuste y sumarle dos al valor actual.*/
					if(columnasActual < columnasAnterior){

							valor = columnasAnterior - columnasActual;
						
					}else if(columnasActual> columnasAnterior){
						/* si el numero de columnas de la fila actual es mayor al numero
						de columnas de la fila enterior, quiere decir que la fila anterior
						tiene 9 columnas por lo que hay que realizar un ajuste en el indice*/
						/* La siguiente condición se utiliza para evaluar si la celda actual es
						la primera o segunda celda de la fila*/
						if(element.index() == 0 || element.index() ==1){
							/* se crea una variable con el valor de la fila anterior, 
							a la celda actual */
							var elemento = element.parent().prev();
							/*se obtiene el tamaño de la fila anterior*/
							var tamano = elemento.find("td").length;
							/* se realiza un ciclo para recorrer las filas anteriores
							a la actual, hasta encontrar una fila que su tamaño sea de 11,
							es decir, la fila que contiene el tipo de KPI y logro anterior al actual*/
							while(tamano == 9){
								/* se obtiene la fila anterior y el numero de columnas
								para evaluar la condición del while*/
								elemento=elemento.prev();
								tamano=elemento.find("td").length;
							}
							/* se devuelve la celda con indice igual a la celda actual, de la fila que contiene el tipo
							de KPI y logro anterior al actual*/
							return elemento.children().eq(element.index());
							
						}else{
							/* si no se cumple la condición anterior, solo se hace una resta que da
							el valor de -2 para realizar el ajuste correcto al momento de retornar
							el indice de la celda*/
							valor = columnasAnterior - columnasActual;
						}
					}
					/* se devuelve la celda de la fila anterior en el indice especificado*/
					return element.parent().prev().children().eq(element.index()+valor);
				} else if (keycode === ARROW_DOWN) {
					/* se crean dos variables para almacenar el numero de columnas de la fila
					actual y de la fila anterior y una para almacenar el valor que se usará para
					sumar o restar al indice a devolver, dependiendo de la condición.*/
					var columnasActual = element.parent().find("td").length;
					var columnasSiguientes = element.parent().next().find("td").length;
					var valor=0;
					/* se evalua si el numero de columnas actual es menor al numero
					de columnas de la siguiente fila. Si el numero de columnas actual es menor que el anterior,
					quiere decir que la fila siguiente tiene 11 columnas, por ello el indice de la celda
					actual no corresponde al indice de la celda de la fila anterior que se encuentra 
					visiblemente encima de la celda actual. Por esto es necesario realizar un
					ajuste y sumarle dos al valor actual.*/
					if(columnasActual < columnasSiguientes){
						valor = columnasSiguientes - columnasActual;
					}else if(columnasActual> columnasSiguientes){
						/* si el numero de columnas de la fila actual es mayor al numero
						de columnas de la fila siguiente, quiere decir que la fila siguiente
						tiene 9 columnas por lo que hay que realizar un ajuste en el indice*/
						/* La siguiente condición se utiliza para evaluar si la celda actual es
						la primera o segunda celda de la fila*/
						if(element.index() == 0 || element.index() ==1){
							/* se crea una variable con el valor de la fila siguiente, 
							a la celda actual */
							var elemento = element.parent().next();
							/*se obtiene el tamaño de la fila siguiente*/
							var tamano = elemento.find("td").length;
							/* se realiza un ciclo para recorrer las filas siguientes
							a la actual, hasta encontrar una fila que su tamaño sea de 11,
							es decir, la fila que contiene el tipo de KPI y logro siguiente al actual*/
							while(tamano == 9){
								/* se obtiene la fila siguiente y el numero de columnas
								para evaluar la condición del while*/
								elemento=elemento.next();
								tamano=elemento.find("td").length;
							}
							/* se devuelve la celda con indice igual a la celda actual, de la fila que contiene el tipo
							de KPI y logro siguiente al actual*/
							return elemento.children().eq(element.index());
						}else{
							/* si no se cumple la condición anterior, solo se hace una resta que da
							el valor de -2 para realizar el ajuste correcto al momento de retornar
							el indice de la celda*/
							valor = columnasSiguientes - columnasActual;
						}
					}
					/* se devuelve la celda de la fila siguiente en el indice especificado*/
					return element.parent().next().children().eq(element.index()+valor);
				}
				return [];
			};
		editor.blur(function () {
			setActiveText();
			editor.hide();
		}).keydown(function (e) {
			if (e.which === ENTER) {
				setActiveText();
				editor.hide();
				active.focus();
				e.preventDefault();
				e.stopPropagation();
			} else if (e.which === ESC) {
				editor.val(active.text());
				e.preventDefault();
				e.stopPropagation();
				editor.hide();
				active.focus();
			} else if (e.which === TAB) {
				active.focus();
			} else if (this.selectionEnd - this.selectionStart === this.value.length) {
				var possibleMove = movement(active, e.which);
				if (possibleMove.length > 0) {
					possibleMove.focus();
					e.preventDefault();
					e.stopPropagation();
				}
			}
		})
		.on('input paste', function () {
			var evt = $.Event('validate');
			active.trigger(evt, editor.val());
			if (evt.result === false) {
				editor.addClass('error');
			} else {
				editor.removeClass('error');
			}
		});
		element.on('click keypress dblclick', showEditor)
		.css('cursor', 'pointer')
		.keydown(function (e) {
			var prevent = true,
				possibleMove = movement($(e.target), e.which);
			if (possibleMove.length > 0) {
				possibleMove.focus();
			} else if (e.which === ENTER) {
				showEditor(false);
			} else if (e.which === 17 || e.which === 91 || e.which === 93) {
				showEditor(true);
				prevent = false;
			} else {
				prevent = false;
			}
			if (prevent) {
				e.stopPropagation();
				e.preventDefault();
			}
		});

		element.find('td').prop('tabindex', 1);

		$(window).on('resize', function () {
			if (editor.is(':visible')) {
				editor.offset(active.offset())
				.width(active.width())
				.height(active.height());
			}
		});
	});

};
$.fn.tablaEditable.defaultOptions = {
	cloneProperties: ['padding', 'padding-top', 'padding-bottom', 'padding-left', 'padding-right',
					  'text-align', 'font', 'font-size', 'font-family', 'font-weight',
					  'border', 'border-top', 'border-bottom', 'border-left', 'border-right'],
	editor: $('<input>')
};