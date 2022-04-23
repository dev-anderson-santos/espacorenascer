@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="content-fluid">
        <div class="row">

            <div class="col-lg-12">

                <!--begin::Portlet-->
                <div class="kt-portlet sombra">

                    <!--begin::Form-->
                    <form id="cadastro-profissional" class="kt-form kt-form--label-right form-ajax_cliente" method="post" redirect-refresh="true" get-form="email" redirect="http://agenda.humanopsicologia.com/painel/?email=" action="http://agenda.humanopsicologia.com/painel/ajax/clientes/?action=insert">
                        
                            
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Dados de Acesso
                                </h3>
                            </div>
                        </div>
                        
                        
                        
                        <div class="row">

                            <div class="col-12 mb-3">
                                <div class=" form-background">

                                    <div class="row m-3">
                                    
                                        <div class="col-12 col-md-6 mt-2 mb-2">
                                            <label class="form-labels">Usuário<span style="color: red;">*</span></label>
                                            <input name="username" class="form-control username" type="text" value="" required="">
                                        </div>
                                        <div class="col-12 col-md-3 mt-2 mb-2">
                                            <label class="form-labels">Senha<span style="color: red;">*</span></label>
                                            <input name="senha" class="form-control senha" type="password" value="" required="">
                                        </div>
                                        <div class="col-12 col-md-3 mt-2 mb-2">
                                            <label class="form-labels">Confirmar Senha<span style="color: red;">*</span></label>
                                            <input onblur="" class="form-control senha2" type="password" value="" required="">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Informações Principais
                                </h3>
                            </div>
                        </div>
                        
                        
                        
                        <div class="row">

                            <div class="col-12 mb-3">
                                <div class=" form-background">

                                    <div class="row m-3">
                                    
                                        
                                        <input name="id_zendesk" type="hidden" value="">
                                        
                                        <div class="col-12 col-md-8 mt-2 mb-2">
                                            <label class="form-labels">Nome Completo<span style="color: red;">*</span></label>
                                            <input name="nome_razao_social" class="form-control nome_razao_social" type="text" value="">
                                        </div>
                                        
                                        <div class="col-9 col-md-4 mt-2 mb-2">
                                            <label class="form-labels" for="cpfcnpj">CPF <span style="color: red;">*</span></label>
                                            <input name="cpf_cnpj" id="cpfcnpj" class="form-control cnpj" type="text" value="" required="" maxlength="15">
                                        </div>
                                        
                                        <div class="col-12 col-md-4 mt-2 mb-2">
                                            <label class="form-labels" for="crp_crm">Nº Inscrição CRP/CRM</label>
                                            <input name="crp_crm" id="crp_crm" class="form-control" type="text" value="">
                                        </div>
                                        
                                        <div class="col-12 col-md-3 mt-2 mb-2">
                                            <label class="form-labels" for="data_nascimento">Data de Nascimento</label>
                                            <input name="data_nascimento" id="data_nascimento" class="form-control" maxlength="10" onkeypress="mascaraData(this)" type="text" placeholder="00/00/0000" value="">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>	

                        <br>
                        <div class="kt-portlet__head">
                        
                            <div class="kt-portlet__head-label">
                            
                                <h3 class="kt-portlet__head-title">
                                    Contato
                                </h3>
                            </div>
                        </div>
                        
                        <div class="row">

                            <div class="col-12 mb-3">
                                <div class=" form-background">

                                    <div class="row m-3">
                                        
                                        
                                        
                                        <div class="col-12 col-md-4 mt-2 mb-2">
                                            <label class="form-labels" for="tel_con">Telefone de Contato <span style="color: red;">*</span></label>
                                            <input name="tel_con" class="form-control" id="tel_con" maxlength="15" type="text" value="" required="">
                                        </div>

                                        <div class="col-12 col-md-8 mt-2 mb-2">
                                            <label class="form-labels" for="email">E-mail <span style="color: red;">*</span></label>
                                            <input name="email" id="email" class="form-control" type="email" value="" required="">
                                        </div>
                                        <div class="col-12 col-md-5 mt-2 mb-2">
                                            <label class="form-labels" for="end_res">Endereço Residencial</label>
                                            <input name="end_res" id="end_res" class="form-control" type="text" value="">
                                        </div>

                                        <div class="col-12 col-md-2 mt-2 mb-2">
                                            <label class="form-labels" for="cep">CEP</label>
                                            <input name="cep_res" id="cep" class="form-control cep" maxlength="9" placeholder="00000-000" type="text" value="">
                                        </div>
                                    
                                        <div class="col-12 col-md-3 mt-2 mb-2">
                                            <label class="form-labels" for="complemento_res">Complemento</label>
                                            <input name="complemento_res" id="complemento_res" class="form-control complemento_res" type="text" value="" required="">
                                        </div>

                                        <div class="col-12 col-md-2 mt-2 mb-2">
                                            <label class="form-labels" for="numero_res">Número</label>
                                            <input name="numero_res" id="numero_res" class="form-control numero" type="text" value="" required="">
                                        </div>

                                        <div class="col-12 col-md-3 mt-2 mb-2">
                                            <label class="form-labels" for="bairro_res">Bairro</label>
                                            <input name="bairro_res" class="form-control bairro" type="text" value="">
                                        </div>

                                        <div class="col-12 col-md-3 mt-2 mb-2">
                                            <label class="form-labels" for="bairro">Cidade</label>
                                            <input name="cidade_res" class="form-control" type="text" value="">
                                        </div>

                                        <div class="col-12 col-md-3 mt-2 mb-2">
                                            <label class="form-labels" for="uf">Estado</label>
                                            <select id="uf" name="estado_res" class="form-control estado" required="">
                                                <option>Selecione</option>
                                                <option value="AC">Acre</option>
                                                <option value="AL">Alagoas</option>
                                                <option value="AP">Amapá</option>
                                                <option value="AM">Amazonas</option>
                                                <option value="BA">Bahia</option>
                                                <option value="CE">Ceará</option>
                                                <option value="DF">Distrito Federal</option>
                                                <option value="ES">Espírito Santo</option>
                                                <option value="GO">Goiás</option>
                                                <option value="MA">Maranhão</option>
                                                <option value="MT">Mato Grosso</option>
                                                <option value="MS">Mato Grosso do Sul</option>
                                                <option value="MG">Minas Gerais</option>
                                                <option value="PA">Pará</option>
                                                <option value="PB">Paraíba</option>
                                                <option value="PR">Paraná</option>
                                                <option value="PE">Pernambuco</option>
                                                <option value="PI">Piauí</option>
                                                <option value="RJ">Rio de Janeiro</option>
                                                <option value="RN">Rio Grande do Norte</option>
                                                <option value="RS">Rio Grande do Sul</option>
                                                <option value="RO">Rondônia</option>
                                                <option value="RR">Roraima</option>
                                                <option value="SC">Santa Catarina</option>
                                                <option value="SP">São Paulo</option>
                                                <option value="SE">Sergipe</option>
                                                <option value="TO">Tocantins</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        
                        
                        <br>
                        <div class="kt-portlet__head">
                        
                            <div class="kt-portlet__head-label">
                            
                                <h3 class="kt-portlet__head-title">
                                    Sobre o Profissional
                                </h3>
                            </div>
                        </div>
                        
                        <div class="row">

                            <div class="col-12 mb-3">
                                <div class=" form-background">
                                
                                    <div class="row m-3">
                                        <div class="col-12 col-md-6 mt-2 mb-2">
                                            <label class="form-labels" for="formacoes_academicas">Formações Acadêmicas</label>
                                            <textarea id="formacoes_academicas" style="min-height: 150px;" name="formacoes_academicas" class="form-control"></textarea>
                                        </div>
                                        
                                        <div class="col-12 col-md-6 mt-2 mb-2">
                                            <label class="form-labels" for="experiencia">Experiência em síndromes ou situações especiais</label>
                                            <textarea style="min-height: 150px;" name="experiencia" class="form-control"></textarea>
                                        </div>
                                        
                                        <div class="col-12 col-md-6 mt-2 mb-2">
                                            <label class="form-labels" for="faixa_etaria_atendimento">Faixa etária de atendimento</label>
                                            <textarea style="min-height: 150px;" id="faixa_etaria_atendimento" name="faixa_etaria_atendimento" class="form-control"></textarea>
                                        </div>
                                        
                                        <div class="col-12 col-md-6 mt-2 mb-2">
                                            <label class="form-labels" for="linhas_abordagem">Linhas de Abordagem</label>
                                            <textarea style="min-height: 150px;" id="linhas_abordagem" name="linhas_abordagem" class="form-control"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>		
                        
                        
                        
                                                
                        
                        <div class="row">
                            <div class="col m-3 pt-3 pb-5" style="position: absolute; width: 0; height: 0; overflow: hidden; padding: 0;">
                                <button type="submit" class="btn btn-primary btn-small btn_clientes">Enviar Cadastro</button>
                            </div>
                        </div>	
                        
                    </form>

                    <div class="col m-3 pt-3 pb-5">
                        <button type="button" onclick="verificar_cadastro()" class="btn btn-primary btn-small">Enviar Cadastro</button>
                        <span id="msg_botao" class="d-none" style="padding-left: 15px; color: red;">Alguns campos estão inválidos</span>
                    </div>

                    <!--end::Form-->
                </div>

                <!--end::Portlet-->

                <!--begin::Portlet-->


                <!--end::Portlet-->
            </div>
            
        </div>
    </div>
</div>
@endsection