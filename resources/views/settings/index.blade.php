@extends('adminlte::page')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Configurações</h1>
            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-body">

        @include('componentes.alerts')

        <form action="{{ route('settings.update') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $setting->id ?? '' }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Valor do agendamento fixo:</label>
                        <input type="text" name="valor_fixo" class="form-control" value="{{ $setting->valor_fixo ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Valor do agendamento avulso:</label>
                        <input type="text" name="valor_avulso" class="form-control" value="{{ $setting->valor_avulso ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Horario limite para cancelar agendamento:</label>
                        <input type="time" name="hora_fechamento" class="form-control" value="{{ $setting->hora_fechamento ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Dia do vencimento:</label>
                        <input type="number" name="dia_fechamento" class="form-control" min="0" max="31" value="{{ $setting->dia_fechamento ?? '1' }}">
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Data do vencimento:</label>
                        <input type="date" name="data_vencimento" class="form-control" value="{{ $setting->data_vencimento ?? '' }}">
                    </div>
                </div> --}}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary float-right">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection