@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>Cadastro de Profissional</h2>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <!--begin::Form-->
                        <form id="cadastro-profissional" class="form-group" method="post" action="{{ route('user.store') }}">
                            @csrf
                            @if(!empty($user)) @method('PUT') @endif
                            <input type="hidden" name="id" value="{{ $user->id ?? '' }}">
                            <fieldset>
                                <legend>Dados de Acesso</legend>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class=" form-background">
                                            <div class="row m-3">
                                                <div class="col-12 col-md-6 mt-2 mb-2">
                                                    <label class="form-labels">Usuário</label>
                                                    <input name="username" class="form-control username border-left-danger @error('username') is-invalid @enderror" autocomplete="off" type="text" value="{{ old('username') ?? $usuario->username ?? '' }}" required>
                                                    @error('username')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-3 mt-2 mb-2">
                                                    <label class="form-labels">Senha</label>
                                                    <input name="password" class="form-control password border-left-danger @error('password') is-invalid @enderror" type="password" autocomplete="off" value="{{ old('password') ?? $usuario->password ?? '' }}" required>
                                                    @error('password')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-3 mt-2 mb-2">
                                                    <label class="form-labels">Confirmar Senha</label>
                                                    <input onblur="" name="password_confirmation" class="form-control senha2 border-left-danger" type="password" autocomplete="off" value="{{ old('password_confirmation') ?? $usuario->password ?? '' }}" required>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Informações Principais</legend>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class=" form-background">
                                            <div class="row m-3">                                        
                                                <div class="col-12 col-md-8 mt-2 mb-2">
                                                    <label class="form-labels">Nome Completo</label>
                                                    <input name="name" class="form-control nome_razao_social" type="text" value="{{ old('name') ?? $usuario->name ?? '' }}">
                                                </div>
                                                
                                                <div class="col-9 col-md-4 mt-2 mb-2">
                                                    <label class="form-labels" for="cpfcnpj">CPF</label>
                                                    <input name="cpf" id="cpf" class="form-control cpf border-left-danger @error('cpf') is-invalid @enderror" type="text" value="{{ old('cpf') ?? $usuario->cpf ?? '' }}" required="" maxlength="15">
                                                    @error('cpf')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="col-12 col-md-4 mt-2 mb-2">
                                                    <label class="form-labels" for="crp_crm">Nº Inscrição CRP/CRM</label>
                                                    <input name="inscricao_crp_crm" id="crp_crm" class="form-control" type="text" value="{{ old('inscricao_crp_crm') ?? $usuario->inscricao_crp_crm ?? '' }}">
                                                </div>
                                                
                                                <div class="col-12 col-md-3 mt-2 mb-2">
                                                    <label class="form-labels" for="data_nascimento">Data de Nascimento</label>
                                                    <input name="birth_date" id="data_nascimento" class="form-control" maxlength="10" type="date" placeholder="00/00/0000" value="{{ old('birth_date') ?? $usuario->birth_date ?? '' }}">
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Contato</legend>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class=" form-background">
                                            <div class="row m-3">
                                                <div class="col-12 col-md-4 mt-2 mb-2">
                                                    <label class="form-labels" for="tel_con">Telefone de Contato</label>
                                                    <input name="phone" class="form-control border-left-danger @error('phone') is-invalid @enderror" id="tel_con" maxlength="15" type="text" value="{{ old('phone') ?? $usuario->phone ?? '' }}" required="">
                                                    @error('phone')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-8 mt-2 mb-2">
                                                    <label class="form-labels" for="email">E-mail</label>
                                                    <input name="email" id="email" class="form-control border-left-danger @error('email') is-invalid @enderror" type="email" value="{{ old('email') ?? $usuario->email ?? '' }}" required="">
                                                    @error('email')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-5 mt-2 mb-2">
                                                    <label class="form-labels" for="end_res">Endereço Residencial</label>
                                                    <input name="street" id="end_res" class="form-control" type="text" value="{{ old('street') ?? $usuario->address->street ?? '' }}">
                                                </div>
                                                <div class="col-12 col-md-2 mt-2 mb-2">
                                                    <label class="form-labels" for="cep">CEP</label>
                                                    <input name="zipcode" id="cep" class="form-control cep" maxlength="9" placeholder="00000-000" type="text" value="{{ old('zipcode') ?? $usuario->address->zipcode ?? '' }}">
                                                </div>
                                                <div class="col-12 col-md-3 mt-2 mb-2">
                                                    <label class="form-labels" for="complemento_res">Complemento</label>
                                                    <input name="complement" id="complemento_res" class="form-control complemento_res" type="text" value="{{ old('complement') ?? $usuario->address->complement ?? '' }}">
                                                </div>
                                                <div class="col-12 col-md-2 mt-2 mb-2">
                                                    <label class="form-labels" for="numero_res">Número</label>
                                                    <input name="number" id="numero_res" class="form-control numero" type="text" value="{{ old('number') ?? $usuario->address->number ?? '' }}">
                                                </div>
                                                <div class="col-12 col-md-3 mt-2 mb-2">
                                                    <label class="form-labels" for="bairro_res">Bairro</label>
                                                    <input name="district" class="form-control bairro" type="text" value="{{ old('district') ?? $usuario->address->district ?? '' }}">
                                                </div>
                                                <div class="col-12 col-md-3 mt-2 mb-2">
                                                    <label class="form-labels" for="bairro">Cidade</label>
                                                    <input name="city" class="form-control" type="text" value="{{ old('city') ?? $usuario->address->city ?? '' }}">
                                                </div>
                                                <div class="col-12 col-md-3 mt-2 mb-2">
                                                    <label class="form-labels" for="uf">Estado</label>
                                                    <select id="uf" name="state" class="form-control estado">
                                                        <option value="">-- Selecione --</option>
                                                        @foreach (getEstados() as $sigla => $estado)
                                                            <option value="{{ $sigla }}" {{ !empty($user) && $user->address->state == $sigla ? 'selected' : (old('state') == $sigla ? 'selected' : '') }}>{{ $estado }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Sobre o Profissional</legend>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class=" form-background">
                                        
                                            <div class="row m-3">
                                                <div class="col-12 col-md-6 mt-2 mb-2">
                                                    <label class="form-labels" for="formacoes_academicas">Formações Acadêmicas</label>
                                                    <textarea id="academic_formations" style="min-height: 150px;" name="academic_formations" class="form-control"></textarea>
                                                </div>
                                                
                                                <div class="col-12 col-md-6 mt-2 mb-2">
                                                    <label class="form-labels" for="experiencia">Experiência em síndromes ou situações especiais</label>
                                                    <textarea style="min-height: 150px;" name="syndromes_special_situations_experience" class="form-control"></textarea>
                                                </div>
                                                
                                                <div class="col-12 col-md-6 mt-2 mb-2">
                                                    <label class="form-labels" for="faixa_etaria_atendimento">Faixa etária de atendimento</label>
                                                    <textarea style="min-height: 150px;" id="faixa_etaria_atendimento" name="age_range_service" class="form-control"></textarea>
                                                </div>
                                                
                                                <div class="col-12 col-md-6 mt-2 mb-2">
                                                    <label class="form-labels" for="linhas_abordagem">Linhas de Abordagem</label>
                                                    <textarea style="min-height: 150px;" id="linhas_abordagem" name="approach_lines" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row">
                                <div class="col m-3 pt-3 pb-5 float-right">
                                    <button type="submit" class="btn btn-primary btn-small btn_clientes">Enviar Cadastro</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection