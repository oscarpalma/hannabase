@extends('layouts.dashboard')
@section('page_heading','Perfil')
@section('section')

<div class="panel panel-primary">
	<div class="panel-heading"><strong>Informacion de usuario</strong></div>
	<div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('usuario') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="row">
			<div class="col-sm-4">
				<label class="control-label">Nombre</label>
				<input type="text" class="form-control" name="name" value="{{Auth::user()->nombre}}">
			</div>

			<div class="col-sm-4">
				<label class="control-label">E-Mail</label>
				<input type="email" class="form-control" name="email" value="{{Auth::user()->email}}">
			</div>

			<div class="col-sm-4">
				<label class="control-label">Tipo de usuario</label>
				<input type="text" class="form-control" name="role" readonly="" value="{{Auth::user()->role}}">
			</div>
		</div>
                <br>
                <div class="row">
                        <center><button class="btn btn-primary" type="submit">
                                Guardar
                        </button></center>
                </div>
	</div>
</div>
@stop