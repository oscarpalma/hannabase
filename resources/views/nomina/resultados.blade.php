<?php
  
   header('Content-type: text/plain; charset=utf-8');
	header("Content-Disposition: attachment; filename=\"semana $semana.hb\"");
header("Content-Transfer-Encoding: binary"); 
    header('Pragma: no-cache'); 
    header('Expires: 0');

foreach($checadas as $checada){
echo $checada->idChecada.'|'.$checada->idTurno.'|'.$checada->idEmpleado.'|'.$checada->fecha.'|'.$checada->hora_entrada.'|'.$checada->hora_salida.'|'.$checada->horas_ordinarias.'|'.$checada->horas_extra.'|'.$checada->incidencia.'|'.$checada->comentarios . "$";
}

print '~';

foreach($empleados as $empleado){
print $empleado->idEmpleado.'|'.$empleado->ap_paterno.'|'.$empleado->ap_materno.'|'.$empleado->nombres.'|'.$empleado->no_cuenta . "$";

}

print '~';

foreach($clientes as $cliente){
print $cliente->idCliente.'|'.$cliente->nombre . "$";

}
print '~';

foreach($turnos as $turno){
print $turno->idTurno.'|'.$turno->idCliente.'|'.$turno->hora_entrada.'|'.$turno->hora_salida.'|'.$turno->horas_trabajadas . "$";

}

print '~';

foreach($comedores as $comedor){
print $comedor->id.'|'.$comedor->idEmpleado.'|'.$comedor->fecha.'|'.$comedor->cantidad . "$";

}

print '~';

foreach($descuentos as $descuento){
print $descuento->id_descuentos.'|'.$descuento->empleado.'|'.$descuento->descuento.'|'.$descuento->fecha.'|'.$descuento->comentario.'|'.$descuento->created_at.'|'.$descuento->updated_at . "$";

}

print '~';

foreach($reembolsos as $reembolso){
print $descuento->id_descuentos.'|'.$descuento->empleado.'|'.$descuento->descuento.'|'.$descuento->fecha.'|'.$descuento->comentario.'|'.$descuento->created_at.'|'.$descuento->updated_at . "$";

}

print '~';

foreach($tipo_descuentos as $tipo_descuento){
print $tipo_descuento->id_descuento.'|'.$tipo_descuento->nombre_descuento.'|'.$tipo_descuento->precio . "$";

}

print '~';

print $semana.'|'.$fecha1.'|'.$fecha2 . "$";
?>