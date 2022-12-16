@extends('layouts.app')

@section('template_title')
    Parada
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Parada') }}
                            </span>
                                <form method="GET" action="{{ route('paradas.index') }}"  role="form" enctype="multipart/form-data">
                       
                                    <div class="float-right"><div class="form-group">
                                    {{ Form::label('codLinea') }}
                                    {{ Form::select('codLinea', $lineas, ['class' => 'form-control' . ($errors->has('codLinea') ? ' is-invalid' : ''), 'placeholder' => 'null']) }}
                                    {!! $errors->first('codLinea', '<div class="invalid-feedback">:message</div>') !!}
                                    {{ Form::label('sentido') }}
                                    {{ Form::select('sentido', $lineas, ['class' => 'form-control' . ($errors->has('sentido') ? ' is-invalid' : ''), 'placeholder' => 'null']) }}
                                    {!! $errors->first('sentido', '<div class="invalid-feedback">:message</div>') !!}
                                    <div class="box-footer mt20">
                                         <button type="submit" class="btn btn-outline-success">Buscar</button>
                                    </div>
                                    </div>
                            </form>

                                <div class="container-fluid">
                                    <form class="d-flex" role="search">
                                        <input name="filtroparada" class="form-control me-2" type="search" placeholder="Buscar por nombre"  aria-label="Search" id="filtroparada">
                                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                                    </form>
                                </div>
                                <div class="container-fluid">
                                    <form class="d-flex" role="search">
                                        <input name="filtrodireccion" class="form-control me-2" type="search" placeholder="Caercanas a"  aria-label="Search" id="filtrodireccion">
                                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                                    </form>
                                </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th> Id</th>
										<th>Codigo linea</th>
										<th>Nombre linea</th>
										<th>Sentido</th>
										<th>Orden</th>
										<th>Codigo parada</th>
										<th>Nombre parada</th>
										<th>Direccion</th>
										<th>Lon</th>
										<th>Lat</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paradas as $parada)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $parada->_id }}</td>
											<td>{{ $parada->codLinea }}</td>
											<td>{{ $parada->nombreLinea }}</td>
											<td>{{ $parada->sentido }}</td>
											<td>{{ $parada->orden }}</td>
											<td>{{ $parada->codParada }}</td>
											<td>{{ $parada->nombreParada }}</td>
											<td>{{ $parada->direccion }}</td>
											<td>{{ $parada->lon }}</td>
											<td>{{ $parada->lat }}</td>

                                            <td>
                                                <a class="btn btn-sm btn-primary " href="{{ route('paradas.show',$parada->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $paradas->links() !!}
            </div>
        </div>
    </div>
@endsection
