@extends('adminlte::page')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Fechamento do mês</h1>
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <span style="font-weight: 800">{{ \Carbon\Carbon::parse($mesAtual)->isoFormat('MMMM') }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span style="font-weight: 800">Total agendamentos Fixos: </span> {{ $totalMesAtualFixo }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span style="font-weight: 800">Total agendamentos Avulsos: </span> {{ $totalMesAtualAvulso }}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span style="font-weight: 800">Total: </span> R$ {{ ($totalMesAtualFixo * $valorFixo) + ($totalMesAtualAvulso * $valorAvulso) }}
            </div>
        </div>
    </div>
</div>

@endsection