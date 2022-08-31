@extends('adminlte::page')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Salas</h1>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-body">

        @include('componentes.alerts')

        <div class="clearfix">&nbsp;</div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-stripped table-hover table-sm" id="tabela-salas" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sala</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($rooms))
                            @foreach ($rooms as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="editarSala({{ $item->id }})" class="btn btn-warning btn-sm btn-circle"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="javascript:void(0)" onclick="removerSala({{ $item->id }})" class="btn btn-danger btn-sm btn-circle"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="clearfix">&nbsp;</div>
        <div class="float-right">
            <button class="btn btn-primary btn-secondary" id="btn-adicionar-sala" type="button">Incluir Sala</button>
        </div>
    </div>
</div>
@endsection