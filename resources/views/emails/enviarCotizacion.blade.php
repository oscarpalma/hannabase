<!DOCTYPE html>
<html lang="en">
<head>
<h3><center><strong> Cotizacion </strong></center></h3>
</head>
<body>
	<table border="1">
        <tr>
            <td class="clase1"><strong> De </strong></td>
            <td><center> {!!$email!!} </center></td>
        </tr>
    	<tr>
        	<td class="clase1"><strong> Asunto </strong></td>
            <td><center> {!!$asunto!!} </center></td>
        </tr>
    </table>

    <br>

	<table border="1">
    
    <tr>
		<td class="clase1"><strong> Solicita </strong> </td>
		<td><center> {!!$solicitante!!} </center></td>
        
        <td class="clase2"><strong> Fecha </strong> </td>
		<td><center> {!!$fecha!!} </center></td>
        
    </tr>
    
    <tr>
		<td class="clase1"><strong> Responsable </strong> </td>
		<td><center> {!!$responsable!!} </center></td>
        
        <td class="clase2"><strong> Area </strong> </td>
		<td><center> {!!$area!!} </center></td>
        
    </tr>
    
	</table>
    <table border="1">
    <tr>
    	<td class="clase1"><strong> Concepto </strong> </td>
		<td><center> {!!$concepto!!} </center></td>
    </tr>
    </table>

    <table border="1">
    <tr>
        <td class="clase1"><strong> Tipo de Pago </strong> </td>
        <td class="clase3"><center> {!!$tipo_pago!!} </center></td>
    </tr>
    </table>
      
    <br>
    <br>
    
    <table border="1">
    <tr>
    
    	<td class="clase1"><strong><center> Proveedor </center></strong> </td>
        <td class="clase1"><strong><center> Descripcion </center></strong> </td>
        <td class="clase1"><strong><center> Precio Unitario </center></strong> </td>
        <td class="clase1"><strong><center> Cantidad </center></strong> </td>
        <td class="clase1"><strong><center> Total </center></strong> </td>
        
    </tr>
    <tr>
    	<td><center> {!!$proveedor!!} </center></td>
        <td><center> {!!$descripcion!!} </center></td>
        <td><center> {!!$precio_unitario!!} </center></td>
        <td><center> {!!$cantidad!!} </center></td>
        <td><center> {!!$total!!} </center></td>
    </tr>
    </table>

    <br>
    Envia un correo nuevo con la eleccion de tu preferencia<text style="color:red">*</text>
</body>
</html>



<style>
	.clase1{
    	width: 5%;
    }
    
    .clase2{
    	width: 5%;
    }

    .clase3{
        width: 20%;
    }
</style>
