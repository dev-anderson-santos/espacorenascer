@extends('adminlte::page')

@section('content')
<style>
    .border-left-danger {
        border-left: 0.25rem solid #e74a3b!important;
    }
</style>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>Cadastro de Profissional</h2>
            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-body">

        @include('componentes.alerts')

        <form id="cadastro-profissional" class="form-group" method="post" action="{{ route('user.update') }}">
            @csrf
            @if(!empty($user)) @method('PUT') @endif
            <input type="hidden" name="user_id" value="{{ $user->id ?? '' }}">
            <fieldset>
                <legend>Dados de Acesso</legend>
                @if (auth()->user()->is_admin == 1)                            
                    <div class="row">
                        <div class="col-md-4">
                            <label for="status" class="col-form-label">Tornar administrador:</label>
                            <select name="is_admin" id="is_admin" 
                                data-old-status="{{!empty($user->is_admin) ? $user->is_admin : ''}}"
                                class="form-control {{ $errors->has('is_admin') ? 'is-invalid' : '' }}" required>
                                <option value="1" {{ (!empty($user) && $user->is_admin == '1') ? 'selected' : (old('is_admin') == '1' ? 'selected' : '') }}>Sim</option>
                                <option value="0" {{ (!empty($user) && $user->is_admin == '0') ? 'selected' : (old('is_admin') == '0' ? 'selected' : '') }}>Não</option>
                            </select>
                            @if ($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="status" class="col-form-label">Status:</label>
                            <select name="status" id="status" 
                                data-old-status="{{!empty($user->status) ? $user->status : ''}}"
                                class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                                <option value="1" {{ (!empty($user) && $user->status == '1') ? 'selected' : (old('status') == '1' ? 'selected' : '') }}>Ativo</option>
                                <option value="0" {{ (!empty($user) && $user->status == '0') ? 'selected' : (old('status') == '0' ? 'selected' : '') }}>Inativo</option>
                            </select>
                            @if ($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                <div class="row mt-2 mb-3">
                    {{-- <div class="col-12 col-md-6">
                        <label class="form-labels">Usuário</label>
                        <input name="username" class="form-control username border-left-danger @error('username') is-invalid @enderror" autocomplete="off" type="text" value="{{ old('username') ?? $user->username ?? '' }}" required>
                        @error('username')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    <div class="col-12 col-md-6 mt-2 mb-2">
                        <label class="form-labels" for="email">E-mail</label>
                        <input name="email" id="email" class="form-control border-left-danger @error('email') is-invalid @enderror" type="email" value="{{ old('email') ?? $user->email ?? '' }}" required="">
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-labels">Senha</label>
                        <input name="password" class="form-control password border-left-danger @error('password') is-invalid @enderror" type="password" autocomplete="off" value="{{ old('password') ?? $user->password ?? '' }}" required>
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-labels">Confirmar Senha</label>
                        <input onblur="" name="password_confirmation" class="form-control senha2 border-left-danger" type="password" autocomplete="off" value="{{ old('password_confirmation') ?? $user->password ?? '' }}" required>
                    </div>                                                
                </div>
            </fieldset>
            <fieldset>
                <legend>Informações Principais</legend>
                    <div class="row mt-2 mb-3">                                        
                        <div class="col-12 col-md-8">
                            <label class="form-labels">Nome Completo</label>
                            <input name="name" class="form-control nome_razao_social" type="text" value="{{ old('name') ?? $user->name ?? '' }}">
                        </div>
                        
                        <div class="col-9 col-md-4 cpf-group">
                            <label class="form-labels" for="cpfcnpj">CPF</label>
                            <input name="cpf" id="cpf" class="form-control cpf border-left-danger @error('cpf') is-invalid @enderror" type="text" value="{{ old('cpf') ?? $user->cpf ?? '' }}" required="" maxlength="15">
                            <small class="hint-cpf" style="color: red"></small>
                            @error('cpf')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-4 mt-2">
                            <label class="form-labels" for="crp_crm">Nº Inscrição CRP/CRM</label>
                            <input name="inscricao_crp_crm" id="crp_crm" class="form-control border-left-danger @error('inscricao_crp_crm') is-invalid @enderror" type="text" value="{{ old('inscricao_crp_crm') ?? $user->inscricao_crp_crm ?? '' }}" required>
                            @error('inscricao_crp_crm')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-3 mt-2">
                            <label class="form-labels" for="data_nascimento">Data de Nascimento</label>
                            <input name="birth_date" id="data_nascimento" class="form-control" maxlength="10" type="date" placeholder="00/00/0000" value="{{ old('birth_date') ?? $user->birth_date ?? '' }}">
                        </div>
                        
                    </div>
            </fieldset>
            <fieldset>
                <legend>Contato</legend>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4 mt-2 mb-2">
                            <label class="form-labels" for="tel_con">Telefone de Contato</label>
                            <input name="phone" class="form-control telefone_com_ddd border-left-danger @error('phone') is-invalid @enderror" id="tel_con" maxlength="15" type="text" value="{{ old('phone') ?? $user->phone ?? '' }}" required="">
                            @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="col-12 col-md-8 mt-2 mb-2">
                            <label class="form-labels" for="email">E-mail</label>
                            <input name="email" id="email" class="form-control border-left-danger @error('email') is-invalid @enderror" type="email" value="{{ old('email') ?? $user->email ?? '' }}" required="">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <div class="col-12 col-md-5 mt-2 mb-2">
                            <label class="form-labels" for="end_res">Endereço Residencial</label>
                            <input name="street" id="end_res" class="form-control" type="text" value="{{ old('street') ?? $user->hasAddress->address->street ?? '' }}">
                        </div>
                        <div class="col-12 col-md-2 mt-2 mb-2">
                            <label class="form-labels" for="cep">CEP</label>
                            <input name="zipcode" id="cep" class="form-control cep" maxlength="9" placeholder="00000-000" type="text" value="{{ old('zipcode') ?? $user->hasAddress->address->zipcode ?? '' }}">
                        </div>
                        <div class="col-12 col-md-3 mt-2 mb-2">
                            <label class="form-labels" for="complemento_res">Complemento</label>
                            <input name="complement" id="complemento_res" class="form-control complemento_res" type="text" value="{{ old('complement') ?? $user->hasAddress->address->complement ?? '' }}">
                        </div>
                        <div class="col-12 col-md-2 mt-2 mb-2">
                            <label class="form-labels" for="numero_res">Número</label>
                            <input name="number" id="numero_res" class="form-control numero" type="text" value="{{ old('number') ?? $user->hasAddress->address->number ?? '' }}">
                        </div>
                        <div class="col-12 col-md-3 mt-2 mb-2">
                            <label class="form-labels" for="bairro_res">Bairro</label>
                            <input name="district" class="form-control bairro" type="text" value="{{ old('district') ?? $user->hasAddress->address->district ?? '' }}">
                        </div>
                        <div class="col-12 col-md-3 mt-2 mb-2">
                            <label class="form-labels" for="bairro">Cidade</label>
                            <input name="city" class="form-control" type="text" value="{{ old('city') ?? $user->hasAddress->address->city ?? '' }}">
                        </div>
                        <div class="col-12 col-md-3 mt-2 mb-2">
                            <label class="form-labels" for="uf">Estado</label>
                            <select id="uf" name="state" class="form-control estado">
                                <option value="">-- Selecione --</option>
                                @foreach (getEstados() as $sigla => $estado)
                                    <option value="{{ $sigla }}" {{ (!empty($user) && !empty($user->hasAddress->address) && $user->hasAddress->address->state == $sigla) ? 'selected' : (old('state') == $sigla ? 'selected' : '') }}>{{ $estado }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            </fieldset>
            <fieldset>
                <legend>Sobre o Profissional</legend>                        
                    <div class="row">
                        <div class="col-12 col-md-6 mt-2 mb-2">
                            <label class="form-labels" for="academic_formations">Formações Acadêmicas</label>
                            <textarea id="academic_formations" style="min-height: 150px;" name="academic_formations" class="form-control">{{ old('academic_formations') ?? $user->academic_formations ?? '' }}</textarea>
                        </div>
                        
                        <div class="col-12 col-md-6 mt-2 mb-2">
                            <label class="form-labels" for="experiencia">Experiência em síndromes ou situações especiais</label>
                            <textarea style="min-height: 150px;" name="syndromes_special_situations_experience" class="form-control">{{ old('syndromes_special_situations_experience') ?? $user->syndromes_special_situations_experience ?? '' }}</textarea>
                        </div>
                        
                        <div class="col-12 col-md-6 mt-2 mb-2">
                            <label class="form-labels" for="faixa_etaria_atendimento">Faixa etária de atendimento</label>
                            <textarea style="min-height: 150px;" id="faixa_etaria_atendimento" name="age_range_service" class="form-control">{{ old('age_range_service') ?? $user->age_range_service ?? '' }}</textarea>
                        </div>
                        
                        <div class="col-12 col-md-6 mt-2 mb-2">
                            <label class="form-labels" for="linhas_abordagem">Linhas de Abordagem</label>
                            <textarea style="min-height: 150px;" id="linhas_abordagem" name="approach_lines" class="form-control">{{ old('approach_lines') ?? $user->approach_lines ?? '' }}</textarea>
                        </div>
                    </div>
            </fieldset>
            <div class="form-group col-12 d-flex justify-content-end">   
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection