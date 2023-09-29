@extends('reports.pdf.template.template')
@section('conteudo')

{{-- <span style="font-weight: bold;">
    Relatório de Cobrança Mensal - {{ getMonths($mes) }} de {{ $ano }}
</span> --}}
<div class="clearfix">&nbsp;</div>
<div class="" id="tab_1" role="tabpanel" aria-labelledby="tab_x1">
    <table class="table">
        <thead>
            <tr>
                <th style="text-align: center" scope="col">Profissional</th>
                <th style="text-align: center" scope="col">Agendamentos</th>
                <th style="text-align: center" scope="col">Valor a pagar</th>
                <th style="text-align: center" scope="col">Valor pago</th>
                <th style="text-align: center" scope="col">Status</th>
                <th style="text-align: center" scope="col">Status Atual</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($clientes))
                @forelse ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente['name'] }}</td>
                    <td class="text-center">{{ $cliente['concluidosAgendamentosMesAnterior'] }}</td>
                    <td class="text-center">R$ {{ number_format($cliente['totalMesAnterior'], 2, ',', '.') }}</td>
                    <td class="text-center">
                        R$ {{ $cliente['fatura_cliente'] != 0 ? $cliente['fatura_cliente'] : number_format($cliente['fatura_cliente'], 2, ',', '.') }}
                    </td>
                    <td class="text-center">
                        @php
                            $charge = null;
                            $status = [];
                            $status['badge'] = 'warning';
                            $status['descricao'] = 'Pendente';

                            if ($cliente['fatura_cliente'] != 0 || ($cliente['fatura_cliente'] == 0 && !empty($cliente['fatura_cliente_id']))) {
                                $status['badge'] = 'success';
                                $status['descricao'] = 'Pago';
                            }
                        @endphp
                        <span class="badge badge-pill badge-{{$status['badge']}}">
                            {{ $status['descricao'] }}
                        </span>
                    </td>
                    <td></td>
                </tr>
                @empty
                @endforelse
                <tr>
                    <td class="text-center text-bold">Totais:</td>
                    <td class="text-center text-bold">{{ array_sum(Arr::pluck($clientes, 'concluidosAgendamentosMesAnterior')) }}</td>
                    <td class="text-center text-bold">R$ {{ number_format(array_sum(Arr::pluck($clientes, 'totalMesAnterior')), 2, ',', '.') }}</td>
                    <td class="text-center text-bold">R$ {{ number_format(array_sum(Arr::pluck($clientes, 'fatura_cliente')), 2, ',', '.') }}</td>
                    <td colspan="2"></td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
@section('rodape')
    
@endsection
