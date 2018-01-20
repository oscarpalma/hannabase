<!doctype html>
<title>Si Privilegios</title>
<link href="/css/app.css" rel="stylesheet">
<style>
  body { text-align: center; padding: 150px; }
  h1 { font-size: 50px; }
  body { font: 20px Helvetica, sans-serif; color: #333; }
  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
  a { color: #dc8100; text-decoration: none; }
  a:hover { color: #333; text-decoration: none; }
</style>

<article>
<center><img src="/static/imagenes/hana.png" width="200px" ></center> 
    <h2>Bienvenido(a) {{Auth::user()->name}}</h2>
    <div>
        <p>Su cuenta ha sido registrada exitosamente. Espere a que un administrador le 
        proporcione los privilegios adecuados. Recargue la página para verificar. 
        </p>
        <p>&mdash; HanaBase Administration</p>
    </div>
    <center> <div class="link"><a class="btn btn-primary" href="/" style="color:white"><text style="color:white; font-weight: bolder; font-size:12px;">Recargar</text></a></div><br><div class="link"><a class="btn btn-primary" href="/auth/logout" style="color:white"><text style="color:white; font-weight: bolder; font-size:12px;">Salir</text></a></div></center>
</article>