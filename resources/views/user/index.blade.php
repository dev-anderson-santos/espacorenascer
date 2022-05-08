@extends('adminlte::page')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Clientes</h1>
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? ''}}</td>
                    <td>
                        <a href="{{ route('user.edit', ['user_id' => $user->id]) }}" class="btn btn-warning btn-sm rounded-circle" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                        <a href="{{ route('user.edit', ['user_id' => $user->id]) }}" class="btn btn-info btn-sm rounded-circle" title="Ver horários agendados"><i class="fas fa-calendar-alt"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection