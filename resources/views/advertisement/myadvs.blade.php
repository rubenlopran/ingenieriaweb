@extends('layouts.app')

@section('template_title')
    Advertisement
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-left">
                                <a href="{{ route('advertisement.create') }}" class="btn btn-primary btn-sm float-left"  data-placement="left">
                                    {{ __('Nuevo Anuncio') }}
                                </a>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="card-body">
                                    <div class="alert alert-success">
                                        <p>{{ $message }}</p>
                                    </div>
                            </div>
                        @endif
                    </div>
                    <br>
                    @foreach ($advertisements as $advertisement)
                    @if(\Auth::user()->id == $advertisement->user->id)
                        <div class="card">
                            <div class="card-header">
                                {{ ++$i }}
                                <td>{{ $advertisement->address }}</td>
                                <td class="float-right">   -    {{ $advertisement->user->name ?? 'Empty'}}</td>
                            </div>
                            <div class="card-body">
                                <img src="{{ $advertisement->images }}" alt="" style="width: 100%;">
                                <ul>
                                    <li>{{ $advertisement->capacity }}</li>
                                    <li>{{ $advertisement->date }}</li>
                                    <li>{{ $advertisement->features }}</li>
                                    <li>{{ $advertisement->other }}</li>
                                    <li>{{ $advertisement->price }}</li>
                                </ul>
                            </div>
                            <div class="card-footer">
                                <form action="{{ route('advertisement.destroy',$advertisement->id) }}" method="POST">
                                    <a class="btn btn-sm btn-success" href="{{ route('advertisement.edit',$advertisement->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                    <a class="btn btn-sm btn-primary " href="{{ route('advertisement.show',$advertisement->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <br>
                    @endforeach
                </div>
                {!! $advertisements->links() !!}
            </div>
        </div>
    </div>
@endsection
