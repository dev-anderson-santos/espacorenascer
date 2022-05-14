@extends('adminlte::page')

@section('content')
<style>
    .seta::before {
        display: none!important;
    }
</style>
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
                        <div class="btn-group dropleft">
                            <a class="dropdown-toggle seta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a href="{{ route('user.edit', ['user_id' => $user->id]) }}" class="dropdown-item btn btn-sm" title="Editar"><i class="fas fa-pencil-alt text-warning"></i> Editar</a>
                                <a href="{{ route('schedule.user-schedules', ['user_id' => $user->id]) }}" class="dropdown-item btn btn-sm" title="Ver horários agendados"><i class="fas fa-calendar-alt text-info"></i> Ver horários agendados</a>
                            </div>
                        </div>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection