@extends('adminlte::page')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Configurações - Área Institucional</h1>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-body">

        @include('componentes.alerts')

        <fieldset>
            <legend>Imagens das salas</legend>
        </fieldset>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-hover table-sm" id="tabela-imagens-sala" style="width:100%">
                    <thead>
                        <tr>
                            <th style="display: none;">#</th>
                            <th>Imagem</th>
                            <th>Descrição</th>
                            <th>Ordem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($imagemSalas))
                            @foreach ($imagemSalas as $item)
                                <tr>
                                    <td style="display: none;">{{ $item->order_image }}</td>
                                    <td><img src="{{ $item->filepath }}" alt="{{ $item->filename }}" width="80" height="80"></td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->order_image }}</td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="modalGlobalOpen('{{ route('.institutional.modal-adicionar-imagem-institucional', ['id' => $item->id, 'type' => 'edit']) }}', 'Editar imagem da sala.')" class="btn btn-warning btn-sm btn-circle"><i class="fas fa-pencil"></i></a>
                                        <a href="javascript:void(0)" onclick="deleteInstitutionalImage({{ $item->id }})" class="btn btn-danger btn-sm btn-circle"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="clearfix">&zwnj;</div>
        <div class="clearfix">&zwnj;</div>
        <div class="text-right">
            <button class="btn btn-primary" id="btn-adicionar-imagem-sala" type="button">Incluir</button>
        </div>
    </div>
</div>
@endsection