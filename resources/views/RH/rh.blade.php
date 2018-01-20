@extends('base')
@section('cabezera','Editar Requerimiento')
@section('css')
  
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">
  	<link href="/static/cssKpi/kpi.css" rel="stylesheet">
<!-- Morris Charts CSS -->
    <link href="/static/bower_components/morrisjs/morris.css" rel="stylesheet">
    <style type="text/css">
    	/***
Bootstrap Line Tabs by @keenthemes
A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
Licensed under MIT
***/

/* Tabs panel */
.tabbable-panel {
  border:1px solid #eee;
  padding: 10px;
}
.tabbable-line.tabs-below{
	position:relative;
    margin:0 auto;
    overflow:hidden;
	padding:5px;
  	height:50px;

}

/* Default mode */
.tabbable-line > .nav-tabs {

  border: none;
  margin: 0px;
}
.tabbable-line > .nav-tabs > li {
  margin-right: 2px;
}
.tabbable-line > .nav-tabs > li > a {
  border: 0;
  margin-right: 0;
  color: #737373;
}
.tabbable-line > .nav-tabs > li > a > i {
  color: #a6a6a6;
}
.tabbable-line > .nav-tabs > li.open, .tabbable-line > .nav-tabs > li:hover {
  border-bottom: 4px solid #fbcdcf;
}
.tabbable-line > .nav-tabs > li.open > a, .tabbable-line > .nav-tabs > li:hover > a {
  border: 0;
  background: none !important;
  color: #333333;
}
.tabbable-line > .nav-tabs > li.open > a > i, .tabbable-line > .nav-tabs > li:hover > a > i {
  color: #a6a6a6;
}
.tabbable-line > .nav-tabs > li.open .dropdown-menu, .tabbable-line > .nav-tabs > li:hover .dropdown-menu {
  margin-top: 0px;
}
.tabbable-line > .nav-tabs > li.active {
  border-bottom: 4px solid #f3565d;
  position: relative;
}
.tabbable-line > .nav-tabs > li.active > a {
  border: 0;
  color: #333333;
}
.tabbable-line > .nav-tabs > li.active > a > i {
  color: #404040;
}
.tabbable-line > .tab-content {
  margin-top: -3px;
  background-color: #fff;
  border: 0;
  border-top: 1px solid #eee;
  padding: 15px 0;
}
.portlet .tabbable-line > .tab-content {
  padding-bottom: 0;
}

/* Below tabs mode */

.tabbable-line.tabs-below > .nav-tabs > li {
  border-top: 4px solid transparent;
}
.tabbable-line.tabs-below > .nav-tabs > li > a {
  margin-top: 0;
}
.tabbable-line.tabs-below > .nav-tabs > li:hover {
  border-bottom: 0;
  border-top: 4px solid #fbcdcf;
}
.tabbable-line.tabs-below > .nav-tabs > li.active {
  margin-bottom: -2px;
  border-bottom: 0;
  border-top: 4px solid #f3565d;
}
.tabbable-line.tabs-below > .tab-content {
  margin-top: -10px;
  border-top: 0;
  border-bottom: 1px solid #eee;
  padding-bottom: 15px;
}

.wrapper {
    position:relative;
    margin:0 auto;
    overflow:hidden;
	padding:5px;
  	height:50px;
}

.list {
    position:absolute;
    left:0px;
    top:0px;
  	min-width:5000px;
  	  	
}

.list li{
	display:table-cell;
    position:relative;
    text-align:center;
    cursor:grab;
    cursor:-webkit-grab;
    color:#efefef;
    vertical-align:middle;
    border-width: 2px;
  	border-style: solid;
}

.scroller {
  text-align:center;
  cursor:pointer;
  display:none;
  padding:7px;
  padding-top:11px;
  white-space:no-wrap;
  vertical-align:middle;
  background-color:#fff;
}

.scroller-right{
  float:right;
}

.scroller-left {
  float:left;
}
    </style>
@endsection
@section('content')

<!-- alerta que se muestra en caso de que no se encuentre algun resultado -->
<div class="alert alert-info alert-dismissible" role="alert" hidden="" id="error">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-info" aria-hidden="true"></span></strong> No hay formato de KPI para el área especificada
				
	</div>

<!-- El siguiente div se utiliza para hacer descender el scrollbar hasta este punto
	una vez que se muestran los resultados -->
	<div id="resultados">
	<!-- La siguiente alerta se encuentra oculta debido a que solo se mostrará cuando 
	se guarde exitosamente -->
	<div class="alert alert-success alert-dismissible" role="alert" hidden="" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> Cambios guardados
				
	</div>

	<!--Tabla con los resultados de la busqueda-->
	<div class="panel panel-primary">
          <div class="panel-heading">
          		<span class="glyphicon glyphicon-dashboard"></span> KPI <span id="area_tabla"></span> Semana <span id="no_semana"></span>
                    <div class="pull-right action-buttons">
                        <div class=" pull-right">
                        <!-- boton para guardar los cambios -->
                           <button type="button" class="btn btn-success btn-xs dropdown-toggle" id="save" title="Guardar">
                          <span class="glyphicon glyphicon-floppy-disk"></span>
                        
                        </button>
                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" id="btnExport" title="Exportar">
                          <span class="fa fa-file-excel-o"></span>
                        
                        </button>

                            
                        </div>
                    </div>
          </div> 
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">

     <!-- En el siguiente div se cargará la tabla del KPI una vez obtenida -->                     
    <div class="tabla" id="tblExport">
		<table id="table" class="table table-striped table-bordered table-hover letra" >
<thead>
<tr class="tableizer-firstrow">
	<th></th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th colspan="2">CUSTOMER SUPPORT WEEK 31</th>
	<th>TOTAL SUPPORT</th>
	<th>654</th>
	<th>TOTAL SUPPORT</th>
	<th>523</th>
	<th>RATE(%)</th>
	<th>80%</th>
	<th>TOTAL SUPPORT</th>
	<th>667</th>
	<th>TOTAL SUPPORT</th>
	<th>614 </th><th>RATE(%)</th>
	<th>92%</th>
	<th>TOTAL SUPPORT</th>
	<th>694</th>
	<th>TOTAL SUPPORT</th>
	<th>653</th>
	<th>&nbsp;</th>
	<th>94%</th>
	<th>TOTAL SUPPORT</th>
	<th>689</th>
	<th>TOTAL SUPPORT</th>
	<th>662</th>
	<th>&nbsp;</th>
	<th>96%</th>
	<th>TOTAL SUPPORT</th>
	<th>748</th>
	<th>TOTAL SUPPORT</th>
	<th>652</th>
	<th>RATE(%)</th>
	<th>87%</th>
	<th>TOTAL SUPPORT</th>
	<th>467</th>
	<th>TOTAL SUPPORT</th>
	<th>467</th>
	<th>RATE(%)</th>
	<th>100%</th>
	<th>TOTAL SUPPORT</th>
	<th>147</th>
	<th>TOTAL SUPPORT</th>
	<th>150</th>
	<th>RATE(%)</th>
	<th>102%</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	</tr></thead>
	<tbody>
 <tr>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>WEEKDAY AVERAGE:</td>
	 <td>563</td><td>SUPPORT</td>
	 <td>DAY REQUEST</td>
	 <td>RATE(%)</td>
	 <td>SUPPORT</td>
	 <td>NIGHT REQUEST</td>
	 <td>RATE(%)</td>
	 <td>SUPPORT</td>
	 <td>DAY REQUEST</td>
	 <td>RATE(%)</td>
	 <td>SUPPORT</td>
	 <td>NIGHT REQUEST</td>
	 <td>RATE(%)</td>
	 <td>SUPPORT</td>
	 <td>DAY REQUEST</td>
	 <td>RATE(%)</td>
	 <td>SUPPORT</td>
	 <td>NIGHT REQUEST</td>
	 <td>RATE(%)</td>
	 <td>SUPPORT</td>
	 <td>DAY REQUEST</td>
	 <td>RATE(%)</td>
	 <td>SUPPORT</td>
	 <td>NIGHT REQUEST</td>
	 <td>RATE(%)</td>
	 <td>SUPPORT</td>
	 <td>DAY REQUEST</td>
	 <td>RATE(%)</td>
	 <td>SUPPORT</td>
	 <td>NIGHT REQUEST</td>
	 <td>RATE(%)</td>
	 <td>SUPPORT</td>
	 <td>DAY REQUEST</td>
	 <td>RATE(%)</td>
	 <td>SUPPORT</td>
	 <td>NIGHT REQUEST</td>
	 <td>RATE(%)</td>
	 <td>SUPPORT</td>
	 <td>DAY REQUEST</td>
	 <td>RATE(%)</td>
	 <td>SUPPORT</td>
	 <td>NIGHT REQUEST</td>
	 <td>RATE(%)</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
 </tr>
 <tr>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>WEEKEND AVERAGE:</td>
	 <td>308.5</td>
	 <td class="smdsp">266</td>
	 <td class="smdrq">362</td>
	 <td>73%</td>
	 <td>258</td>
	 <td>292</td>
	 <td>88%</td>
	 <td>331</td>
	 <td>393</td>
	 <td>84%</td>
	 <td>283 </td>
	 <td>274</td>
	 <td>97%</td>
	 <td>362</td>
	 <td>406</td>
	 <td>89%</td>
	 <td>291</td>
	 <td>288</td>
	 <td>101%</td>
	 <td>373</td>
	 <td>388</td>
	 <td>96%</td>
	 <td>289</td>
	 <td>301</td>
	 <td>96%</td>
	 <td>378</td>
	 <td>413</td>
	 <td>92%</td>
	 <td>274</td>
	 <td>335</td>
	 <td>82%</td>
	 <td>237</td>
	 <td>245</td>
	 <td>97%</td>
	 <td>230</td>
	 <td>222</td>
	 <td>104%</td>
	 <td>56</td>
	 <td>56</td>
	 <td>100%</td>
	 <td>94</td>
	 <td>91</td>
	 <td>103%</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
 </tr>
 <tr>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>WEEK AVERAGE:</td>
	 <td>490</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
 </tr>
 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td colspan="3">lunes, 31 de julio de 2017</td>
 <td>&nbsp;</td>
 <td>523</td>
 <td>&nbsp;</td>
 <td colspan="3">martes, 1 de agosto de 2017</td>
 <td>614</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td><td colspan="3">miércoles, 2 de agosto de 2017</td>
 <td>&nbsp;</td>
 <td>653</td>
 <td>&nbsp;</td>
 <td colspan="3">jueves, 3 de agosto de 2017</td>
 <td>&nbsp;</td>
 <td>373</td>
 <td>&nbsp;</td>
 <td colspan="3">viernes, 4 de agosto de 2017</td>
 <td>&nbsp;</td>
 <td>652</td>
 <td>&nbsp;</td>
 <td colspan="3">sábado, 5 de agosto de 2017</td>
 <td>&nbsp;</td>
 <td>467</td>
 <td>&nbsp;</td>
 <td colspan="3">domingo, 6 de agosto de 2017</td>
 <td>&nbsp;</td>
 <td>150</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 </tr>
 <tr>
 <td>&nbsp;</td>
 <td>SEMANA ACTUAL</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td colspan="3">lunes, 31 de julio de 2017</td>
 <td colspan="3">lunes, 31 de julio de 2017</td>
 <td colspan="3">martes, 1 de agosto de 2017</td>
 <td colspan="3">martes, 1 de agosto de 2017</td>
 <td colspan="3">miércoles, 2 de agosto de 2017</td>
 <td colspan="3">miércoles, 2 de agosto de 2017</td>
 <td colspan="3">jueves, 3 de agosto de 2017</td>
 <td colspan="3">jueves, 3 de agosto de 2017</td>
 <td colspan="3">viernes, 4 de agosto de 2017</td>
 <td colspan="3">viernes, 4 de agosto de 2017</td>
 <td colspan="3">sábado, 5 de agosto de 2017</td>
 <td colspan="3">sábado, 5 de agosto de 2017</td>
 <td colspan="3">domingo, 6 de agosto de 2017</td>
 <td colspan="3">domingo, 6 de agosto de 2017</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 </tr>
 <tr>
 <td>Week 31</td>
 <td>Requerimiento</td>
 <td>Soporte Actual</td>
 <td>Diferencia</td>
 <td>% Diario</td>
 <td>COORDINADOR</td>
 <td>CUSTOMER</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>DIFFERENCE</td>
 <td>QTY</td>
 <td>REQUEST</td>
 <td>DIFFERENCE</td>
 <td>QTY</td>
 <td>REQUEST</td>
 <td>DIFFERENCE</td>
 <td>QTY</td>
 <td>REQUEST</td>
 <td>DIFFERENCE</td>
 <td>QTY</td>
 <td>REQUEST</td>
 <td>DIFFERENCE</td>
 <td>QTY</td>
 <td>REQUEST</td>
 <td>DIFFERENCE</td>
 <td>QTY</td>
 <td>REQUEST</td>
 <td>DIFFERENCE</td>
 <td>QTY</td>
 <td>REQUEST</td>
 <td>DIFFERENCE</td>
 <td>QTY</td>
 <td>REQUEST</td>
 <td>DIFFERENCE</td>
 <td>QTY</td>
 <td>REQUEST</td>
 <td>DIFFERENCE</td>
 <td>QTY</td>
 <td>REQUEST</td>
 <td>DIFFERENCE</td>
 <td>QTY</td>
 <td>REQUEST</td>
 <td>DIFFERENCE</td>
 <td>QTY</td>
 <td>REQUEST</td>
 <td>DIFFERENCE</td>
 <td>QTY</td>
 <td>REQUEST</td>
 <td>DIFFERENCE</td>
 <td>TOTAL</td>
 <td>AVERAGE</td>
 <td>MORNING</td>
 <td>NIGHT</td>
 </tr>
 <tr>
 <td>LUNES</td>
 <td>654</td>
 <td>523 </td>
 <td>-131</td>
 <td>80%</td>
 <td>JUAN</td>
 <td>SAMEX ( OPEN CELL)</td>
 <td class="mdsp">3</td>
 <td class="mdrq">3</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>3</td>
 <td>3</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>3</td>
 <td>3</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>3</td>
 <td>3</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>3</td>
 <td>3</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>15</td>
 <td>2</td>
 <td>15</td>
 <td>0</td>
 </tr>
 <tr>
 <td>MARTES</td>
 <td>667</td>
 <td>614 </td>
 <td>-53</td>
 <td>92%</td>
 <td>JUAN</td>
 <td>GPT YARDAS</td>
 <td class="mdsp">2</td>
 <td class="mdrq">3</td>
 <td>-1 </td>
 <td>5</td>
 <td>5</td>
 <td>0 </td>
 <td>2</td>
 <td>3</td>
 <td>-1 </td>
 <td>5</td>
 <td>5</td>
 <td>0 </td>
 <td>3</td>
 <td>3</td>
 <td>0 </td>
 <td>5</td>
 <td>5</td>
 <td>0 </td>
 <td>3</td>
 <td>3</td>
 <td>0 </td>
 <td>5</td>
 <td>5</td>
 <td>0 </td>
 <td>3</td>
 <td>3</td>
 <td>0 </td>
 <td>5</td>
 <td>5</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>38</td>
 <td>5</td>
 <td>13</td>
 <td>25</td>
 </tr>
 <tr>
 <td>MIERCOLES</td>
 <td>694</td>
 <td>653</td>
 <td>-41</td>
 <td>94%</td>
 <td>ELVIA </td>
 <td>WOORI</td>
 <td class="mdsp">31</td>
 <td class="mdrq">31</td>
 <td>0 </td>
 <td>19</td>
 <td>19</td>
 <td>0 </td>
 <td>30</td>
 <td>31</td>
 <td>-1 </td>
 <td>20</td>
 <td>20</td>
 <td>0 </td>
 <td>30</td>
 <td>31</td>
 <td>-1 </td>
 <td>20</td>
 <td>20</td>
 <td>0 </td>
 <td>31</td>
 <td>31</td>
 <td>0 </td>
 <td>18</td>
 <td>20</td>
 <td>-2 </td>
 <td>30</td>
 <td>31</td>
 <td>-1 </td>
 <td>17</td>
 <td>20</td>
 <td>-3 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>246</td>
 <td>35</td>
 <td>152</td>
 <td>94</td>
 </tr>
 <tr>
 <td>JUEVES</td>
 <td>689</td>
 <td>662</td>
 <td>-27</td>
 <td>96%</td>
 <td>ELVIA </td>
 <td>ALLMEX-OTAY</td>
 <td class="mdsp">0</td>
 <td class="mdrq">0</td>
 <td>0 </td>
 <td>1</td>
 <td>1</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>1</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>1</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>1</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>1</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>5</td>
 <td>1</td>
 <td>0</td>
 <td>5</td>
 </tr>
 <tr>
 <td>VIERNES</td>
 <td>748</td>
 <td>652</td>
 <td>-96</td>
 <td>87%</td>
 <td>ELIZABETH</td>
 <td>TAW</td>
 <td class="mdsp">54</td>
 <td class="mdrq">70</td>
 <td>-16 </td>
 <td>60</td>
 <td>90</td>
 <td>-30 </td>
 <td>69</td>
 <td>90</td>
 <td>-21 </td>
 <td>65</td>
 <td>61</td>
 <td>4 </td>
 <td>79</td>
 <td>90</td>
 <td>-11 </td>
 <td>71</td>
 <td>75</td>
 <td>-4 </td>
 <td>87</td>
 <td>95</td>
 <td>-8 </td>
 <td>76</td>
 <td>75</td>
 <td>1 </td>
 <td>103</td>
 <td>120</td>
 <td>-17 </td>
 <td>61</td>
 <td>75</td>
 <td>-14 </td>
 <td>111</td>
 <td>110</td>
 <td>1 </td>
 <td>59</td>
 <td>50</td>
 <td>9 </td>
 <td>15</td>
 <td>15</td>
 <td>0 </td>
 <td>16</td>
 <td>16</td>
 <td>0 </td>
 <td>922</td>
 <td>132</td>
 <td>518</td>
 <td>404</td>
 </tr>
 <tr>
 <td>SABADO</td>
 <td>467</td>
 <td>467</td>
 <td>0</td>
 <td>100%</td>
 <td>JOCELYN</td>
 <td>HD PANEL</td>
 <td class="mdsp">3</td>
 <td class="mdrq">3</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>3</td>
 <td>3</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>3</td>
 <td>3</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>3</td>
 <td>3</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>3</td>
 <td>3</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>15</td>
 <td>2</td>
 <td>15</td>
 <td>0</td>
 </tr>

 <tr>
 <td>DOMINGO</td>
 <td>147</td>
 <td>150</td>
 <td>3</td>
 <td>102%</td>
 <td>IYARZABAL</td>
 <td>ALLMEX-INSURGENTES</td>
 <td class="mdsp">1</td>
 <td class="mdrq">2</td>
 <td>-1 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>2</td>
 <td>-1 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>2</td>
 <td>-1 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>1</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>1</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>5</td>
 <td>1</td>
 <td>5</td>
 <td>0</td>
 </tr>

 <tr>
 <td>PROMEDIO (LU ~ VI)</td>
 <td>690.4</td>
 <td>620.8</td>
 <td>-69.6</td>
 <td>90%</td>
 <td>DOLORES</td>
 <td>INZI</td>
 <td class="mdsp">19</td>
 <td class="mdrq">41</td>
 <td>-22 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>33</td>
 <td>41</td>
 <td>-8 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>39</td>
 <td>41</td>
 <td>-2 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>36</td>
 <td>41</td>
 <td>-5 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>38</td>
 <td>41</td>
 <td>-3 </td>
 <td>5</td>
 <td>40</td>
 <td>-35 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>170</td>
 <td>24</td>
 <td>165</td>
 <td>5</td>
 </tr>
 <tr>
 <td>PROMEDIO (SA ~ DO)</td>
 <td>307</td>
 <td>308.5</td>
 <td>1.5</td>
 <td>100%</td>
 <td>JOCELYN</td>
 <td>OK CART</td>
 <td class="mdsp">26</td>
 <td class="mdrq">28</td>
 <td>-2 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>29</td>
 <td>28</td>
 <td>1 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>18</td>
 <td>18</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>17</td>
 <td>17</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>17</td>
 <td>17</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>107</td>
 <td>15</td>
 <td>107</td>
 <td>0</td>
 </tr>

 <tr>
 <td>PROMEDIO(LU-DO)</td>
 <td>580.86</td>
 <td>531.57</td>
 <td>-49.29</td>
 <td>92%</td>
 <td>GUADALUPE</td>
 <td>SSD</td>
 <td class="mdsp">46</td>
 <td class="mdrq">56</td>
 <td>-10 </td>
 <td>109</td>
 <td>110</td>
 <td>-1 </td>
 <td>54</td>
 <td>55</td>
 <td>-1 </td>
 <td>119</td>
 <td>112</td>
 <td>0 </td>
 <td>59</td>
 <td>60</td>
 <td>-1 </td>
 <td>126</td>
 <td>122</td>
 <td>4 </td>
 <td>59</td>
 <td>59</td>
 <td>0 </td>
 <td>117</td>
 <td>125</td>
 <td>-8 </td>
 <td>58</td>
 <td>59</td>
 <td>-1 </td>
 <td>115</td>
 <td>122</td>
 <td>-7 </td>
 <td>42</td>
 <td>55</td>
 <td>-13 </td>
 <td>128</td>
 <td>127</td>
 <td>1 </td>
 <td>41</td>
 <td>41</td>
 <td>0 </td>
 <td>78</td>
 <td>75</td>
 <td>3 </td>
 <td>1144</td>
 <td>163</td>
 <td>359</td>
 <td>785</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>JOCELYN</td>
 <td>SAMIL</td>
 <td class="mdsp">4</td>
 <td class="mdrq">7</td>
 <td>-3 </td>
 <td>12</td>
 <td>12</td>
 <td>0 </td>
 <td>5</td>
 <td>7</td>
 <td>-2 </td>
 <td>10</td>
 <td>10</td>
 <td>0 </td>
 <td>6</td>
 <td>7</td>
 <td>-1 </td>
 <td>9</td>
 <td>10</td>
 <td>-1 </td>
 <td>6</td>
 <td>7</td>
 <td>-1 </td>
 <td>9</td>
 <td>10</td>
 <td>-1 </td>
 <td>6</td>
 <td>7</td>
 <td>-1 </td>
 <td>6</td>
 <td>7</td>
 <td>-1 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>73</td>
 <td>10</td>
 <td>27</td>
 <td>46</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>JUAN</td>
 <td>SAMEX GPT CONTAINER</td>
 <td class="mdsp">1</td>
 <td class="mdrq">1</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>1</td>
 <td>0 </td>
 <td>0</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>1</td>
 <td>1</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>1</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>1</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>5</td>
 <td>1</td>
 <td>5</td>
 <td>0</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>JUAN</td>
 <td>AMEX SOLDADORES</td>
 <td class="mdsp">1</td>
 <td class="mdrq">13</td>
 <td>-12 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>13</td>
 <td>-12 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>13</td>
 <td>-12 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>1</td>
 <td>13</td>
 <td>-12 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>0</td>
 <td>13</td>
 <td>-13 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>4</td>
 <td>1</td>
 <td>4</td>
 <td>0</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>JUAN </td>
 <td>AMEX OPERADORES </td>
 <td class="mdsp">10</td>
 <td class="mdrq">14</td>
 <td>-4 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>11</td>
 <td>14</td>
 <td>-3 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>11</td>
 <td>14</td>
 <td>-3 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>14</td>
 <td>14</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>9</td>
 <td>9</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>55</td>
 <td>8</td>
 <td>55</td>
 <td>0</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>JUAN</td>
 <td>GPT TRAFICO</td>
 <td class="mdsp">5</td>
 <td class="mdrq">5</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>4</td>
 <td>5</td>
 <td>-1 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>5</td>
 <td>5</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>5</td>
 <td>5</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>5</td>
 <td>5</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>#¡REF!</td>
 <td>#¡REF!</td>
 <td>24</td>
 <td>0</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>IYARZABAL</td>
 <td>C&J  AGUILA</td>
 <td class="mdsp">40</td>
 <td class="mdrq">50</td>
 <td>-10 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>62</td>
 <td>62</td>
 <td>0 </td>
 <td>10</td>
 <td>10</td>
 <td>0 </td>
 <td>77</td>
 <td>80</td>
 <td>-3 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>10</td>
 <td>10</td>
 <td>0 </td>
 <td>71</td>
 <td>65</td>
 <td>6 </td>
 <td>10</td>
 <td>10</td>
 <td>0 </td>
 <td>66</td>
 <td>65</td>
 <td>1 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>#¡REF!</td>
 <td>#¡REF!</td>
 <td>316</td>
 <td>30</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>IYARZABAL</td>
 <td>C&J T/B</td>
 <td class="mdsp">0</td>
 <td class="mdrq">0</td>
 <td>0 </td>
 <td>30</td>
 <td>30</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>32</td>
 <td>30</td>
 <td>2 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>38</td>
 <td>30</td>
 <td>8 </td>
 <td>74</td>
 <td>60</td>
 <td>14 </td>
 <td>31</td>
 <td>30</td>
 <td>1 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>35</td>
 <td>30</td>
 <td>5 </td>
 <td>0</td>
 <td>0</td>
 <td>0 </td>
 <td>35</td>
 <td>35</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>#¡REF!</td>
 <td>#¡REF!</td>
 <td>74</td>
 <td>199</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>IYARZABAL</td>
 <td>NEWONE</td>
 <td class="mdsp">20</td>
 <td class="mdrq">36</td>
 <td>-16 </td>
 <td>22</td>
 <td>25</td>
 <td>-3 </td>
 <td>23</td>
 <td>35</td>
 <td>-12 </td>
 <td>21</td>
 <td>25</td>
 <td>-4 </td>
 <td>26</td>
 <td>35</td>
 <td>-9 </td>
 <td>21</td>
 <td>25</td>
 <td>-4 </td>
 <td>32</td>
 <td>35</td>
 <td>-3 </td>
 <td>22</td>
 <td>25</td>
 <td>-3 </td>
 <td>30</td>
 <td>35</td>
 <td>-5 </td>
 <td>19</td>
 <td>25</td>
 <td>-6 </td>
 <td>18</td>
 <td>15</td>
 <td>3 </td>
 <td>8</td>
 <td>10</td>
 <td>-2 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>265</td>
 <td>38</td>
 <td>148</td>
 <td>117</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>TOTAL</td>
 <td class="smdsp">265</td>
 <td>MORNING TOTAL</td>
 <td>-97</td>
 <td>258</td>
 <td>NIGHTTOTAL</td>
 <td>0 </td>
 <td>331</td>
 <td>MORNING TOTAL</td>
 <td>-62</td>
 <td>283</td>
 <td>NIGHTTOTAL</td>
 <td>2</td>
 <td>362</td>
 <td>MORNING TOTAL</td>
 <td>-44 </td>
 <td>291</td>
 <td>NIGHTTOTAL</td>
 <td>0 </td>
 <td>373</td>
 <td>MORNING TOTAL</td>
 <td>-15</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>-12</td>
 <td>378</td>
 <td>MORNING TOTAL</td>
 <td>-35 </td>
 <td>274</td>
 <td>NIGHTTOTAL</td>
 <td>-61</td>
 <td>237</td>
 <td>MORNING TOTAL</td>
 <td>-8 </td>
 <td>230</td>
 <td>NIGHTTOTAL</td>
 <td>8</td>
 <td>56</td>
 <td>MORNING TOTAL</td>
 <td>0</td>
 <td>94</td>
 <td>NIGHTTOTAL</td>
 <td>3</td>
 <td>#¡REF!</td>
 <td>#¡REF!</td>
 <td> 2,002.00 </td>
 <td> 1,710.00 </td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 </tr>
 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>OFFICE</td>
 <td>73</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>74</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>74</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>73</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>72</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>24</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>20</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>366</td>
 <td>52</td>
 <td>#¡REF!</td>
 <td>0</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>CRTM TOTAL</td>
 <td>596</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>688</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>727</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>446</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>724</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>491</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>170</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>366</td>
 <td>52</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>2</td>
 <td>SSD TOC</td>
 <td>19</td>
 <td>23</td>
 <td>-4 </td>
 <td>20</td>
 <td>20</td>
 <td>0 </td>
 <td>23</td>
 <td>23</td>
 <td>0 </td>
 <td>25</td>
 <td>20</td>
 <td>5 </td>
 <td>24</td>
 <td>23</td>
 <td>1 </td>
 <td>30</td>
 <td>25</td>
 <td>5 </td>
 <td>23</td>
 <td>23</td>
 <td>0 </td>
 <td>28</td>
 <td>30</td>
 <td>-2 </td>
 <td>24</td>
 <td>23</td>
 <td>1 </td>
 <td>26</td>
 <td>25</td>
 <td>1 </td>
 <td>15</td>
 <td>15</td>
 <td>0 </td>
 <td>24</td>
 <td>23</td>
 <td>-1 </td>
 <td>15</td>
 <td>15</td>
 <td>0 </td>
 <td>20</td>
 <td>20</td>
 <td>0 </td>
 <td>311</td>
 <td>44</td>
 <td>143</td>
 <td>168</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>SSD STEAM   (GUADALUPE)</td>
 <td>10</td>
 <td>10</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>12</td>
 <td>12</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>12</td>
 <td>12</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>12</td>
 <td>12</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>11</td>
 <td>12</td>
 <td>-1 </td>
 <td>25</td>
 <td>25</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>20</td>
 <td>20</td>
 <td>0 </td>
 <td>21</td>
 <td>20</td>
 <td>1 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>SSD STEAM MANTENIMIENTO</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>SSD STEAM  B</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>20</td>
 <td>20</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>26</td>
 <td>20</td>
 <td>6 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>26</td>
 <td>25</td>
 <td>1 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>25</td>
 <td>25</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>9</td>
 <td>15</td>
 <td>-6 </td>
 <td>26</td>
 <td>25</td>
 <td>-1 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>SSD STEAM  C</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>16</td>
 <td>15</td>
 <td>1 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>15</td>
 <td>15</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>15</td>
 <td>15</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>15</td>
 <td>15</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>14</td>
 <td>15</td>
 <td>-1 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>25</td>
 <td>25</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>21</td>
 <td>20</td>
 <td>1 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>CK KIM</td>
 <td>0</td>
 <td>5</td>
 <td>-5 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>5</td>
 <td>5</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>5</td>
 <td>5</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>4</td>
 <td>SSD PINTURA A  (GUADALUPE)</td>
 <td>14</td>
 <td>15</td>
 <td>-1 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>15</td>
 <td>15</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>15</td>
 <td>15</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>15</td>
 <td>15</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>15</td>
 <td>15</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>14</td>
 <td>15</td>
 <td>-1 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>88</td>
 <td>13</td>
 <td>88</td>
 <td>0</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>5</td>
 <td>SSD PINTURA B  (GUADALUPE)</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>10</td>
 <td>10</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>10</td>
 <td>10</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>10</td>
 <td>10</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>9</td>
 <td>10</td>
 <td>-1 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>9</td>
 <td>10</td>
 <td>-1 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>10</td>
 <td>10</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>58</td>
 <td>8</td>
 <td>0</td>
 <td>58</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>6</td>
 <td>SSD PINTURA C   (GUADALUPE)</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>9</td>
 <td>10</td>
 <td>-1 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>8</td>
 <td>10</td>
 <td>-2 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>10</td>
 <td>10</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>10</td>
 <td>10</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>8</td>
 <td>10</td>
 <td>-2 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>10</td>
 <td>10</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>57</td>
 <td>8</td>
 <td>0</td>
 <td>57</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>7</td>
 <td>SSD PINTURA (07-07) (GUADALUPE)</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>0</td>
 <td>0</td>
 <td>0</td>
 <td>0</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>8</td>
 <td>SSD TOC  C</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>28</td>
 <td>30</td>
 <td>-2 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>27</td>
 <td>30</td>
 <td>-3 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>27</td>
 <td>30</td>
 <td>-3 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>25</td>
 <td>30</td>
 <td>-5 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>26</td>
 <td>30</td>
 <td>-4 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>24</td>
 <td>24</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>16</td>
 <td>15</td>
 <td>1 </td>
 <td>176</td>
 <td>25</td>
 <td>0</td>
 <td>176</td>
 </tr>

 <tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>9</td>
 <td>SSD MATERIALES  B</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>6</td>
 <td>5</td>
 <td>1 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>6</td>
 <td>5</td>
 <td>1 </td>
 <td>4</td>
 <td>5</td>
 <td>-1 </td>
 <td>6</td>
 <td>5</td>
 <td>1 </td>
 <td>5</td>
 <td>5</td>
 <td>0 </td>
 <td>5</td>
 <td>5</td>
 <td>0 </td>
 <td>4</td>
 <td>5</td>
 <td>-1 </td>
 <td>5</td>
 <td>5</td>
 <td>0 </td>
 <td>2</td>
 <td>8</td>
 <td>-6 </td>
 <td>8</td>
 <td>8</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>0 </td>
 <td>50</td>
 <td>7</td>
 <td>15</td>
 <td>35</td>
 </tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>10</td><td>SSD Tooling</td><td>1</td><td>1</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>1</td><td>1</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>1</td><td>1</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>1</td><td>1</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>1</td><td>1</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>5</td><td>1</td><td>5</td><td>0</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>INYECCION TOC</td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>11</td><td>SSD INYECCION STEAM </td><td>2</td><td>2</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>3</td><td>4</td><td>-1 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>3</td><td>4</td><td>-1 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>3</td><td>3</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>3</td><td>3</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>2</td><td>2</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>1</td><td>1</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>17</td><td>2</td><td>17</td><td>0</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>12</td><td>SSD MATERIALES  C</td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>2</td><td>2</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>2</td><td>2</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>0</td><td>0</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>2</td><td>2</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>1</td><td>2</td><td>1 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>7</td><td>1</td><td>0</td><td>7</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>SSD ELENT</td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>0</td><td>0</td><td>0</td><td>0</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>TOTAL SSD</td><td>46</td><td>56</td><td>-10</td><td>109</td><td>110</td><td>-1</td><td>59</td><td>60</td><td>-1</td><td>119</td><td>112</td><td>7</td><td>59</td><td>60</td><td>-1</td><td>126</td><td>122</td><td>4</td><td>59</td><td>59</td><td>0</td><td>117</td><td>125</td><td>-8</td><td>58</td><td>59</td><td>-1</td><td>115</td><td>122</td><td>-7</td><td>42</td><td>55</td><td>-13</td><td>128</td><td>127</td><td>-1</td><td>41</td><td>41</td><td>0</td><td>78</td><td>75</td><td>3</td><td>769</td><td>110</td><td>268</td><td>501</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>13</td><td>DESGLOSE DE HISENSE</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>14</td><td>HISENSE 01  (JOCELYN)</td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>0</td><td>0</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>0</td><td>0</td><td>0</td><td>0</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>15</td><td>HISENSE 02  (JOCELYN)</td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>0</td><td>0</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>0</td><td>0</td><td>0</td><td>0</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>HISENSE A  (JOCELYN)</td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>0</td><td>0</td><td>0</td><td>0</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>TOTAL HISENSE</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>16</td><td>DESGLOSE DE INZI</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>17</td><td>INZI 01</td><td>18</td><td>40</td><td>-22 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>32</td><td>40</td><td>-8 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>38</td><td>40</td><td>-2 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>35</td><td>40</td><td>-5 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>37</td><td>40</td><td>-3 </td><td>5</td><td>40</td><td>-35 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>165</td><td>24</td><td>160</td><td>5</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>INZI MIXTO</td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>0</td><td>0</td><td>0</td><td>0</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>INZI  LIMPIEZA</td><td>1</td><td>1</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>1</td><td>1</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>1</td><td>1</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>1</td><td>1</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>1</td><td>1</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>&nbsp;</td><td>&nbsp;</td><td>0 </td><td>5</td><td>1</td><td>5</td><td>0</td></tr>

 <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>TOTAL INZI</td><td>19</td><td>41</td><td>-22</td><td>0</td><td>0</td><td>0</td><td>33</td><td>41</td><td>-8</td><td>0</td><td>0</td><td>0</td><td>39</td><td>41</td><td>-2</td><td>0</td><td>0</td><td>0</td><td>36</td><td>41</td><td>-5</td><td>0</td><td>0</td><td>0</td><td>38</td><td>41</td><td>-3</td><td>5</td><td>40</td><td>-35</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>0</td><td>170</td><td>24</td><td>165</td><td>5</td></tr>
</tbody></table>

	</div>

				
				<!--<div class="tabbable-line tabs-below">
<ul class="nav nav-tabs">
						@for ($i = date('W'); $i >= 1; $i--)
							@if($i == date('W'))
	   							<li class="active">
								<a href="#tab_below_{{ $i }}" data-toggle="tab">
								Week {{ $i }} </a></li>
							@else
								<li>
								<a href="#tab_below_{{ $i }}" data-toggle="tab">
								Week {{ $i }} </a></li>
							@endif

						
						@endfor
						
					</ul>
	</div> -->
	
  <div class="scroller scroller-left"><i class="glyphicon glyphicon-chevron-left"></i></div>
  <div class="scroller scroller-right"><i class="glyphicon glyphicon-chevron-right"></i></div>
  <div class="wrapper tabbable-line tabs-below">
    <ul class="nav nav-tabs list" id="myTab">
      @for ($i = date('W'); $i >= 1; $i--)
							@if($i == date('W'))
	   							<li class="active">
								<a href="#tab_below_{{ $i }}" data-toggle="tab">
								<strong>Week {{ $i }} </strong></a></li>
							@else
								@if($i > 1)
									<li>
									<a href="#tab_below_{{ $i }}" data-toggle="tab">
									<strong>Week {{ $i }}</strong> </a></li>
								@else
									<li id="last-item">
									<a href="#tab_below_{{ $i }}" data-toggle="tab">
									<strong>Week {{ $i }}</strong> </a></li>
								@endif
							@endif

						
						@endfor
  </ul>
  </div>
	</div>
	</div>

	</div>

	
	
 
 

  
@endsection
@section('js')
<!-- se cargan los dos archivos de javascript con el código necesario
para poder editar la tabla y hacer los promedios -->
<script src="{{ asset("static/js/tabla-excel-rh.js") }}" type="text/javascript"></script>
<script src="{{ asset("static/js/tabla-excel-numeros-rh.js") }}" type="text/javascript"></script>
<script src="{{ asset("static/js/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
<script src="{{ asset("static/js/jquery.base64.js") }}" type="text/javascript"></script>


<script type="text/javascript">



	$(document).ready(function() {

		$('#table').tablaEditable().calculos().find('td:first').focus();;
		var hidWidth;
var scrollBarWidths = $(".list li").size()*2;
var widthOfList = function(){
  var itemsWidth = 0;
  $('.list li').each(function(){
    var itemWidth = $(this).outerWidth();
    itemsWidth+=itemWidth;
  });
  return itemsWidth;
};

var widthOfHidden = function(){

  return (($('.wrapper').outerWidth())-widthOfList()-getLeftPosi())-scrollBarWidths;
};

var getLeftPosi = function(){
  return $('.list').position().left;
};



var reAdjust = function(){
	$('.scroller-right').show();
	$('.scroller-left').show();
  if (($('.wrapper').outerWidth()) < widthOfList()) {
    $('.scroller-right').show();
  }
  /*else {
    $('.scroller-right').hide();
  }*/
  
  if (getLeftPosi()<0) {
    $('.scroller-left').show();
  }
  else {
    $('.item').animate({left:"-="+getLeftPosi()+"px"},'slow');
  	//$('.scroller-left').hide();
  }
}

reAdjust();

$(window).on('resize',function(e){  
  	reAdjust();
});

$('.scroller-right').click(function() {
	console.log(widthOfList());
  if (widthOfHidden() < 0) {
  	if(widthOfHidden() >= ($("#last-item").outerWidth(true)*(-1)))
  	{	
  		$('.list').animate({left:"+="+(widthOfHidden())+"px"},'fast',function(){

  		});
  	}else{
  		$('.list').animate({left:"-="+80+"px"},'fast',function(){

  		});
  	}
  	
    $('.scroller-left').fadeIn('fast');
   // $('.scroller-right').fadeOut('fast');
  }else{
  	//alert($("#last-item").outerWidth(true));
  	$('.scroller-left').fadeIn('fast');
  	
  }
  
  
  
  
});

$('.scroller-left').click(function() {
	
  if (getLeftPosi() < 0) {
	
	$('.list').animate({left:"+="+80+"px"},'fast',function(){
		if (getLeftPosi() > 0) {
  		$('.list').animate({left:0+"px"},'fast',function(){
  	});
  	}
  	});

  }
});    
		$("#btnExport").click(function () {
            $("#tblExport").btechco_excelexport({
                containerid: "tblExport"
               , datatype: $datatype.Table
               , filename: 'KPI '+$("#area_tabla").html()+" "+$("#no_semana").html()
            });
        });

	//Variables utilizadas de manera global para almacenar
	//los datos del area, semana y año del KPI buscado	
	var area = "";
	var semana = "";
	var year = "";
	//Función para realizar la busqueda del formato de KPI
	$('#buscar').click(function() {
        			//Se obtienen los valores de los campos y se almacenan en la variables
        			area = $("#area").val();
        			semana = $("#semana").val();
        			year = $("#year").val();
        			var dataString = { 
		              area : area,
		              semana : semana,
		              year : year             
		            };
		        $.ajax({
		            type: "GET",
		            url: "{{ URL::to('kpi/obtener_tabla_ajax') }}",
		            data: dataString,
		            dataType: "json",
		            cache : false,
		            success: function(data){
		            	//Se verifica que el valor de data no sea null
		              	if (data != null){
		              		//si data no es null entonces se carga el formato de la 
		              		//tabla el div con la clase tabla
			              	$(".tabla").html(data);
			              	//se agrega la semana al titulo del panel
			              	$("#no_semana").html(semana);
			              	//se obtiene el combobox del area
			              	var combo = document.getElementById("area");
							// se obtiene el nombre del área seleccionada y se agrega al titulo del panel
			              	$("#area_tabla").html(combo.options[area].text);
			              	/* se agrega la clase collapse al panel de busqueda para que se oculte */
							$( "#buscar_kpi" ).addClass( "collapse" );
							/* se muestra el boton del panel de busqueda
							que se encontraba oculto, para poder visualizar de nuevo el panel de 
							busqueda*/
							$("#mostrar").show();
							/* se llaman las funciones de tablaEditable y soloNumeros
							para poder editar la tabla y permitir evaluar que se ingresen solo números */
							$('#table').tablaEditable().soloNumeros().find('td:first').focus();;
							/* se mustra el div con la clase resultados */
							$('.resultados').collapse('show');
							/* se obtiene la posicion del div con id resultados */
							var posicion = $("#resultados").offset().top;
							//hacemos scroll hasta los resultados
							$("html, body").animate({scrollTop:posicion+"px"});
						}else{
							/*si data es null, entonces se muestra el mensaje que informa que no se
							encontro ningun resultado y luego se oculta*/
							$("#error").show(600);
		                
                      		$("#error").delay(2000).hide(600);
						}
					} ,error: function(xhr, status, error) {
		              
		            },
		        });
    });	
	/* la siguiente funcion permite detectar cuando el panel de busqueda
	se muestra para ocultar el div de resultados */
	$('#buscar_kpi').on('show.bs.collapse', function () {
  				$('.resultados').collapse('hide');
			});
	/* la siguiente funcion permite detectar cuando el div de resultados 
	se mustra para ocultar el panel de busqueda */
			$('.resultados').on('show.bs.collapse', function () {
  				
  				$('#buscar_kpi').collapse('hide');

			});
	//funcion para guardar los cambios en la tabla
	$('#save').click(function() {
		//obtenemos el código html de la tabla
		var tabla = $(".tabla").html();
		//arreglo con los datos que seran enviados al controlador
		var dataString = { 
		              tabla : tabla,
		              area : area,
		              semana : semana,
		              year : year,
		              _token : '{{ csrf_token() }}'            
		            };
		        //funcion ajax para almacenar los cambios  
		        $.ajax({
		            type: "POST",
		            url: "{{ URL::to('kpi/alta/registro') }}",
		            data: dataString,
		            dataType: "json",
		            cache : false,
		            success: function(data){
		              //se evalua que los datos se guardaron de forma correcta
		              if (data) {
		              	/* se muestra el mensaje que confirma que se guardo de 
		              	forma satisfactoria y se oculta posteriormente después del
		              	tiempo especificado */
		              	$("#success").show(600);
		                
                      	$("#success").delay(2000).hide(600);
		              }
		              	
					} ,error: function(xhr, status, error) {
		              
		            },
		        });

	});

	});
	



</script>


@stop