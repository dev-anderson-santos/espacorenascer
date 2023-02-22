@extends('adminlte::page')

@section('content')

<h2 class="text-left">Notas das atualizações:</h2>
<div class="clearfix">
    <fieldset></fieldset>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="box box-solid">
            <div class="box-body no-margin no-padding">
                <div class="box-group" id="accordion">
                    <div class="box box-default no-margin-bottom">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#r1-1-0" aria-expanded="false" class="collapsed text-bold">
                                    Release 1.1.00 - 21/02/2023
                                </a>
                            </h4>
                            <div class="box-tools pull-right">
                                <span data-toggle="tooltip" title="" class="badge bg-blue" data-original-title="Atualizações aplicadas"></span>
                            </div>
                        </div>
                        <div id="r1-1-0" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="box-body no-border">
                                <ul>
                                    <li>Permitir agendamento em qualquer horário</li>
                                    <li>Histórico de atualizações</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="box box-default no-margin-bottom">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#r1-0-0" aria-expanded="false" class="collapsed text-bold">
                                    Release 1.0.00 - 22/04/2022
                                </a>
                            </h4>
                            <div class="box-tools pull-right">
                                <span data-toggle="tooltip" title="" class="badge bg-blue" data-original-title="Atualizações aplicadas"></span>
                            </div>
                        </div>
                        <div id="r1-0-0" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="box-body no-border">
                                <ul>
                                    <li>Notas de Release</li>
                                    <li>Dashboard</li>
                                    <li>Registro de pagamento (Menu Financeiro)</li>
                                    <li>CRUD de salas</li>
                                    <li>Atualizando agendamentos fixos para avulsos e vice-versa</li>
                                    <li>Agendamento recorrente (Fixo)</li>
                                    <li>Menu Agenda Administrador, e Agenda Consulta</li>
                                    <li>Menu Configurações</li>
                                    <li>Cancelamento de agendamentos</li>
                                    <li>Faturar agendamentos (Cron Faturar)</li>
                                    <li>Finalizar agendamentos (Cron Finalizar)</li>
                                    <li>Espelhamento de agendamentos (Cron Mirror)</li>
                                    <li>Menu Fechamentos do mês</li>
                                    <li>Menu Meus Horários</li>
                                    <li>CRUD de agendamentos (Menu Agenda)</li>
                                    <li>Login de usuários</li>
                                    <li>Menu Clientes</li>
                                    <li>CRUD de usuários</li>
                                    <li>Backbone da aplicação</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection