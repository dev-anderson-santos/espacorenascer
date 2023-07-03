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
                                <a data-toggle="collapse" data-parent="#accordion" href="#r1-3-5" aria-expanded="false" class="collapsed text-bold">
                                    Release 1.3.5 - 03/07/2023
                                </a>
                            </h4>
                            <div class="box-tools pull-right">
                                <span data-toggle="tooltip" title="" class="badge bg-blue" data-original-title="Atualizações aplicadas"></span>
                            </div>
                        </div>
                        <div id="r1-3-5" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="box-body no-border">
                                <ul>
                                    <li>Ajuste no cálculo do fechamento mês anterior.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="box box-default no-margin-bottom">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#r1-3-4" aria-expanded="false" class="collapsed text-bold">
                                    Release 1.3.4 - 03/07/2023
                                </a>
                            </h4>
                            <div class="box-tools pull-right">
                                <span data-toggle="tooltip" title="" class="badge bg-blue" data-original-title="Atualizações aplicadas"></span>
                            </div>
                        </div>
                        <div id="r1-3-4" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="box-body no-border">
                                <ul>
                                    <li>Ajuste no cálculo do recebido no mês anterior.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="box box-default no-margin-bottom">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#r1-3-3" aria-expanded="false" class="collapsed text-bold">
                                    Release 1.3.3 - 08/05/2023
                                </a>
                            </h4>
                            <div class="box-tools pull-right">
                                <span data-toggle="tooltip" title="" class="badge bg-blue" data-original-title="Atualizações aplicadas"></span>
                            </div>
                        </div>
                        <div id="r1-3-3" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="box-body no-border">
                                <ul>
                                    <li>Remoção de agendamento duplicados.</li>
                                    <li>Remoção de agendamento duplicados que estão para ser espelhados.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="box box-default no-margin-bottom">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#r1-3-1-0-0-1" aria-expanded="false" class="collapsed text-bold">
                                    Release 1.3.1-0.0.1 - 05/05/2023
                                </a>
                            </h4>
                            <div class="box-tools pull-right">
                                <span data-toggle="tooltip" title="" class="badge bg-blue" data-original-title="Atualizações aplicadas"></span>
                            </div>
                        </div>
                        <div id="r1-3-1-0-0-1" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="box-body no-border">
                                <ul>
                                    <li>Exibir todos os horários e valores dos agendamentos finalizados <br>do mês atual na tela Fechamentos do mês.</li>
                                    <li>Exibir no campo Valores a receber no mês atual todos os agendamentos na tela do Dashboard.</li>
                                    <li>Ordenação dos agendamentos por data e hora na tela Meus Horários.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="box box-default no-margin-bottom">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#r1-3-1" aria-expanded="false" class="collapsed text-bold">
                                    Release 1.3.1 - 04/05/2023
                                </a>
                            </h4>
                            <div class="box-tools pull-right">
                                <span data-toggle="tooltip" title="" class="badge bg-blue" data-original-title="Atualizações aplicadas"></span>
                            </div>
                        </div>
                        <div id="r1-3-1" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="box-body no-border">
                                <ul>
                                    <li>Exibir somente a quantidade de horários e valores dos agendamentos finalizados <br>do mês atual na tela Fechamentos do mês.</li>
                                    <li>Correção na contagem de agendamentos do mês anterior na tela Fechamentos do mês.</li>
                                    <li>Adição de um contador no modal de Ver Detalhes na tela Fechamentos do mês.</li>
                                    <li>Exibir em valores a receber no mês atual somente os agendamentos finalizados na tela do Dashboard.</li>
                                    <li>Adição do rodapé na parte interna do sistema.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="box box-default no-margin-bottom">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#r1-3-0" aria-expanded="false" class="collapsed text-bold">
                                    Release 1.3.0 - 22/04/2023
                                </a>
                            </h4>
                            <div class="box-tools pull-right">
                                <span data-toggle="tooltip" title="" class="badge bg-blue" data-original-title="Atualizações aplicadas"></span>
                            </div>
                        </div>
                        <div id="r1-3-0" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="box-body no-border">
                                <ul>
                                    <li>Redefinição de senha por e-mail.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="box box-default no-margin-bottom">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#r1-2-2" aria-expanded="false" class="collapsed text-bold">
                                    Release 1.2.2 - 12/03/2023
                                </a>
                            </h4>
                            <div class="box-tools pull-right">
                                <span data-toggle="tooltip" title="" class="badge bg-blue" data-original-title="Atualizações aplicadas"></span>
                            </div>
                        </div>
                        <div id="r1-2-2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="box-body no-border">
                                <ul>
                                    <li>Atribuir perfil de administrador a outros usuários.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="box box-default no-margin-bottom">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#r1-1-2" aria-expanded="false" class="collapsed text-bold">
                                    Release 1.1.2 - 06/03/2023
                                </a>
                            </h4>
                            <div class="box-tools pull-right">
                                <span data-toggle="tooltip" title="" class="badge bg-blue" data-original-title="Atualizações aplicadas"></span>
                            </div>
                        </div>
                        <div id="r1-1-2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="box-body no-border">
                                <ul>
                                    <li>Reparo ao excluir uma sala</li>
                                </ul>
                            </div>
                        </div>
                    </div>
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