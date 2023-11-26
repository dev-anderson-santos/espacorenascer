var button_gerenciar_medias;
var count_form_submit = 0;
var container_imagens_familias;
var verificar_horario;
var verificar_horario_qtd = 0;
var verificar_horario_limit = 200;
var data_agendamento_formato_br;
var data_agendamento;
var status_horario = 'livre';
var status_horario_item;
var atualizar_pagina = false;
var id_user_agendamento;354 
var tipo_user_agendamento;
var date_create_agendamento;
var user_create_agendamento;
var tipo_agendamento;
var dia;
var id_agendamento;


function parar_verificacao(){
	if( $('.modal').length > 0 ){
		$('.modal').find('.close').click();
	}
	clearInterval(verificar_horario);
	verificar_horario_qtd = 0;
}


    function modal_basic(titulo = '', conteudo = '', cor = '#88888', redirect = '', id = 'exampleModalCenter', footer=true) {



        html = '\
                <div class="modal fade" id="' + id + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">\
    <div class="modal-dialog modal-dialog-centered" role="document">\
        <div class="modal-content">\
            <div class="modal-header">\
                <h5 class="modal-title" id="exampleModalCenterTitle" style="color: ' + cor + ';">' + titulo + '</h5>\
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
                    <span aria-hidden="true">&times;</span>\
                </button>\
            </div>\
            <div class="modal-body">\
                ' + conteudo + '\
            </div>\
            '+( footer == true ? '<div class="modal-footer">\
                <button type="button" class="btn fechar-modal btn-secondary" ' + (redirect ? 'onclick="location=\'' + redirect + '\'"' : '') + ' style="background: ' + cor + '; border-color: ' + cor + ';" data-dismiss="modal">Fechar</button>\
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->\
            </div> ' : footer ) + '\
        </div>\
    </div>\
</div>\
';
        $('body').append(html);
        $('#' + id).modal('show');
    }





    function modal(titulo = '', conteudo = '', campos = 'true', funcao = '', botao1 = 'prosseguir', botao2 = '', id_form = '', class_form = '', action_form = '', largura_modal = '') {

        $('.modal').modal('hide');
        $('#form_modal,.modal-backdrop').remove();
        if (titulo == 'remover-modal') {
            return;
        }



//botao2 = ( botao2 ? '<button type="button" class="btn btn-secondary" data-dismiss="modal">'+botao2+'</button>' : '' );

        botao2 = (botao2 ? '<button type="button" class="btn btn-secondary btn-danger" onclick="' + (botao2 == "Terminar de preencher os formulários" || botao2 == "Enviar depois" || botao2 == "Fechar" || botao2 == "Carregar outro arquivo" ? "$(this).parents('.modal').find('.close').click();" : "window.location.reload()") + '" >' + botao2 + '</button>' : '');
        botao1 = (botao1 == 'false' ? '' : '<button type="button" class="btn btn-primary fechar-modal" '+(botao1 == 'Agendar'?'disabled':'')+' onclick="' + (funcao ? funcao : '') + '">' + (botao1 == 'Agendar'? botao1 + '<span class="verificando-disponibilidade"><span class="loader"></span></span>':botao1) + '</button>');
        var modal = '\
                <div id="form_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="z-index: 99999;">\
    <div class="modal-dialog" role="document" style="max-width: '+( largura_modal ? largura_modal : '1500px' )+'; width: 95%;">\
        <div class="modal-content">\
            <div class="modal-header">\
                <h5 class="modal-title">' + titulo + '</h5>\
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
                    <span aria-hidden="true">&times;</span>\
                </button>\
            </div>\
            <form method="post" action="' + (action_form ? action_form : 'logar') + '" class="' + (class_form ? class_form : '') + '" ' + (id_form ? 'id="' + id_form + '"' : '') + ' enctype="multipart/form-data">\
                  <div class="modal-body" style="max-height: 600px; overflow: auto;">\
                    <p>' + conteudo + '</p>\
                    ' + (campos == 'none' || campos == false ? '' : '<p><input class="col" placeholder="email" type="' + (campos == 'true' ? 'text' : 'hidden') + '" name="user_email" required /></p>') + '\
                    ' + (campos == 'none' || campos == false ? '' : '<p><input class="col" placeholder="senha" type="' + (campos == 'true' ? 'password' : 'hidden') + '" name="user_password" required /></p>') + '\
                </div>\
                <div class="modal-footer ' + (!botao1 && !botao2 ? 'd-none' : '') + ' ">\
                    ' + botao1 + botao2 + '\
                </div>\
            </form>\
        </div>\
    </div>\
</div>\
                ';
        $(modal).appendTo('body');
        $('.modal').modal({

            keyboard: false,
            //backdrop: 'static',

        });
        //$('.modal').modal('show');

        $('#form_modal').modal();
        //$('select').selectpicker();



        return modal;
    }
















$(window).on('load', function () {

    $('.loading').fadeOut();
    window.setTimeout(function () {

        $('.loading').remove();
    }, 1000);
});
var initTable1;
function jsonDecodeAjax(resposta) {

    var x = resposta;
    var r = /\\u([\d\w]{4})/gi;
    x = x.replace(r, function (match, grp) {

        return String.fromCharCode(parseInt(grp, 16));
    });
    return x;
}




	
	function agendar(dados){
		
		dados.tipo_agendamento = $('#tipo-agendamento').val();
		dados.tipo_user_create = permissoes;
		dados.id_user_create = user_id;
		dados.id_user = user_id;
		dados.data_agendamento_formato_br = data_agendamento_formato_br;
		dados.data_agendamento = data_agendamento;
		dados.dia = dia;
		
		$.ajax({
			url: base_url+'/ajax/agendamento/?action=insert',
			dataType: 'json',
			method: 'POST',
			data: dados,
			success: function(resposta){
				
				console.log(resposta);
				funcao = "location.reload();";
				botao1 = 'Ok';
				botao2 = '';
				modal(titulo = resposta.title, resposta.msg, campos = 'false', funcao, botao1, botao2, id_form = '', class_form = '', action_form = '', largura_modal = '450px');
				atualizar_pagina = true;
				
			},
			error: function(){
				alert('Erro ao tentar agendar, verifique sua internet e tente novamente!');
				atualizar_pagina = true;
			}
		})
		
	}


	
	function atualizar_agendamento(dados){
		
		dados.tipo_user_create = permissoes;
		dados.id_user_create = user_id;
		dados.id_user = user_id;
		dados.data_agendamento_formato_br = data_agendamento_formato_br;
		dados.data_agendamento = data_agendamento;
		dados.tipo_agendamento = tipo_agendamento;
		dados.dia = dia;
		
		$.ajax({
			url: base_url+'/ajax/agendamento/?action=update',
			dataType: 'json',
			method: 'POST',
			data: dados,
			success: function(resposta){
				
				console.log(resposta);
				funcao = "location.reload();";
				botao1 = 'Ok';
				botao2 = '';
				modal(titulo = resposta.title, resposta.msg, campos = 'false', funcao, botao1, botao2, id_form = '', class_form = '', action_form = '', largura_modal = '450px');
				atualizar_pagina = true;
				
			},
			error: function(){
				alert('Erro ao tentar agendar, verifique sua internet e tente novamente!');
				atualizar_pagina = true;
			}
		})
		
	}

	
	function cancelamento(dados){
		
		dados.tipo_user_create = permissoes;
		dados.id_user_create = user_id;
		dados.id_user = user_id;
		dados.id_agendamento = id_agendamento;
		dados.data_agendamento_formato_br = data_agendamento_formato_br;
		dados.data_agendamento = data_agendamento;
		dados.tipo_agendamento = tipo_agendamento;
		dados.dia = dia;
		
		$.ajax({
			url: base_url+'/ajax/agendamento/?action=cancelamento',
			dataType: 'json',
			method: 'POST',
			data: dados,
			success: function(resposta){
				
				console.log(resposta);
				funcao = "location.reload();";
				botao1 = 'Ok';
				botao2 = '';
				modal(titulo = resposta.title, resposta.msg, campos = 'false', funcao, botao1, botao2, id_form = '', class_form = '', action_form = '', largura_modal = '450px');
				atualizar_pagina = true;
				
			},
			error: function(){
				alert('Erro ao tentar cancelar, verifique sua internet e tente novamente!');
				atualizar_pagina = true;
			}
		})
		
	}
	
	
	function conteudo_modal_horario(conteudo='',dados){
		
		if( conteudo == 1 || conteudo == 'cancelamento' ){
			
			conteudo = `
			<p>
				Profissional: `+user_name+`<br>
				Sala: `+dados.numero_sala+`<br>
				Data: `+data_agendamento_formato_br+`<br>
				Horário: `+dados.horario+`<br>
				`+ ( conteudo == 'cancelamento' && user_create_agendamento ?
				`<span style="color: #fd397a;">Tipo de agendamento: `+tipo_agendamento+'</span><br>' : '' ) + `
				`+ ( conteudo == 'cancelamento' && date_create_agendamento ?
				`<span style="color: #fd397a;">Criado em: `+date_create_agendamento+'</span><br>' : '' ) + `
				`+ ( conteudo == 'cancelamento' && user_create_agendamento ?
				`<span style="color: #fd397a;">Criado por: `+user_create_agendamento+'</span><br>' : '' ) + `
				`+ ( conteudo != 'cancelamento' ? `
				<div class="">
					<label for="tipo-agendamento" class="">Tipo de agendamento:</label><br>
					<select id="tipo-agendamento" class="col-6" style="padding: 7px;">
						<option selected value="avulso">Avulso</option>
						<option value="fixo">Fixo</option>
					</select>
				</div>
				` : '' ) + `
			</p>
			<br>
			`+ ( conteudo == 'cancelamento' ? '' : `
			<div class="alert alert-solid-warning alert-bold" role="alert">
				<div class="alert-text">Confira os dados acima antes de prosseguir!</div>
			</div>
			` ) + `
			<div class="alert alert-solid-danger alert-bold" role="alert">
				<div class="alert-text">O prazo para cancelamento é com 24h de antecedência!</div>
			</div>
			`;
		
		}else{
			
			status_horario == 'livre';
			mensagem = 'Esse horário não está livre para agendamento!';
			if( conteudo == '2' ){
				mensagem = 'Um usuário acabou de agendar esse horário, tente outra sala ou outro horário!';
			}
			conteudo = `
				<br>
				<div class="alert alert-solid-danger alert-bold" role="alert">
					<div class="alert-text">`+mensagem+`</div>
				</div>
				`;
		 
		}
		return conteudo;
	}

function verificar_horario_sala(verificar_dados,status_horario_item,dados){
	
	id_user_agendamento = '';
	date_create_agendamento = '';
	user_create_agendamento = '';
	
	$.ajax({
		url: base_url+'ajax/agendamento/?action=verificar'+verificar_dados+'&dia='+dia,
		dataType: 'json',
		async: false,
		success: function(resposta){
		    
			if( resposta.verifyDateTime == false ){
			    if( $('.modal-footer .btn-primary').length > 0 ){
				    let alertDateTime = `
				    <div class="alert alert-solid-danger alert-bold" role="alert" style="
                        margin-top: 0px;
                        margin-bottom: 0px;
                    ">
				    <div class="alert-text" style="">Não pode fazer agendamentos após 22:00</div>
			        </div>
			        `;
			        $('.modal-footer .btn-primary').remove();
			        $('.modal-footer').prepend(alertDateTime);
			        console.log('verifyDateTime: '+ resposta.verifyDateTime);
			    }
			}else{
		        $('.modal-footer .btn-primary').prop("disabled", false);
		        $('.modal-footer .btn-primary .verificando-disponibilidade').fadeOut();
		    }		    
		    
			status_horario = ( resposta.status == 'existe' ? 'ocupado' : 'livre' );
			id_user_agendamento = ( resposta.id_user &&  resposta.id_user != 'undefined' ? resposta.id_user: '' );
			date_create_agendamento = ( resposta.date_create &&  resposta.date_create != 'undefined' ? resposta.date_create: '' );
			user_create_agendamento = ( resposta.user_create &&  resposta.user_create != 'undefined' ? resposta.user_create: '' );
			if( status_horario != status_horario_item ){
				atualizar_pagina = true;
			}
			console.log('dentro do intervalor' + status_horario);
			console.log('dentro do intervalor item' + status_horario_item);
			
		}
	})
	
	verificar_horario = window.setInterval(function(){
		if( verificar_horario_qtd >= verificar_horario_limit  ){
			parar_verificacao();
		}
		verificar_horario_qtd++;
		$.ajax({
			url: base_url+'ajax/agendamento/?action=verificar'+verificar_dados+'&dia='+dia,
			dataType: 'json',
			success: function(resposta){
				
				if( resposta.verifyDateTime == false ){
				    if( $('.modal-footer .btn-primary').length > 0 ){
    				    let alertDateTime = `
    				    <div class="alert alert-solid-danger alert-bold" role="alert" style="
                            margin-top: 0px;
                            margin-bottom: 0px;
                        ">
    				    <div class="alert-text">Agendamentos encerrados para o dia de hoje. Selecione uma data posterior.</div>
    			        </div>
    			        `;
    			        $('.modal-footer .btn-primary').remove();
    			        $('.modal-footer').prepend(alertDateTime);
    			        console.log('verifyDateTime: '+ resposta.verifyDateTime);
				    }
				}else{
		            $('.modal-footer .btn-primary').prop("disabled", false);
    		        $('.modal-footer .btn-primary .verificando-disponibilidade').fadeOut();
			    }
				
				status_horario = ( resposta.status == 'existe' ? 'ocupado' : 'livre' );
				if( status_horario != status_horario_item ){
					atualizar_pagina = true;
				}
				console.log('dentro do intervalor' + status_horario);
				console.log('dentro do intervalor item' + status_horario_item);
				
				if( 
					status_horario_item == status_horario &&
					$('.modal').attr('status') != status_horario &&
					$('.modal').attr('status') != 'undefined' &&
					$('.modal').attr('status')
				){
					if( status_horario == 'livre' ){
						verificacao = 1;
						$('.modal-footer').html('<button type="button" class="btn btn-primary fechar-modal" onclick="agendar({id_sala:\''+dados.sala+'\',horario:\''+dados.horario+'\',numero_sala:\''+dados.numero_sala+'\'});">Agendar</button><button type="button" class="btn btn-secondary btn-danger" onclick="location.reload();">Fechar</button>');
					}else{
						verificacao = 2;
						$('.modal-footer').html('<button type="button" class="btn btn-primary fechar-modal" onclick="location.reload();">Fechar</button>');
					}
					console.log('caiu aqui 1');
					$('.modal').attr('status',status_horario);
					$('.modal-body').html('<p></p>'+conteudo_modal_horario(verificacao,{sala:dados.sala,horario:dados.horario}));
					
				}else if( status_horario == 'ocupado' && status_horario_item != status_horario ){
					if( $('.modal').length > 0 && $('.modal').attr('status') != status_horario ){
						console.log('caiu aqui 2');
						$('.modal').attr('status',status_horario);
						$('.modal-body').html('<p></p>'+conteudo_modal_horario(2,{sala:dados.sala,horario:dados.horario}));
						$('.modal-footer').html('<button type="button" class="btn btn-primary fechar-modal" onclick="location.reload();">Fechar</button>');
					}
				}else if( status_horario == 'livre' && status_horario_item != status_horario ){
					status_horario_item = status_horario;
					console.log('caiu aqui 3');
					$('.modal-body').html('<p></p>'+conteudo_modal_horario(1,{sala:dados.sala,horario:dados.horario}));
					$('.modal-footer').html('<button type="button" class="btn btn-primary fechar-modal" onclick="agendar({id_sala:\''+dados.sala+'\',horario:\''+dados.horario+'\',numero_sala:\''+dados.numero_sala+'\'});">Agendar</button><button type="button" class="btn btn-secondary btn-danger" onclick="location.reload();">Fechar</button>');
				}			
			}
		})
	},1000);
	
}





var table;
var click;
$(document).ready(function () {



$("body").on('click','.agendar-horario',function(){
	
	var sala = $(this).attr('data-sala');
	var numero_sala = sala;
	var id_sala = $(this).attr('data-id-sala');
	var horario = $(this).attr('data-horario');
	var conteudo = '';
	var funcao = 'agendar({id_sala:\''+id_sala+'\',horario:\''+horario+'\',numero_sala:\''+numero_sala+'\'});';
	var botao1 = 'Agendar';
	var botao2 = 'Fechar';
	id_agendamento = $(this).attr('data-id');
	
	/*data_agendamento_formato_br = $('select[name=data]').val();
	data_agendamento = $('select[name=data] option:selected').attr('data-banco');*/
	console.log(data_agendamento_formato_br);
	dia = data_agendamento_formato_br.split(',')[0];
	tipo_agendamento = $(this).attr('data-tipo-agendamento');

	
	
	
	
	verificar_dados = '&id_sala='+id_sala+'&horario='+horario+'&data_agendamento_formato_br='+data_agendamento_formato_br+'&data_agendamento='+data_agendamento;
	status_horario_item = $(this).attr('data-status');
	
	verificar_horario_sala(verificar_dados,status_horario_item,{sala:id_sala,horario:horario,numero_sala:numero_sala});
	
	console.log('fora do intervalor' + status_horario);
	console.log('fora do intervalor item' + status_horario_item);
	
	
	
	
	if( (status_horario == 'livre') || (status_horario_item == 'livre' && status_horario == 'livre') ){
		
		conteudo = conteudo_modal_horario(1,{sala:id_sala,horario:horario,numero_sala:numero_sala});
	
	}else if( ( id_user_agendamento == user_id ) || ( id_user_agendamento && ( permissoes == 'admin' || permissoes == 'Administrador' ) ) ){
		
		conteudo = conteudo_modal_horario('cancelamento',{sala:id_sala,horario:horario,numero_sala:numero_sala});
	
	}else{
		status_horario == 'livre';
		tipo = 0;
		conteudo = conteudo_modal_horario('',{sala:id_sala,horario:horario,numero_sala:numero_sala});
		if( status_horario_item == 'livre' ){
			tipo = 1;
			conteudo = conteudo_modal_horario(2,{sala:id_sala,horario:horario,numero_sala:numero_sala});
		}
		
		funcao = ( tipo == 1 ? "location.reload();" : '' );
		botao1 = 'Fechar';
		botao2 = '';
	 
	}
	if( ( id_user_agendamento == user_id ) || ( id_user_agendamento && ( permissoes == 'admin' || permissoes == 'Administrador' ) ) ){
		funcao = 'cancelamento({id_sala:\''+id_sala+'\',horario:\''+horario+'\',numero_sala:\''+numero_sala+'\'})';
		botao1 = 'Cancelar Agendamento';
		botao2 = '';
	}
	modal(titulo = 'Agendamento', conteudo, campos = 'false', funcao, botao1, botao2, id_form = '', class_form = '', action_form = '', largura_modal = '450px');
	

})




$("body").on('change blur','form#cadastro-profissional input',function(){
	senha1 = $('.senha').val();
	senha2 = $('.senha2').val();
	if( (senha1 && senha2) && senha1 != senha2 ){
		modal_basic('ERRO','Senha não confere!');
		return false;
	}
})

	function PreviewImage(id_input,id_img,id_placeholder) {
			var oFReader = new FileReader();
			oFReader.readAsDataURL(document.getElementById(id_input).files[0]);
			oFReader.onload = function (oFREvent) {
				document.getElementById("imagem-preview-modal").src = oFREvent.target.result;
				if( $('#imagem-preview-modal').attr('src') ){
					$('#imagem-preview-modal').removeClass('d-none');
					$('#imagem-preview-modal').next('span').addClass('d-none');
				}else{
					$('#imagem-preview-modal').addClass('d-none');
					$('#imagem-preview-modal').next('span').removeClass('d-none');
				}
			};

		};


//console.log('url_atual ----------- '+ url_atual);





    $('.sidebar-nav li a').each(function (index) {

//console.log(index);

        if ($(this).attr('href') === url_atual) {

            $(this).addClass('ativo');
            if ($(this).parents('.card').length > 0) {

                $(this).parents('.card').find('button').addClass('ativo');
            }

        }

    });

//modal adicionar endereço ordem de serviço





    $('#os_add-endereco').on('click', function () {

        var id_cliente = $('#id_cliente').attr('data-id');
        console.log(id_cliente);
        titulo = 'Informações de Endereço';
        conteudo = '\
                <div class="modal-body">\
    <div class="row">\
        <div id="cliente-box-endereco" class="col-12">\
            <input type="hidden" name="id_cliente" value="' + id_cliente + '">\
            <div class="row enderecos-cliente" style="position: relative;">\
                <div class="col-12 col-md-3 mt-2 mb-2">\
                    <label class="form-labels">Nome do Local</label>\
                    <input name="enderecos[0][dono_da_casa]" class="form-control" type="text" value="">\
                </div>\
                <div class="col-12 col-md-3 mt-2 mb-2">\
                    <label class="form-labels">CEP <span style="color: red;">*</span></label>\
                    <input id="cep" name="enderecos[0][cep]" class="form-control cep" type="text" value="" required="">\
                </div>\
                <div class="col-12 col-md-6 mt-2 mb-2">\
                    <label class="form-labels">Endereço</label>\
                    <input id="endereco" name="enderecos[0][endereco]" class="form-control endereco" type="text" value="">\
                </div>\
                <div class="col-12 col-md-4 mt-2 mb-2">\
                    <label class="form-labels">Complemento</label>\
                    <input name="enderecos[0][complemento]" class="form-control complemento" type="text" value="">\
                </div>\
                <div class="col-12 col-md-4 mt-2 mb-2">\
                    <label class="form-labels">Número</label>\
                    <input name="enderecos[0][numero]" class="form-control numero" type="text" value="">\
                </div>\
                <div class="col-12 col-md-4 mt-2 mb-2">\
                    <label class="form-labels">Bairro</label>\
                    <input id="bairro" name="enderecos[0][bairro]" class="form-control bairro" type="text" value="">\
                </div>\
                <div class="col-12 col-md-3 mt-2 mb-2">\
                    <label class="form-labels">Estado</label>\
                    <select id="uf" name="enderecos[0][estado]" class="form-control estado">\
                        <option value="AC">Acre</option>\
                        <option value="AL">Alagoas</option>\
                        <option value="AP">Amapá</option>\
                        <option value="AM">Amazonas</option>\
                        <option value="BA">Bahia</option>\
                        <option value="CE">Ceará</option>\
                        <option value="DF">Distrito Federal</option>\
                        <option value="ES">Espírito Santo</option>\
                        <option value="GO">Goiás</option>\
                        <option value="MA">Maranhão</option>\
                        <option value="MT">Mato Grosso</option>\
                        <option value="MS">Mato Grosso do Sul</option>\
                        <option value="MG">Minas Gerais</option>\
                        <option value="PA">Pará</option>\
                        <option value="PB">Paraíba</option>\
                        <option value="PR">Paraná</option>\
                        <option value="PE">Pernambuco</option>\
                        <option value="PI">Piauí</option>\
                        <option value="RJ">Rio de Janeiro</option>\
                        <option value="RN">Rio Grande do Norte</option>\
                        <option value="RS">Rio Grande do Sul</option>\
                        <option value="RO">Rondônia</option>\
                        <option value="RR">Roraima</option>\
                        <option value="SC">Santa Catarina</option>\
                        <option value="SP">São Paulo</option>\
                        <option value="SE">Sergipe</option>\
                        <option value="TO">Tocantins</option>\
                    </select>\
                </div>\
                <div class="col-12 col-md-3 mt-2 mb-2">\
                    <label class="form-labels">Cidade</label>\
                    <input id="cidade" name="enderecos[0][cidade]" class="form-control cidade" type="text" value="">\
                </div>\
                <div class="col-12 col-md-3 mt-2 mb-2">\
                    <label class="form-labels">Ponto de referência</label>\
                    <input name="enderecos[0][referencia]" class="form-control" type="text" value="">\
                </div>\
                <div class="col-12 col-md-3 mt-2 mb-2">\
                    <label class="form-labels">Meios de Condução</label>\
                    <input name="enderecos[0][como_chegar]" class="form-control" type="text" value="">\
                </div>\
                <div class="col-10 mt-2 mb-2 comment-input">\
                    <label class="form-labels">Recomendações Recorrentes</label>\
                    <input id="input_recomendacoes" name="" class="form-control" type="text" value="">\
                    <button type="button" id="btn_recomendacoes" class="btn_recomendacoes btn btn-warning btn-sm btn-icon btn-circle" style="position: absolute; right: -30px; top: 29px; cursor: pointer;"><i class="fa fa-plus text-white"></i></button>\
                </div>\
                <div class="comments-section comments col-12 mt-3">\
                    <input id="resultadoRecomendacoes" type="hidden" name="enderecos[0][recomendacoes]" value="">\
                </div>\
            </div>\
        </div>\
    </div>\
</div>\
';
        modal(titulo, conteudo, campos = 'none', "$(this).parents('form').submit();", 'Adicionar Novo', '', id_form = 'os_add-endereco', class_form = 'form-ajax', action_form = base_url + 'ajax/clientes-endereco/?action=insert');
    });
    $('.fc .fc-row .fc-content-skeleton table, .fc .fc-row .fc-content-skeleton td, .fc .fc-row .fc-helper-skeleton td').on('click', function () {



        titulo = 'Informações de Agendamento';
        conteudo = '\
                <div class="modal-body">\
    <div class="row">\
        <div id="cliente-box-endereco" class="col-12">\
            <input type="hidden" name="id_cliente" value="' + id_cliente + '">\
            <div class="row enderecos-cliente" style="position: relative;">\
                <div class="col-12 col-md-3 mt-2 mb-2">\
                    <label class="form-labels">Nome do Local</label>\
                    <input name="enderecos[0][dono_da_casa]" class="form-control" type="text" value="">\
                </div>\
                <div class="col-12 col-md-3 mt-2 mb-2">\
                    <label class="form-labels">CEP <span style="color: red;">*</span></label>\
                    <input id="cep" name="enderecos[0][cep]" class="form-control cep" type="text" value="" required="">\
                </div>\
                <div class="col-12 col-md-6 mt-2 mb-2">\
                    <label class="form-labels">Endereço</label>\
                    <input id="endereco" name="enderecos[0][endereco]" class="form-control endereco" type="text" value="">\
                </div>\
                <div class="col-12 col-md-4 mt-2 mb-2">\
                    <label class="form-labels">Complemento</label>\
                    <input name="enderecos[0][complemento]" class="form-control complemento" type="text" value="">\
                </div>\
                <div class="col-12 col-md-4 mt-2 mb-2">\
                    <label class="form-labels">Número</label>\
                    <input name="enderecos[0][numero]" class="form-control numero" type="text" value="">\
                </div>\
                <div class="col-12 col-md-4 mt-2 mb-2">\
                    <label class="form-labels">Bairro</label>\
                    <input id="bairro" name="enderecos[0][bairro]" class="form-control bairro" type="text" value="">\
                </div>\
                <div class="col-12 col-md-3 mt-2 mb-2">\
                    <label class="form-labels">Cidade</label>\
                    <input id="cidade" name="enderecos[0][cidade]" class="form-control cidade" type="text" value="">\
                </div>\
                <div class="col-12 col-md-3 mt-2 mb-2">\
                    <label class="form-labels">Ponto de referência</label>\
                    <input name="enderecos[0][referencia]" class="form-control" type="text" value="">\
                </div>\
                <div class="col-12 col-md-3 mt-2 mb-2">\
                    <label class="form-labels">Meios de Condução</label>\
                    <input name="enderecos[0][como_chegar]" class="form-control" type="text" value="">\
                </div>\
                <div class="col-10 mt-2 mb-2 comment-input">\
                    <label class="form-labels">Recomendações Recorrentes</label>\
                    <input id="input_recomendacoes" name="" class="form-control" type="text" value="">\
                    <button type="button" id="btn_recomendacoes" class="btn_recomendacoes btn btn-warning btn-sm btn-icon btn-circle" style="position: absolute; right: -30px; top: 29px; cursor: pointer;"><i class="fa fa-plus text-white"></i></button>\
                </div>\
                <div class="comments-section comments col-12 mt-3">\
                    <input id="resultadoRecomendacoes" type="hidden" name="enderecos[0][recomendacoes]" value="">\
                </div>\
            </div>\
        </div>\
    </div>\
</div>\
';
        modal(titulo, conteudo, campos = 'none', "$(this).parents('form').submit();", 'Adicionar Novo', '', id_form = 'os_add-endereco', class_form = 'form-ajax', action_form = base_url + 'ajax/clientes-endereco/?action=insert');
    });
    $("body").on("click", '.btn_recomendacoes', function () {



        var recomendacao_lista = $(this).parents(".comment-input").find("input").val();
        var $new_comment;
        if (recomendacao_lista && recomendacao_lista !== "undefined") {



            $(this).parents('.enderecos-cliente').find(".comments").append('<div data-value="' + recomendacao_lista + '" class="alert alert-warning alert-dismissible fade show lista_recomendacoes" role="alert">' + recomendacao_lista + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            if ($(this).parents(".comment-input").find("input").val() !== "") {



                valor_atual = $(this).parents('.enderecos-cliente').find('input#input_recomendacoes').val();
                valor_atual = (valor_atual && valor_atual != 'undefined' ? valor_atual : '');
                if (valor_atual) {



                    ids = $(this).parents('.enderecos-cliente').find('.comments').find('input').val();
                    $(this).parents('.enderecos-cliente').find('.comments').find('input').val((ids ? ids + ';' + valor_atual : valor_atual));
                }





                $(this).parents(".comment-input").find("input").val('');
            }



        } else {



// inserir um alerta bonito posteriormente



        }



    });
    $('body').on('click', '.lista_recomendacoes .close', function () {

        var input = $(this).parents('.comments').find('input');
        var valor_excluir = $(this).parents('.lista_recomendacoes').attr('data-value');
        //console.log('valor aqui ----  '+valor_excluir);

        var valor = '';
        $.each(input.val().split(';'), function (index, value) {

            if (value != valor_excluir) {

                valor = (valor ? valor + ';' + value : value);
            }

        })

        console.log(valor);
        input.val(valor);
    })



    $('body').on('keypress', '#input_recomendacoes', function () {



        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {

            var recomendacao_lista = $(this).parents(".comment-input").find("input").val();
            var $new_comment;
            if (recomendacao_lista && recomendacao_lista !== "undefined") {



                $(this).parents('.enderecos-cliente').find(".comments").append('<div data-value="' + recomendacao_lista + '" class="alert alert-warning alert-dismissible fade show lista_recomendacoes" role="alert">' + recomendacao_lista + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                if ($(this).parents(".comment-input").find("input").val() !== "") {



                    valor_atual = $(this).parents('.enderecos-cliente').find('input#input_recomendacoes').val();
                    valor_atual = (valor_atual && valor_atual != 'undefined' ? valor_atual : '');
                    if (valor_atual) {



                        ids = $(this).parents('.enderecos-cliente').find('.comments').find('input').val();
                        $(this).parents('.enderecos-cliente').find('.comments').find('input').val((ids ? ids + ';' + valor_atual : valor_atual));
                    }





                    $(this).parents(".comment-input").find("input").val('');
                }



            } else {



// inserir um alerta bonito posteriormente



            }

            return false;
        }





    });
    $('.alert').alert();
    /*    $('#os_add-endereco').on('click', function () {



     titulo = 'Informações de Endereço';
     conteudo = '\

     <div class="modal-body">\

     <div class="row">\

     <div id="cliente-box-endereco" class="col-12">\

     <div class="row enderecos-cliente" style="position: relative;">\

     <div class="col-12 col-md-3 mt-2 mb-2">\

     <label class="form-labels">Nome do Local</label>\

     <input name="enderecos[0][dono_da_casa]" class="form-control" type="text" value="">\

     </div>\

     <div class="col-12 col-md-3 mt-2 mb-2">\

     <label class="form-labels">CEP <span style="color: red;">*</span></label>\

     <input id="cep" name="enderecos[0][cep]" class="form-control cep" type="text" value="" required="">\

     </div>\

     <div class="col-12 col-md-6 mt-2 mb-2">\

     <label class="form-labels">Endereço</label>\

     <input id="endereco" name="enderecos[0][endereco]" class="form-control endereco" type="text" value="">\

     </div>\

     <div class="col-12 col-md-4 mt-2 mb-2">\

     <label class="form-labels">Complemento</label>\

     <input name="enderecos[0][complemento]" class="form-control complemento" type="text" value="">\

     </div>\

     <div class="col-12 col-md-4 mt-2 mb-2">\

     <label class="form-labels">Número</label>\

     <input name="enderecos[0][numero]" class="form-control numero" type="text" value="">\

     </div>\

     <div class="col-12 col-md-4 mt-2 mb-2">\

     <label class="form-labels">Bairro</label>\

     <input id="bairro" name="enderecos[0][bairro]" class="form-control bairro" type="text" value="">\

     </div>\

     <div class="col-12 col-md-3 mt-2 mb-2">\

     <label class="form-labels">Estado</label>\

     <select id="uf" name="enderecos[0][estado]" class="form-control estado">\

     <option value="AC">Acre</option>\

     <option value="AL">Alagoas</option>\

     <option value="AP">Amapá</option>\

     <option value="AM">Amazonas</option>\

     <option value="BA">Bahia</option>\

     <option value="CE">Ceará</option>\

     <option value="DF">Distrito Federal</option>\

     <option value="ES">Espírito Santo</option>\

     <option value="GO">Goiás</option>\

     <option value="MA">Maranhão</option>\

     <option value="MT">Mato Grosso</option>\

     <option value="MS">Mato Grosso do Sul</option>\

     <option value="MG">Minas Gerais</option>\

     <option value="PA">Pará</option>\

     <option value="PB">Paraíba</option>\

     <option value="PR">Paraná</option>\

     <option value="PE">Pernambuco</option>\

     <option value="PI">Piauí</option>\

     <option value="RJ">Rio de Janeiro</option>\

     <option value="RN">Rio Grande do Norte</option>\

     <option value="RS">Rio Grande do Sul</option>\

     <option value="RO">Rondônia</option>\

     <option value="RR">Roraima</option>\

     <option value="SC">Santa Catarina</option>\

     <option value="SP">São Paulo</option>\

     <option value="SE">Sergipe</option>\

     <option value="TO">Tocantins</option>\

     </select>\

     </div>\

     <div class="col-12 col-md-3 mt-2 mb-2">\

     <label class="form-labels">Cidade</label>\

     <input id="cidade" name="enderecos[0][cidade]" class="form-control cidade" type="text" value="">\

     </div>\

     <div class="col-12 col-md-3 mt-2 mb-2">\

     <label class="form-labels">Ponto de referência</label>\

     <input name="enderecos[0][referencia]" class="form-control" type="text" value="">\

     </div>\

     <div class="col-12 col-md-3 mt-2 mb-2">\

     <label class="form-labels">Meios de Condução</label>\

     <input name="enderecos[0][como_chegar]" class="form-control" type="text" value="">\

     </div>\

     <div class="col-10 mt-2 mb-2 comment-input">\

     <label class="form-labels">Recomendações Recorrentes</label>\

     <input id="input_recomendacoes" name="" class="form-control" type="text" value="">\

     <button type="button" id="btn_recomendacoes" class=" btn_recomendacoes btn btn-warning btn-sm btn-icon btn-circle" style="position: absolute; right: -30px; top: 29px; cursor: pointer;"><i class="fa fa-plus text-white"></i></button>\

     </div>\

     <div class="comments-section comments col-12 mt-3">\

     <input id="resultadoRecomendacoes" type="hidden" name="enderecos[0][recomendacoes]" value="">\

     </div>\

     </div>\

     </div>\

     </div>\

     </div>\

     ';





     modal(titulo, conteudo, campos = 'none', "$(this).parents('form').submit();", 'Adicionar Novo', '', id_form = 'os_add-endereco', class_form = 'form-ajax', action_form = base_url + 'ajax/clientes-endereco/?action=insert');



     });*/





    $('body').on('click', '.modal-content', function () {
		return false;
	});
    $('body').on('click', '.fechar-modal, .modal-header .close', function () {

        var modal = $(this);
        //console.log('remover1');
		modal.parents('.modal').remove();
		$('.modal-backdrop').remove();
		parar_verificacao();
		if( atualizar_pagina === true ){
			location.reload();
		}

        window.setTimeout(function () {

            /*modal.parents('.modal').remove();
            $('.modal-backdrop').remove();*/
        }, 900);
    })

    $('body').on('click', '.modal', function () {

        var modal = $(this);
        //console.log('remover2');
		
		modal.remove();
		$('.modal-backdrop').remove();
		parar_verificacao();
		if( atualizar_pagina === true ){
			location.reload();
		}

        window.setTimeout(function () {

            /*if (nome.css('display') == 'none') {

                $('.modal').remove();
                $('.modal-backdrop').remove();
            }*/

        }, 900);
    })





// função de deixar fechado o menu no mobile

    function sizeOfThings() {

        //Obter a largura total da sua janela (navegador)

        var windowWidth = window.innerWidth;
        var windowHeight = window.innerHeight;
        if (windowWidth <= 769) {

            $(".botao-menu-topo").toggleClass("toggled");
            if ($(".botao-menu-topo").hasClass("toggled")) {

                $("#wrapper").addClass("toggled");
                $(".header-logo").addClass('d-none');
            } else {

                $("#wrapper").removeClass("toggled");
            }

        }





    }

    ;
    sizeOfThings();
    window.addEventListener('resize', function () {

        //sizeOfThings();

    });
    /*$('body').on('click','sidebar-nav, .accordion',function(){



     setCookie("menu_lateral_" + user_id, 'true', 365);
     })*/





    function setCookie(cname, cvalue, exdays) {

        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }



    function getCookie(cname) {

        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {

            var c = ca[i];
            while (c.charAt(0) == ' ') {

                c = c.substring(1);
            }

            if (c.indexOf(name) == 0) {

                return c.substring(name.length, c.length);
            }

        }

        return "";
    }



    /*

     function checkCookie() {

     var user = getCookie("username");
     if (user != "") {

     alert("Welcome again " + user);
     } else {

     user = prompt("Please enter your name:", "");
     if (user != "" && user != null) {

     setCookie("username", user, 365);
     }

     }

     }*/



// padrão menu aberto, alterar para true caso fechado

//$(".botao-menu-topo").removeClass("toggled");



    if ($("#wrapper").hasClass("toggled")) {

        $(".header-logo").addClass('d-none');
    }



    $("#menu-toggle").click(function (e) {

        e.preventDefault();
        $("#wrapper, #topo-wrapper").toggleClass("toggled");
        if ($("#wrapper").hasClass("toggled")) {

            $(".botao-menu-topo").addClass("toggled");
            $(".header-logo").addClass('d-none');
            setCookie("menu_lateral_" + user_id, 'true', 365);
        } else {

            $(".botao-menu-topo").removeClass("toggled");
            $(".header-logo").removeClass('d-none');
            setCookie("menu_lateral_" + user_id, 'false', 365);
        }





    });
    $('.foto_editar').find('.excluir-imagem').click(function () {

        name = $(this).parents('.form-group').find('input[type=hidden]').attr('name');
        $('<input type="file" name="' + name + '" id="' + name + '" />').insertAfter($(this).parent());
        $(this).parent().remove();
        alert('tem que aqjustar ainda');
    });
    $("form#importar-csv").on("submit", function (event) {

        var form = $(this);
        var data = new FormData(this);
        $.ajax({

            url: base_url + 'ajax/ler_csv/',
            method: 'POST',
            dataType: 'html',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            async: false,
            beforeSend: function () {

                $('body').append(loading);
            },
            complete: function (data) {

                campo = '<input type="hidden" name="acao" value="insert" >';
                conteudo = campo + data.responseText;
                titulo = ($('#import_csv').val() ? 'Preview - ' + $('#import_csv')[0].files[0]['name'] : '<span class="text-danger">Nenhum arquivo selecionado!</span>');
                modal(titulo, conteudo, campos = 'false', "$(this).parents('form').submit();", 'Confirmar', 'Carregar outro arquivo', id_form = 'form-importar-confirmar');
                if (conteudo.indexOf('erro_campo') > -1) {

                    $('#form-importar-confirmar button.btn-primary').attr('disabled', 'disabled').css({

                        'opacity': '0.2',
                        'cursor': 'not-allowed'

                    });
                }



                $('#import_csv').clone().appendTo("#form-importar-confirmar").css('visibility', 'hidden');
                $('.loading').fadeOut();
                window.setTimeout(function () {

                    $('.loading').remove();
                }, 1000);
            },
            xhr: function () {  // Custom XMLHttpRequest

                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload

                    myXhr.upload.addEventListener('progress', function () {

                        /* faz alguma coisa durante o progresso do upload */

                    }, false);
                }

                return myXhr;
            }



        })

        event.preventDefault();
    });
    $("body").on("submit", "#form-importar-confirmar", function (event) {

        var form = $(this);
        var data = new FormData(this);
        $.ajax({

            url: base_url + 'ajax/ler_csv/',
            method: 'POST',
            dataType: 'html',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            async: false,
            beforeSend: function () {

                $('body').append(loading);
            },
            complete: function (data) {

                conteudo = data.responseText;
                modal(titulo = 'Importação Concluída', conteudo = conteudo, campos = 'false', funcao = '', botao1 = 'false', botao2 = 'Fechar');
                $('.loading').fadeOut();
                window.setTimeout(function () {

                    $('.loading').remove();
                }, 1000);
            },
            xhr: function () {  // Custom XMLHttpRequest

                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload

                    myXhr.upload.addEventListener('progress', function () {

                        /* faz alguma coisa durante o progresso do upload */

                    }, false);
                }

                return myXhr;
            }



        })

        event.preventDefault();
    });
    $("form#lista-emails").on("submit", function (event) {

        var form = $(this);
        var data = new FormData(this);
        $.ajax({

            url: base_url + 'ajax/ler_csv/',
            method: 'POST',
            dataType: 'html',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            async: false,
            beforeSend: function () {

                $('body').append(loading);
            },
            complete: function (data) {

                campo = '<input type="hidden" name="acao" value="insert" >';
                conteudo = campo + data.responseText;
                titulo = 'Preview - Lista de Emails';
                modal(titulo, conteudo, campos = 'false', "$(this).parents('form').submit();", 'Confirmar', 'Carregar outro arquivo', id_form = 'form-importar-confirmar');
                if (conteudo.indexOf('erro_campo') > -1) {

                    $('#form-importar-confirmar button.btn-primary').attr('disabled', 'disabled').css({

                        'opacity': '0.2',
                        'cursor': 'not-allowed'

                    });
                }



                $('#lista_emails').clone().appendTo("#form-importar-confirmar").css('visibility', 'hidden');
                $('.loading').fadeOut();
                window.setTimeout(function () {

                    $('.loading').remove();
                }, 1000);
            },
            xhr: function () {  // Custom XMLHttpRequest

                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload

                    myXhr.upload.addEventListener('progress', function () {

                        /* faz alguma coisa durante o progresso do upload */

                    }, false);
                }

                return myXhr;
            }



        })

        event.preventDefault();
    });
    $("body").on("click", ".detalhes-media", function (event) {

        var campos = $(this).attr('data-campos');
        var campos = campos.split(",");
        var dados = $(this).attr('data-dados');
        var dados = dados.split(",");
        var inputs_text = '';
        var selects = '';
        var form = '';
        $.each(campos, function (index, value) {

            if (value) {

                titulo_campo = value.replace('_', ' ').toUpperCase();
                disabled = '';
                if (value == 'name' || value == 'path' || value == 'date_create' || value == 'id') {

                    disabled = 'disabled';
                }

                if (value == 'category_id') {

                    select_html = $('.' + value).html();
                    selects = '<div class="form-group"><label for="' + value + '">' + titulo_campo + '</label>';
                    selects += '<select id="' + value + '" class="form-control" ' + disabled + '>';
                    selects += select_html;
//							selects += '<option value="1">Campanhas</option>';

//							selects += '<option value="2">Depoimentos</option>';

                    selects += '</select></div>';
                    form += '<div class="col-6">' + selects + '</div>';
                } else {

                    inputs_text = '<div class="form-group">';
                    inputs_text += '<label for="' + value + '">' + titulo_campo + '</label>';
                    inputs_text += '<input ' + disabled + ' class="form-control" type="text" value="' + dados[index] + '" name="' + value + ' id="' + value + '" />';
                    inputs_text += '</div>';
                    form += '<div class="col-6">' + inputs_text + '</div>';
                    //console.log(value+' ----- '+dados[index]);

                }

            }

        })



        //form = '<form>'+form+'</form>';

        conteudo = '<div class="container-fluid"><div class="row"><div class="col-md-6"><img style="max-width: 100%; display: block; margin: auto;" src="' + $(this).attr('detalhe-path') + $(this).attr('detalhe-name') + '" /></div><div class="col-md-6"><div class="row">' + form + '</div></div></div></div>';
        titulo = 'Editando Media - ' + $(this).attr('detalhe-name');
        modal(titulo, conteudo, campos = '', funcao = '', botao1 = 'Salvar Edição', botao2 = 'Deletar Imagem', id_form = 'detalhes-media');
        return false;
        event.preventDefault();
    });
    $('body').on('click', '.ena_disa', function () {

        var botao = $(this).is(":checked");
        console.log(botao);
        $.each($(this).attr('data-campos-id').split(','), function (index, value) {

            if (botao == true) {

                $('#' + value).prop('disabled', true);
            } else {

                $('#' + value).prop('disabled', false);
            }

        })

    })



    $('.ena_disa').each(function () {

        var botao = $(this).is(":checked");
        console.log(botao);
        $.each($(this).attr('data-campos-id').split(','), function (index, value) {

            if (botao == true) {

                $('#' + value).prop('disabled', true);
            } else {

                $('#' + value).prop('disabled', false);
            }

        })

    })





    $('#buscar_media').submit(function (e) {



        e.preventDefault();
    })



    $('body').on('blur focus click keyup', 'input#buscar', function (e) {

        var ids_titulo = new Array();
        var ids_item = new Array();
        var contagem = 0;
        $('.item-grid').each(function () {

            name = $(this).attr('detalhe-name').toLowerCase();
            category = $(this).attr('detalhe-category').toLowerCase();
            item = jQuery(this);
            id_item = jQuery(this);
            var text = jQuery('#buscar').val();
            var text_busca = (text ? text.toLowerCase() : "");
            letras_titulo = "";
            for (i = 0; i < text_busca.length; i++) {

                letras_titulo += category.charAt(i);
                //console.log(letras_titulo);

            }



            letras_nome = "";
            for (i = 0; i < text_busca.length; i++) {

                letras_nome += name.charAt(i);
                //console.log(letras_nome);

            }



            contagem++;
            if (~text_busca.indexOf(letras_titulo) && ~text_busca.indexOf(letras_nome)) {

                ids_item[contagem] = id_item;
                ids_titulo[contagem] = id_item;
            } else if (~text_busca.indexOf(letras_nome)) {

                ids_item[contagem] = id_item;
                ids_titulo[contagem] = id_item;
            } else if (~text_busca.indexOf(letras_titulo)) {

                ids_item[contagem] = id_item;
                ids_titulo[contagem] = id_item;
            }



            item.removeClass("item_ativo");
            if (text_busca != "" || (ids_item.length >= 1 && text_busca != "")) {





                jQuery.each(ids_item, function (i, val) {

                    console.log(val);
                    $("#" + val).css("display", "none");
                })



            } else {



                $('.item-grid').css('display', 'block');
            }





        })



        return false;
    })





    $("body").on('click', '.border-select', function () {



        if ($(this).hasClass('border-none')) {

            $(this).addClass('border-1px');
            $(this).removeClass('border-none');
        } else {

            $(this).removeClass('border-1px');
            $(this).addClass('border-none');
        }



    });


	$( "body" ).on("click",".gerenciador-de-medias", function( e ) {
		  button_gerenciar_medias = $(this);
		  container_imagens_familias = $(this).parents('.container-imagens-familias');
			e.preventDefault();
			var media_categorias;
			$.ajax({
				url: base_url+'ajax/return_dados/?tipo=admin_medias_categorys&tabela=admin_medias_categorys&campos=id,name',
				method: 'POST',
				dataType: 'json',
				method: 'POST',
				async: false,
				success: function(data){
					media_categorias = data.data;
				}
			});


			//var campos = $(this).attr('data-campos');
			//var campos = campos.split(",");

			//var dados = $(this).attr('data-dados');
			//var dados = dados.split(",");

			var inputs_text = '';
			var selects = '';
			var form = '';

			var campos = 'name,title,description,category_id';
			var campos = campos.split(",");

			var dados = ',,,';
			var dados = dados.split(",");

			var select_html = '<option>Selecione</option>';
			$.each(media_categorias,function(index,value){
				select_html += '<option value="'+value[0]+'">'+value[1]+'</option>';
			});

			$.each(campos,function(index,value){
				if( value ){
					titulo_campo = value.replace('_',' ').toUpperCase();
					disabled = '';
					if( value == 'name' || value == 'path' || value == 'date_create' || value == 'id' ){
						disabled = 'disabled';
					}
					if( value == 'category_id' ){

						selects = '<div class="form-group"><label for="'+value+'">'+titulo_campo+'</label>';
						selects += '<select id="'+value+'" name="'+value+'" class="form-control" '+disabled+'>';
							selects += select_html;
//							selects += '<option value="1">Campanhas</option>';
//							selects += '<option value="2">Depoimentos</option>';
						selects += '</select></div>';
						form += '<div class="col-md-6">'+selects+'</div>';
					}else{
						inputs_text = '<div class="form-group">';
							inputs_text += '<label for="'+value+'">'+titulo_campo+'</label>';
							inputs_text += '<input '+disabled+' class="form-control" type="text" value="'+dados[index]+'" name="'+value+'" id="'+value+'" />';
						inputs_text += '</div>';
						form += '<div class="col-md-6">'+inputs_text+'</div>';
						//console.log(value+' ----- '+dados[index]);
					}
				}
			})




			var imagens = '';
			var input_ids_medias = $(this).attr('input-ids-medias');
			var ids = $('input[name='+input_ids_medias+']').val();

			if( ids && ids != 'undefined' ){
			   ids = ids.split(',');
			}

		console.log($('input[name='+input_ids_medias+']').val());

			$.ajax({
				url: base_url+'ajax/return_dados/?tipo=admin_medias&tabela=admin_medias&campos=id,path,name,category_id,title',
				dataType: 'JSON',
				async: false,
				success: function(resposta){
					$.each(resposta.data,function(index,value){
						borda = ( ids && ids != 'undefine' && ids.indexOf(value[0]) !== -1 ? 'border: 8px solid #007bff;' : '');
						imagens += '<div class="col-6 col-md-2 mt-3 mb-3 imagem-media-content" data-name="'+( value[4] ? value[4] : value[2] )+'" input-ids-medias="'+button_gerenciar_medias.attr('input-ids-medias')+'" data-url="'+base_url+value[1]+value[2]+'" data-id="'+value[0]+'" data-category-id="'+value[3]+'"><img class="border-select border-none" src="'+base_url+value[1]+value[2]+'" data-id="'+value[0]+'" style="width: 100%; cursor: pointer; '+borda+'"></div>';
					});
				},
				error: function(){

				}
			});
			//console.log(imagens);


			var detail = button_gerenciar_medias.attr("data-detail");

			//form = '<form>'+form+'</form>';
			conteudo = '<div class="tab-content container-fluid" id="nav-tabContent"><div class="tab-pane fade show active row" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"><div class="col-12"><div class="row"><div class="col-md-'+( detail == 'disabled' ? '12' : '6' )+' upload-image"><input id="media_upload" preview-input="media_upload" preview-img="imagem-preview-modal" preview-placeholder="placeholder-preview-modal" type="file" name="media_upload" style="width: 0; height: 0; position: absolute;"><div onclick="$(this).prev().click();" style="display: table; cursor: pointer; width: 100%; border-radius: 10px; background: #ededed;  margin: auto; min-height: 300px;"><img class="imagem-preview d-none" id="imagem-preview-modal" src="#" style="width: 100%;margin: auto; height: auto;"><span class="remover-span" style="font-size: 20px; color: #888; display: table-cell; text-align: center; margin: auto; vertical-align: middle;" id="placeholder-preview-modal">CLIQUE AQUI PARA<br>CARREGAR A IMAGEM</span></div></div><div class="col-md-6 detail" '+( detail == 'disabled' ? 'style="position: absolute; width: 0; height: 0; overflow: hidden; opacity: 0;"' : '' )+' ><div class="row">'+form+'</div></div></div></div></div><div class="tab-pane fade row" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">\
			<div class="col-12"><select id="category-medias">\
				'+select_html+'\
			</select></div>\
			<div class="row pb-3 pt-3 text-left m-auto mt-3 content-medias-modal">\
			'+imagens+'\
			</div></div> </div>';

			titulo = 'Gerenciador de Medias<br><br><nav><div class="nav nav-tabs" id="nav-tab" role="tablist"><a class="nav-item nav-link active tab-medias" data-id="upload" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Upload</a><a class="nav-item nav-link tab-medias" data-id="galeria" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Galeria</a></div></nav>';

			//modal(titulo,conteudo,campos='',funcao='',botao1='Salvar Edição',botao2='Deletar Imagem',id_form='detalhes-media');
			modal(titulo,conteudo,campos='',funcao="$(this).parents('form').submit();",botao1='Confirmar',false,id_form='gerenciador-de-medias','','',largura_modal='600px');

			var category_default = button_gerenciar_medias.attr("data-category-default");
			var disable_area = button_gerenciar_medias.attr("data-disable-area");
			var active_area = button_gerenciar_medias.attr("data-active-area");

			$('.tab-medias').each(function(){
				if( $(this).attr('data-id') == disable_area ){
				   $(this).removeClass('active');
				   $(this).attr('aria-selected','false');
				   $(this).addClass('d-none');
				}
			})

			$('.tab-medias').each(function(){
				if( $(this).attr('data-id') == active_area ){
				   $(this).click();
				}
			})

			if( category_default && category_default != 'undefined' ){
				$('#category-medias').val(category_default);
				$('#category-medias').prop('disabled',true);
				var categoria = $('#category-medias').val();
				$(".content-medias-modal > div").each(function(){
					if( $(this).attr('data-category-id') == categoria ){
					   $(this).removeClass('d-none');
					}else{
					   $(this).addClass('d-none');
					}
				})
			}

			if( category_default && category_default != 'undefined' ){
				$('#category_id').val(category_default);
				$('#category_id').insertAfter('<input type="hidden" name="category_id" value="'+category_default+'">');
				$('#category_id').prop('disabled',true);
			}



		});

		$('body').on('change','#media_upload',function(){
			preview_input = "media_upload";
			preview_img = "imagem-preview-modal";
			preview_placeholder = "placeholder-preview-modal";
			PreviewImage( preview_input, preview_img, preview_placeholder );
		})


    $('body').on('click', '.container-imagens-familias .imagem-media > img', function (e) {



        var imagem = $(this).attr('src');
        var id_elemento = $(this).attr('data-id');
        var info_elemento = '';
        $.ajax({

            url: base_url + 'ajax/return_dados/?tabela=elementos&tipo=elementos&id_elemento=' + id_elemento,
            async: false,
            dataType: 'json',
            success: function (resposta) {

                info_elemento = resposta['data'];
                info_elemento = (info_elemento.length > 0 ? info_elemento[0] : info_elemento);
            },
            error: function () {



            }

        });
        console.log(info_elemento);
        console.log(info_elemento.length);
        var action = (info_elemento.length > 0 && info_elemento[0] ? 'update' : 'insert');
        //form = '<form>'+form+'</form>';

        titulo = 'Configurações do elemento';
        conteudo = '\
                <div class="row col-12 text-center mt-3 m-auto">\
    <div class="col-12 col-md-6 mob-min-height">\
        <div class="mt-5 mb-3" style="min-height: 300px;">\
            <div id="container-image-preview" class="m-auto" data-category-default="" data-disable-area="galeria" data-active-area="upload" style="width: 100%; min-height: 300px; background: rgba(0,123,255,0.43); position: relative;" >\
                <img id="imagem-preview" src="' + imagem + '" style="width: 100%; position: relative; left: 0; z-index: 2;">\
            </div>\
        </div>\
        <input value="' + id_elemento + '" type="hidden" name="elemento_id">\
        ' + (info_elemento.length > 0 && info_elemento[0] ? '<input value="' + info_elemento[0] + '" type="hidden" name="id">' : '') + '\
        <div class="mt-5 mb-3 row m-auto" style="margin-top: 50px !important;">\
            <div class="col-12 mt-5 text-left">\
                <label><b>Escolha as posições para o texto:</b></label>\
            </div>\
            <div class="col-12 row">\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="txt_1" value="' + (info_elemento.length > 0 ? info_elemento['txt_1'] : '') + '" type="checkbox" class="custom-control-input" id="defaultInline1" ' + (info_elemento.length > 0 && info_elemento['txt_1'] ? 'checked' : '') + ' >\
                        <label class="custom-control-label" for="defaultInline1"></label>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="txt_2" value="' + (info_elemento.length > 0 ? info_elemento['txt_2'] : '') + '" type="checkbox" class="custom-control-input" id="defaultInline2" ' + (info_elemento.length > 0 ? 'checked' : '') + ' >\
                        <label class="custom-control-label" for="defaultInline2"></label>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="txt_3" value="' + (info_elemento.length > 0 ? info_elemento['txt_3'] : '') + '" type="checkbox" class="custom-control-input" id="defaultInline3" ' + (info_elemento.length > 0 ? 'checked' : '') + '>\
                        <label class="custom-control-label" for="defaultInline3"></label>\
                    </div>\
                </div>\
            </div>\
            <div class="col-12 row">\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="txt_4" value="' + (info_elemento.length > 0 ? info_elemento['txt_4'] : '') + '" type="checkbox" class="custom-control-input" id="defaultInline4" ' + (info_elemento.length > 0 ? 'checked' : '') + '>\
                        <label class="custom-control-label" for="defaultInline4"></label>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="txt_5" value="' + (info_elemento ? info_elemento['txt_5'] : '') + '" type="checkbox" class="custom-control-input" id="defaultInline5" ' + (info_elemento ? 'checked' : '') + '>\
                        <label class="custom-control-label" for="defaultInline5"></label>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="txt_6" value="' + (info_elemento.length > 0 ? info_elemento['txt_6'] : '') + '" type="checkbox" class="custom-control-input" id="defaultInline6" ' + (info_elemento.length > 0 ? 'checked' : '') + '>\
                        <label class="custom-control-label" for="defaultInline6"></label>\
                    </div>\
                </div>\
            </div>\
            <div class="col-12 row">\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="txt_7" value="' + (info_elemento.length > 0 ? info_elemento['txt_7'] : '') + '" type="checkbox" class="custom-control-input" id="defaultInline7" ' + (info_elemento.length > 0 ? 'checked' : '') + '>\
                        <label class="custom-control-label" for="defaultInline7"></label>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="txt_8" value="' + (info_elemento ? info_elemento['txt_8'] : '') + '" type="checkbox" class="custom-control-input" id="defaultInline8" ' + (info_elemento ? 'checked' : '') + '>\
                        <label class="custom-control-label" for="defaultInline8"></label>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="txt_9" value="' + (info_elemento.length > 0 ? info_elemento['txt_9'] : '') + '" type="checkbox" class="custom-control-input" id="defaultInline9" ' + (info_elemento.length > 0 ? 'checked' : '') + '>\
                        <label class="custom-control-label" for="defaultInline9"></label>\
                    </div>\
                </div>\
            </div>\
        </div>\
    </div>\
    <div class="col-12 col-md-6">\
        <div class="mt-3 mb-3 row" style="height: 330px;">\
            <div class="col-12 text-left">\
                <label><b>Informe as tonalidades de cada área:</b></label>\
            </div>\
            <div class="col-12 row pl-pf-0" style="height: 300px;">\
                <div class="col-4">\
                    <div class="row quadrado-tonalidade" style="background: rgba(0,123,255,0.43); height: 5rem; width: 6rem;">\
                        <div class="col-12 m-auto">\
                            <div class="form-check text-left">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_1" value="cor_1_claro">Claro</label>\
                            </div>\
                            <div class="form-check">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_1" value="cor_1_escuro">Escuro</label>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="row quadrado-tonalidade" style="background: rgba(0,123,255,0.43); height: 5rem; width: 6rem;">\
                        <div class="col-12 m-auto">\
                            <div class="form-check text-left">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_2" value="cor_2_claro">Claro</label>\
                            </div>\
                            <div class="form-check">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_2" value="cor_2_escuro">Escuro</label>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="row quadrado-tonalidade" style="background: rgba(0,123,255,0.43); height: 5rem; width: 6rem;">\
                        <div class="col-12 m-auto">\
                            <div class="form-check text-left">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_3" value="cor_3_claro">Claro</label>\
                            </div>\
                            <div class="form-check">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_3" value="cor_3_escuro">Escuro</label>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="row quadrado-tonalidade" style="background: rgba(0,123,255,0.43); height: 5rem; width: 6rem;">\
                        <div class="col-12 m-auto">\
                            <div class="form-check text-left">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_4" value="cor_4_claro">Claro</label>\
                            </div>\
                            <div class="form-check">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_4" value="cor_4_escuro">Escuro</label>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="row quadrado-tonalidade" style="background: rgba(0,123,255,0.43); height: 5rem; width: 6rem;">\
                        <div class="col-12 m-auto">\
                            <div class="form-check text-left">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_5" value="cor_5_claro">Claro</label>\
                            </div>\
                            <div class="form-check">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_5" value="cor_5_escuro">Escuro</label>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="row quadrado-tonalidade" style="background: rgba(0,123,255,0.43); height: 5rem; width: 6rem;">\
                        <div class="col-12 m-auto">\
                            <div class="form-check text-left">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_6" value="cor_6_claro">Claro</label>\
                            </div>\
                            <div class="form-check">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_6" value="cor_6_escuro">Escuro</label>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="row quadrado-tonalidade" style="background: rgba(0,123,255,0.43); height: 5rem; width: 6rem;">\
                        <div class="col-12 m-auto">\
                            <div class="form-check text-left">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_7" value="cor_7_claro">Claro</label>\
                            </div>\
                            <div class="form-check">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_7" value="cor_7_escuro">Escuro</label>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="row quadrado-tonalidade" style="background: rgba(0,123,255,0.43); height: 5rem; width: 6rem;">\
                        <div class="col-12 m-auto">\
                            <div class="form-check text-left">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_8" value="cor_8_claro">Claro</label>\
                            </div>\
                            <div class="form-check">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_8" value="cor_8_escuro">Escuro</label>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="row quadrado-tonalidade" style="background: rgba(0,123,255,0.43); height: 5rem; width: 6rem;">\
                        <div class="col-12 m-auto">\
                            <div class="form-check text-left">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_9" value="cor_9_claro">Claro</label>\
                            </div>\
                            <div class="form-check">\
                                <label class="form-check-label">\
                                    <input type="radio" class="form-check-input" name="pos_9" value="cor_9_escuro">Escuro</label>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </div>\
        </div>\
        <div class="mt-5 mb-3 row m-auto mt-mob-0">\
            <div class="col-12 mt-5 text-left">\
                <label><b>Escolha as posições para o logotipo:</b></label>\
            </div>\
            <div class="col-12 row">\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="logo_1" value="' + (info_elemento.length > 0 && info_elemento['logo_1'] ? info_elemento['logo_1'] : '') + '" type="checkbox" class="custom-control-input" id="logo1">\
                        <label class="custom-control-label" for="logo1"></label>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="logo_2" value="' + (info_elemento.length > 0 && info_elemento['logo_2'] ? info_elemento['logo_2'] : '') + '" type="checkbox" class="custom-control-input" id="logo2">\
                        <label class="custom-control-label" for="logo2"></label>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="logo_3" value="' + (info_elemento.length > 0 && info_elemento['logo_3'] ? info_elemento['logo_3'] : '') + '" type="checkbox" class="custom-control-input" id="logo3">\
                        <label class="custom-control-label" for="logo3"></label>\
                    </div>\
                </div>\
            </div>\
            <div class="col-12 row">\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="logo_4" value="' + (info_elemento.length > 0 && info_elemento['logo_4'] ? info_elemento['logo_4'] : '') + '" type="checkbox" class="custom-control-input" id="logo4">\
                        <label class="custom-control-label" for="logo4"></label>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="logo_5" value="' + (info_elemento.length > 0 && info_elemento['logo_5'] ? info_elemento['logo_5'] : '') + '" type="checkbox" class="custom-control-input" id="logo5">\
                        <label class="custom-control-label" for="logo5"></label>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="logo_6" value="' + (info_elemento.length > 0 && info_elemento['logo_6'] ? info_elemento['logo_6'] : '') + '" type="checkbox" class="custom-control-input" id="logo6">\
                        <label class="custom-control-label" for="logo6"></label>\
                    </div>\
                </div>\
            </div>\
            <div class="col-12 row">\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="logo_7" value="' + (info_elemento.length > 0 ? info_elemento['logo_7'] : '') + '" type="checkbox" class="custom-control-input" id="logo7">\
                        <label class="custom-control-label" for="logo7"></label>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="logo_8" value="' + (info_elemento.length > 0 ? info_elemento['logo_8'] : '') + '" type="checkbox" class="custom-control-input" id="logo8">\
                        <label class="custom-control-label" for="logo8"></label>\
                    </div>\
                </div>\
                <div class="col-4">\
                    <div class="custom-control custom-checkbox custom-control-inline">\
                        <input name="logo_9" value="' + (info_elemento.length > 0 ? info_elemento['logo_9'] : '') + '" type="checkbox" class="custom-control-input" id="logo9">\
                        <label class="custom-control-label" for="logo9"></label>\
                    </div>\
                </div>\
            </div>\
        </div>\
    </div>\
</div>\
';
//modal(titulo,conteudo,campos='',funcao='',botao1='Salvar Edição',botao2='Deletar Imagem',id_form='detalhes-media');

        modal(titulo, conteudo, campos = '', funcao = "$(this).parents('form').submit();", botao1 = 'Confirmar', false, id_form = 'config-elemento', '', base_url + 'ajax/elementos/?action=' + action);
    });
    $('body').on('submit', 'form#config-elemento', function (e) {

        var form = $(this);
        var action = $(this).attr('action');
        var dados = new FormData(form[0]);
        $.ajax({

            url: action,
            method: 'POST',
            dataType: 'json',
            data: dados,
            cache: false,
            contentType: false,
            processData: false,
            async: false,
            beforeSend: function () {

                //$('body').append(loading);

            },
            success: function (data) {



                if (data.status == '1') {

                    if (button_gerenciar_medias.next('.id_media').length > 0) {

                        button_gerenciar_medias.next('.id_media').val(data.id);
                    }

                    if (button_gerenciar_medias.find('img').length > 0) {

                        button_gerenciar_medias.find('img').attr('src', base_url + "/" + data.path);
                    }

                    form.parents('.modal').find('.close').submit();
                    //form.parents('#form_modal').find('.fechar-modal').click();

                }



            },
            complete: function (data) {



            }



        })

        e.preventDefault();
        return false;
    })





// config elemento



    $('body').on('click', '.imagem-media-content', function (e) {



        var input_ids = $(this).attr('input-ids-medias');
        var valor = $('input[name=' + input_ids + ']').val();
        var busca = valor.split(',');
        var id_atual = $(this).attr('data-id');
        if (busca.indexOf($(this).attr('data-id')) !== -1) {



            //console.log("simmm");

            container_imagens_familias.find('.imagem-media').each(function () {

                if ($(this).find('img').attr('data-id') == id_atual) {

                    $(this).remove();
                }

            });
            valor = $('input[name=' + input_ids + ']').val().split(',');
            var novo_valor = '';
            $.each(valor, function (index, value) {

                if (value != id_atual) {

                    novo_valor += (novo_valor ? ',' + value : value);
                }

            })



            $('input[name=' + input_ids + ']').val(novo_valor);
        } else {





            imagem = '<div class="col-md-3 col-6 mt-3 mb-3 imagem-media">' + $(this).html() + "</div>";
            $(imagem).appendTo(container_imagens_familias);
            valor = ($('input[name=' + input_ids + ']').val() ? $('input[name=' + input_ids + ']').val() + ',' + $(this).attr('data-id') : $(this).attr('data-id'));
            $('input[name=' + input_ids + ']').val(valor);
        }





    });
    $('body').on('change', '#category-medias', function (e) {

        var categoria = $('#category-medias').val();
        $(".content-medias-modal > div").each(function () {

            if ($(this).attr('data-category-id') == categoria) {

                $(this).removeClass('d-none');
            } else {

                $(this).addClass('d-none');
            }

        })

    });


    $('body').on('submit', 'form#gerenciador-de-medias', function (e) {

        if ($('.modal .nav-item.active').attr('data-id') != 'upload') {
            $(this).parents('.modal').find('.close').click();
            e.preventDefault();
            return;
        }

        var form = $(this);
        var dados = new FormData(form[0]);
        $.ajax({
            url: base_url + 'ajax/upload/',
            method: 'POST',
            dataType: 'json',
            data: dados,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            async: false,
            beforeSend: function () {
                //$('body').append(loading);
            },
            success: function (data) {
                console.log(data);
                if (data.status == '1') {
                    //console.log('entrou aqui');
                    if (button_gerenciar_medias.next('.id_media').length > 0) {
                        button_gerenciar_medias.next('.id_media').val(data.id);
                    }
                    if (button_gerenciar_medias.find('img').length > 0) {
                        //button_gerenciar_medias.find('img').attr('src', base_url + "/" + data.path);
                        button_gerenciar_medias.find('img').attr('src', '#');
                        button_gerenciar_medias.find('img').attr('data-teste', 'foi');
                        button_gerenciar_medias.find('img').css('background-image', 'url('+base_url + '/' + data.path + ')');
                        button_gerenciar_medias.find('img').css('background-position', 'center center');
                        button_gerenciar_medias.find('img').css('background-size', 'cover');
                    }

                    if ($("#visualizar-img").length > 0 && $("#visualizar-img").attr("src") != "") {
                        $(".msg-image-preview").addClass('d-none');
                        $(".gerenciador-de-medias").css('background', 'none !important');
                    }

                    form.parents('#form_modal').find('.close').click();

                }
            },
            complete: function (data) {
                /*conteudo = data.responseText;
                 modal(titulo='Importação Concluída',conteudo=conteudo,campos='false',funcao='',botao1='false',botao2='Fechar');
                 $('.loading').fadeOut();
                 window.setTimeout(function(){
                 $('.loading').remove();
                 },1000);*/
            },
            xhr: function () {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function () {
                        //faz alguma coisa durante o progresso do upload
                    }, false);
                }
                return myXhr;
            }

        })
        e.preventDefault();
        return false;
    });



    if ($("#example").length > 0 && $("#example").attr("url")) {

        var url = $("#example").attr("url");
        table = $('#example').DataTable({

            responsive: true,
            "scrollX": true,
            "ajax": {

                "url": url,
                "dataSrc": "data"

            },
            "language": {

                "search": "Buscar",
                "lengthMenu": "Exibir _MENU_ resultados",
                "paginate": {

                    "previous": "Anterior",
                    "next": "Próximo",
                }

            },
            "order": [

                [0, "desc"],
            ],
            "columnDefs": [{

                    "targets": -1,
                    "data": null,
                    "defaultContent": "<a href='#' id='edit' class='editar-item'><i class='material-icons' style='color: dimgrey;'>edit</i></a><a href='#' class='excluir'><i class='material-icons' style='color: red;'>delete</i></a>"

                }]

        });
        $('#example tbody').on('click', '#edit', function () {

            var url = $("#example").attr("button_editar_url");
            var data = table.row($(this).parents('tr')).data();
            //alert(url+"id="+data[0]);

            location.href = url + "id=" + data[0];
            //alert( data[0] +"'s salary is: "+ data[ 5 ] );

        });
        $('#example tbody').on('click', '#ordem_de-servico', function () {

            var url = $("#example").attr("button_ordem_de_servico_url");
            var data = table.row($(this).parents('tr')).data();
            //alert(url+"id="+data[0]);

            location.href = url + "id=" + data[0];
            //alert( data[0] +"'s salary is: "+ data[ 5 ] );

        });
        $('#example tbody').on('click', '.excluir', function () {



            var url = $("#example").attr("button_url_excluir");
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            var id_zendesk = data[1];
            //alert( data[0] +"'s salary is: "+ data[ 5 ] );

            table.row($(this).parents('tr')).remove().draw();
            var r = confirm("Deseja realmente excluir?");
            if (r == true) {

                $.ajax({

                    method: "POST",
                    data: {

                        id: id,
                        id_zendesk: id_zendesk,
                        action: 'delete'

                    },
                    dataType: 'json',
                    url: url,
                    success: function (r) {

                        //console.log(r.status);

                        //alert(r.msg);

                        modal_basic(r.title, r.msg, '#28a745');
                    }

                });
            }



        });
    }





    /*



     $("body").on("click", '.btn_recomendacoes', function () {



     var $new_comment;
     var pegar_input = $("input[type=text][id=input_recomendacoes]").val();
     console.log($("input[type=text][id=input_recomendacoes]").val());
     if ($(".comment-input #input_recomendacoes").val() !== "") {

     $new_comment = $("<p>").text($(".comment-input #input_recomendacoes").val());
     $new_comment.hide();
     $(".comments").append($new_comment);
     $new_comment.fadeIn();
     $(".comment-input input").val("");
     } else {

     alert("Insira um comentário!");
     }



     });





     */





    $('body').on('click', '.excluir_item_familia', function () {



        var id = $(this).attr("data-id");
        var input_remove_id = $(this).attr("input-remove-id");
        ;
        var container = $(this).parents('.col-md-3.col-6.mt-3.mb-3');
        var r = confirm("Deseja realmente excluir?");
        var valor = '';
        console.log($('input[name=' + input_remove_id + ']').val().split(','));
        $.each($('input[name=' + input_remove_id + ']').val().split(','), function (index, value) {

            if (value != id) {

                valor += (valor ? ',' + value : value);
            }

        });
        $('input[name=' + input_remove_id + ']').val(valor);
        container.remove();
    });
    $('body').on('click', '.excluir_item', function () {



        var url = $(this).attr("button_url_excluir");
        var id = $(this).attr("data-id");
        var container = $(this).parents($(this).attr("container"));
        var r = confirm("Deseja realmente excluir?");
        if (r == true) {

            $.ajax({

                method: "POST",
                data: {

                    id: id,
                    action: 'delete'

                },
                dataType: 'json',
                url: url,
                success: function (r) {

                    //console.log(r.status);

                    //alert(r.msg);

                    container.remove();
                    modal_basic(r.title, r.msg, '#28a745');
                }

            });
        }



    });
//ajax dos formulários

    $('body').on('submit', '.form-ajax', function (e) {

        e.preventDefault();
        var form = this;
        var dados = $(this);
        var form_redirect = $(this).attr('redirect');
        var redirect_refresh = $(this).attr('redirect-refresh');
        var url = $(this).attr('action');
        //alert('deu submit');



        window.setTimeout(function () {



            dados = dados.serialize();
            $(form).attr('return', 'true');
            $.ajax({

                url: url,
                method: "POST",
                data: dados,
                dataType: 'json',
                success: function (response) {

                    if (response.status == 'success') {



                        if (response.field == 'cat_cliente') {

                            $('#meio_contato').append('<option value="' + response.id + '">' + response.value + '</option>');
                        }



                        if (response.field == 'endereco') {

                            $('#info_endereco').append('<option class="value-endereco" value="' + response.id + '">' + response.value + '</option>');
                        }



                        if (url.indexOf("insert") != '-1') {

                            $(form).attr('return', 'true');
                            if ($("#estados").length > 0 && $("select#estado").length > 0) {

                                sigla = $("select#estado option:selected").attr('data-sigla');
                                add_campo(response.id, $(form).find('input[name=nome]').val(), sigla);
                            } else if ($("#estados").length > 0) {

                                add_campo(response.id, $(form).find('input[name=nome]').val());
                            }

                            if ($('.numero_perguntas').length > 0) {

                                $('.numero_perguntas').val('').change();
                            }



                            form.reset();
                            if (form_redirect) {



                                location = form_redirect + response.id;
                            }



                        }

                        cor = '#28a745';
                    } else if (response.status === 'alert') {

                        cor = '#FF9800';
                    } else {

                        cor = 'red';
                    }

                    field = '';
                    if (response.type === 'unique') {

                        field = $(form).find('input[name=' + response.field + ']').prev('label').text().replace(':', '') + ' - ';
                    }

                    modal_basic(field + response.title, response.msg, cor);
                },
                error: function (response) {

                    modal_basic(response.title, response.msg, 'red');
                }

            });
        }, 500);
    });
    $('#os_edit-endereco').on('click', function () {

        var id = $('.value-endereco').attr('value');
        console.log('idd-- ' + id);
    });
//ajax do Cliente



    $('body').on('submit', '.form-ajax_cliente', function (e) {



        e.preventDefault();
        var form = this;
        var dados = $(this);
        var form_redirect = $(this).attr('redirect');
        var redirect_refresh = $(this).attr('redirect-refresh');
        var url = $(this).attr('action');
        //alert('deu submit');



        window.setTimeout(function () {



            dados = dados.serialize();
            $(form).attr('return', 'true');
            $.ajax({

                url: url,
                method: "POST",
                data: dados,
                dataType: 'json',
                success: function (response) {

                    if (response.status == 'success') {



                        if (url.indexOf("insert") != '-1') {

                            if ($('#id_cliente').length > 0 && response.id) {

                                $('#id_cliente').val(response.id);
                            }

                            $(form).attr('return', 'true');
                            form.reset();
                            if (form_redirect) {

                                //location = form_redirect + response.id;

                            }



                        }

                        $('.btn_clientes_endereco').click();
                        cor = '#28a745';
                    } else if (response.status === 'alert') {

                        cor = '#FF9800';
                    } else {

                        cor = 'red';
                    }

                    field = '';
                    if (response.type === 'unique') {

                        field = $(form).find('input[name=' + response.field + ']').prev('label').text().replace(':', '') + ' - ';
                    }

                    modal_basic(field + response.title, response.msg, cor);
                },
                error: function (response) {

                    modal_basic(response.title, response.msg, 'red');
                }

            });
        }, 500);
    });
//ajax do Cliente endereco



    $('body').on('submit', '.form-ajax_cliente_endereco', function (e) {

        e.preventDefault();
        var form = this;
        var dados = $(this);
        var form_redirect = $(this).attr('redirect');
        var redirect_refresh = $(this).attr('redirect-refresh');
        var url = $(this).attr('action');
        //alert('deu submit');



        window.setTimeout(function () {



            $.ajax({

                url: $('input[name=enderecos_excluir]').attr('action'),
                method: 'POST',
                data: {excluir: $('input[name=enderecos_excluir]').val(), action: 'delete'},
                success: function (response) {



                }

            })



            dados = dados.serialize();
            $(form).attr('return', 'true');
            $.ajax({

                url: url,
                method: "POST",
                data: dados,
                dataType: 'json',
                async: false,
                success: function (response) {

                    if (response.status == 'success') {



                        if (url.indexOf("insert") != '-1') {

                            $(form).attr('return', 'true');
                            form.reset();
                            if (form_redirect) {

                                //location = form_redirect + response.id;

                            }



                        }

                        cor = '#28a745';
                    } else if (response.status === 'alert') {

                        cor = '#FF9800';
                    } else {

                        cor = 'red';
                    }

                    field = '';
                    if (response.type === 'unique') {

                        field = $(form).find('input[name=' + response.field + ']').prev('label').text().replace(':', '') + ' - ';
                    }

                    modal_basic(field + response.title, response.msg, cor);
                },
                error: function (response) {

                    modal_basic(response.title, response.msg, 'red');
                }

            });
        }, 500);
    });
//add

    $(".btn-addEndereco").click(function () {



        var id_cliente = $(".enderecos-cliente").length;
        html = $("#form-cliente-endereco").html();
        html = html.replace(/@@id@@/g, id_cliente);
        html = html.replace(/@@dono_da_casa@@/g, '');
        html = html.replace(/@@cep@@/g, '');
        html = html.replace(/@@endereco@@/g, '');
        html = html.replace(/@@complemento@@/g, '');
        html = html.replace(/@@numero@@/g, '');
        html = html.replace(/@@bairro@@/g, '');
        html = html.replace(/@@cidade@@/g, '');
        html = html.replace(/@@referencia@@/g, '');
        html = html.replace(/@@como_chegar@@/g, '');
        html = html.replace(/@@recomendacoes@@/g, '');
        html = html.replace(/@@recomendacoes_itens@@/g, '');
        $("#cliente-box-endereco").append("<div class='row enderecos-cliente' style='position: relative;'>" + html + "</div>");
    })

//remove

    $("body").on('click', '.btn-removeEndereco', function () {

        id_atual = $(this).parents('.enderecos-cliente').find('input.id_contato').val();
        id_atual = (id_atual && id_atual != 'undefined' ? id_atual : '');
        if (id_atual) {

            ids = $('input[name=enderecos_excluir]').val();
            $('input[name=enderecos_excluir]').val((ids ? ids + ',' + id_atual : id_atual));
        }

        $(this).parents('.enderecos-cliente').remove();
    });
    $('.form-ajax button[type=submit]').attr('disabled', 'disabled');
    $('.form-ajax :input').change(function () {

        $('.form-ajax button[type=submit]').prop('disabled', false);
    });
    $('.form-ajax :input').keyup(function () {

        $('.form-ajax button[type=submit]').prop('disabled', false);
    });
    if ($(".imagem-preview").length > 0 && $(".imagem-preview").attr("src") != "") {

        $(".msg-image-preview").addClass('d-none');
        $(".gerenciador-de-medias").css('background', 'none');
    }





//MODAL CADASTRAR PROFISSÃO

    $('body').on('click', '.modal-profissao', function () {

        titulo = 'Cadastrar profissão';
        var select_especialidade_dados = '';
        $.ajax({

            url: base_url + 'ajax/return_dados/?tabela=especialidades&tipo=especialidades_admin&campos=id,nome',
            async: false,
            dataType: 'json',
            success: function (resposta) {

                select_especialidade_dados = resposta;
            },
            error: function () {



            }

        });
        var inserir_html = '';
        var select_especialidade_modelo = '<option value="@@id@@">@@nome@@</option>';
        $.each(select_especialidade_dados.data, function (index, value) {

            select = select_especialidade_modelo.replace('@@id@@', value[0]);
            select = select.replace('@@nome@@', value[1]);
            inserir_html += select;
        })



        var select_especialidade = inserir_html;
        //console.log(select_especialidade);



        conteudo = '\
                <div class="row">\
    <div class="col-12 col-md-4">\
        <label>Status</label>\
        <select name="status" class="form-control">\
            <option value="ativo">Ativo</option>\
            <option value="inativo">Inativo</option>\
        </select>\
    </div>\
</div>\
                <div class="row text-left mt-3">\
    <div class="col-12 col-md-6 mt-3">\
        <label>Profissão</label>\
        <input type="text" class="form-control" name="profissao">\
    </div>\
    <div class="col-12 col-md-6 mt-3">\
        <label>Especialidades</label>\
        <select name="especialidade_id[]" class="selectpicker form-control cadastro_profissao" multiple data-live-search="true">\
            ' + select_especialidade + '\
        </select>\
    </div>\
</div>\
';
        modal(titulo, conteudo, campos = 'none', "$(this).parents('form').submit();", 'Salvar', '', id_form = 'modal-profissao', class_form = 'form-ajax', action_form = base_url + 'ajax/profissoes/?action=insert');
    })





//MODAL CADASTRAR Especialidade

    $('body').on('click', '.modal-especialidade', function () {

        titulo = 'Cadastrar especialidade';
        conteudo = '\
                <div class="modal-body">\
    <div class="row">\
        <div class="col-12 col-md-4">\
            <label>Status</label>\
            <select name="status" class="form-control">\
                <option value="ativo">Ativo</option>\
                <option value="inativo">Inativo</option>\
            </select>\
        </div>\
        <div class="col-12 col-md-8">\
            <label>Especialidade</label>\
            <input type="text" class="form-control" name="nome">\
        </div>\
    </div>\
</div>\
';





        modal(titulo, conteudo, campos = 'none', "$(this).parents('form').submit();", 'Salvar', '', id_form = 'modal-especialidade', class_form = 'form-ajax', action_form = base_url + 'ajax/especialidades/?action=insert');



    });





//MODAL CADASTRAR Categoria Cliente

    $('body').on('click', '.modal-contato', function () {

        titulo = 'Meios de Contato';
        conteudo = '\
                <div class="modal-body">\
    <div class="row">\
        <div class="col-4">\
            <label>Nome</label>\
            <input type="text" name="nome" class="form-control">\
        </div>\
        <div class="col-4">\
            <label>Status</label>\
            <select name="status" class="form-control">\
                <option value="ativo">Ativo</option>\
                <option value="inativo">Inativo</option>\
            </select>\
        </div>\
    </div>\
</div>\
';

        modal(titulo, conteudo, campos = 'none', "$(this).parents('form').submit();", 'Salvar', '', id_form = 'modal-contato', class_form = 'form-ajax', action_form = base_url + 'ajax/categoria_cliente/?action=insert');



    });





    $('.checkbox_principal').change(function (event) {

        var container = $(this).parents('ul');
        if ($(this).prop('checked')) {

            if (click != 'check') {

                container.find(".checkbox1").each(function () {

                    $(this).prop('checked', true);
                });
            } else {

                verifica = 0;
                container.find(".checkbox1").each(function () {

                    if ($(this).prop('checked')) {

                        verifica++;
                    }

                });
                if (!verifica) {

                    $(this).prop('checked', false);
                }

                click = '';
            }



        } else {

            container.find('.checkbox1').each(function () {

                $(this).prop('checked', false);
            });
        }

    });

    $('.checkbox1').change(function () {

        click = 'check';
        $(this).parents('ul').find('.checkbox_principal').prop('checked', true).change();
    })





// busca



    $("body").on('click', '.validar_cnpj', function (e) {

        e.preventDefault();
        var elemento_atual = $('.cnpj').parents('.form-ajax_cliente');
        var cnpj = $('.cnpj').val().replace(/[-._\W]+/g, "")

        //console.log(cnpj);

        $.ajax({

            url: base_url + 'ajax/buscaCnpj/?cnpj=' + cnpj,
            method: 'GET',
            dataType: 'json',
            success: function (resposta) {

                elemento_atual.find(".nome_razao_social").val(resposta.nome);
                elemento_atual.find(".nome_fantasia").val(resposta.fantasia);
                elemento_atual.find(".cep").val(resposta.cep);
                elemento_atual.find(".estado").val(resposta.uf);
                elemento_atual.find(".bairro").val(resposta.bairro);
                elemento_atual.find(".end_comercial").val(resposta.logradouro);
                elemento_atual.find(".complemento").val(resposta.complemento);
                elemento_atual.find(".numero").val(resposta.numero);
            }

        });
    });





    $("body").on('focusout', '.cep', function () {

        //Início do Comando AJAX

        var elemento_atual = $(this).parents('.enderecos-cliente');
        $.ajax({

            //O campo URL diz o caminho de onde virá os dados

            //É importante concatenar o valor digitado no CEP

            url: 'https://viacep.com.br/ws/' + $(this).val() + '/json/unicode/',
            //Aqui você deve preencher o tipo de dados que será lido,

            //no caso, estamos lendo JSON.

            dataType: 'json',
            //SUCESS é referente a função que será executada caso

            //ele consiga ler a fonte de dados com sucesso.

            //O parâmetro dentro da função se refere ao nome da variável

            //que você vai dar para ler esse objeto.

            success: function (resposta) {

                //Agora basta definir os valores que você deseja preencher

                //automaticamente nos campos acima.

                elemento_atual.find(".endereco").val(resposta.logradouro);
                elemento_atual.find(".complemento").val(resposta.complemento);
                elemento_atual.find(".bairro").val(resposta.bairro);
                elemento_atual.find(".cidade").val(resposta.localidade);
                elemento_atual.find(".estado").val(resposta.uf);
                //Vamos incluir para que o Número seja focado automaticamente

                //melhorando a experiência do usuário

                elemento_atual.find(".numero").focus();
            }

        });
    });





    $("body").on('focusout', '.cep_com', function () {

        //Início do Comando AJAX

        $.ajax({

            //O campo URL diz o caminho de onde virá os dados

            //É importante concatenar o valor digitado no CEP

            url: 'https://viacep.com.br/ws/' + $(this).val() + '/json/unicode/',
            //Aqui você deve preencher o tipo de dados que será lido,

            //no caso, estamos lendo JSON.

            dataType: 'json',
            //SUCESS é referente a função que será executada caso

            //ele consiga ler a fonte de dados com sucesso.

            //O parâmetro dentro da função se refere ao nome da variável

            //que você vai dar para ler esse objeto.

            success: function (resposta) {

                //Agora basta definir os valores que você deseja preencher

                //automaticamente nos campos acima.

                (".end_comercial").val(resposta.logradouro);
                (".complemento").val(resposta.complemento);
                (".bairro").val(resposta.bairro);
                (".cidade").val(resposta.localidade);
                (".estado").val(resposta.uf);
                //Vamos incluir para que o Número seja focado automaticamente

                //melhorando a experiência do usuário

                elemento_atual.find(".numero").focus();
            }

        });
    });



    /*

     $('.btn-addEndereco').click(function (e) {

     e.preventDefault();
     if ($('.end-1').hasClass('d-none')) {

     $('.end-1').removeClass('d-none');
     } else {

     $('.end-1').addClass('d-none');
     }



     });

     */



    $('.classZendesk').change('click', function () {



        if ($(this).is(':checked')) {

            $(this).attr('checked', true);
            //$('#idZendesk').removeClass('d-none');

            $('#idZendesk').slideToggle();
        } else {

            $(this).removeAttr('checked');
            $('#idZendesk').slideToggle();
        }



    });





    $('.classGranataum').change('click', function () {



        if ($(this).is(':checked')) {

            $(this).attr('checked', true);
            $('#idGranataum').removeClass('d-none');
        } else {

            $(this).removeAttr('checked');
            $('#idGranataum').addClass('d-none');
        }



    });



    $('input[type=checkbox].default').click(function () {

        var valor = $(this).val();
        valor = ($(this).prop('checked') ? 'on' : '');
        var id_integracao = $(this).attr('id_integracao');
        $.ajax({

            url: base_url + 'ajax/integracao/?action=update',
            method: 'POST',
            data: {zendesk_status: valor, 'id': id_integracao},
            success: function (response) {

                console.log(response);
            },
            complete: function () {



            }

        })

    })





// gráfico Zendesk Dashboard



    var container = $('body');

    $('.doughnutChart').each(function (index) {

        $(this).attr('id', 'doughnutChart-' + index);
        //var titulo = $(this).attr('titulo');

        //var cores = $(this).attr('cores').split(";");

        var valores = $(this).attr('valores').split(";");
        //var labels = $(this).attr('labels').split(";");

        //alert( $("#doughnutChart-0").attr('valores') );

        //var ctx = $(this).get(0).getContext('2d');

        //var ctx = document.getElementById('myChart-'+index).getContext('2d');

        var ctx = document.getElementById("doughnutChart-0").getContext('2d');
        var myChart = new Chart(ctx, {

            type: 'doughnut',
            data: {

                labels: ["Email", "Facebook", "Chat", "Web", "Tickets Simples"],
                datasets: [{

                        data: valores,
                        backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#024d81"],
                        hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#024d81ba"]

                    }],
            },
            options: {

                responsive: true,
                tooltips: {

                    callbacks: {

                        label: function (tooltipItem, data) {

                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var meta = dataset._meta[Object.keys(dataset._meta)[0]];
                            var total = meta.total;
                            var currentValue = dataset.data[tooltipItem.index];
                            var percentage = parseFloat((currentValue / total * 100).toFixed(1));
                            return '(' + percentage + '%)';
                        },
                        title: function (tooltipItem, data) {

                            return data.labels[tooltipItem[0].index];
                        }

                    }

                },
            }

        });
    });





    "use strict";

    var KTDatatablesBasicPaginations = function () {

        var initTable1 = function () {
		var ocultar_data = {};
			if( $('.tabela_bolaboradores').length > 0 ){
				ocultar_data = {
					targets: 6,
					visible: false,
				};
			}
            var url = $("#kt_table_12").attr("url");
            // begin first table

            var table = $('#kt_table_12').DataTable({

                responsive: true,
                ajax: {

                    "url": url,
                    "dataSrc": "data"

                },
                "language": {

                    "search": "Pesquisar",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "lengthMenu": "Exibir _MENU_ resultados",
                    "paginate": {

                        "previous": "Anterior",
                        "next": "Próximo",
                    }

                },
                pagingType: 'full_numbers',
                columnDefs: [

                    {

                        targets: -1,
                        title: 'Ações',
                        orderable: false,
                        render: function (data, type, full, meta) {

                            return `

                        <span class="dropdown">

                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">

                              <i class="la la-ellipsis-h"></i>

                            </a>

                            <div class="dropdown-menu dropdown-menu-right">

                                <a class="dropdown-item editar-item" href="#"><i class="la la-edit"></i> Editar</a>

                                <a class="dropdown-item excluir-item" href="#"><i class="la la-trash"></i> Excluir</a>

                            </div>

                        </span>

                        `;
                        },
                    },ocultar_data
                ],
            });



				 $('body').mouseover(function (e) {
					 $('.dataTable.tabela_bolaboradores tr').each(function(){
						var dados_table = table.row($(this)).data();
						if( dados_table ){
							data = dados_table[6].split(' ');
							data = data[0].replace('-','').replace('-','');
							console.log();
							if( data <= '20190701' ){
								$(this).css('background','#ff00001a');
							}else{
								$(this).css('background','#ffffff');
							}
						}
					 })
				 })



             $('body').on('click', '.tabela_bolaboradores tr td', function (e) {

                var id = $(this).parents('tr').find('td').eq('0').text();
                var nome = $(this).parents('tr').find('td').eq('1').text();
                var sobrenome = $(this).parents('tr').find('td').eq('2').text();
                var endereco = $(this).parents('tr').find('td').eq('3').text();
                var bairro = $(this).parents('tr').find('td').eq('4').text();
                if (nome == $(this).text() || sobrenome == $(this).text() || endereco == $(this).text() || bairro == $(this).text()) {



                    titulo = 'Informações do Cliente';
                    var select_especialidade_dados = '';
                    $.ajax({

                        url: base_url + 'ajax/return_dados/?tabela=colaboradores&tipo=colaboradores&campos=id,nome,sobrenome,cpf,rg,profissao,status,nome_conjuge,sexo,telefone_res,telefone_cel,nacionalidade,naturalidade,estado_civil,cep,endereco,bairro,estado,numero,complemento,email,salario,date_create&id=' + id,
                        async: false,
						dataType: 'json',
                        success: function (resposta) {

                            select_especialidade_dados = resposta;
                        },
                        error: function () {



                        }

                    });
                    var inserir_html = '';
                    var select_especialidade_modelo = '\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Nome: </b></label><label class="lbl_modal-itens"> @@nome@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Sobrenome: </b></label><label class="lbl_modal-itens"> @@sobrenome@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>CPF: </b></label><label class="lbl_modal-itens"> @@cpf@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>RG: </b></label><label class="lbl_modal-itens"> @@rg@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Profissão: </b></label><label class="lbl_modal-itens"> @@profissao@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Sexo: </b></label><label class="lbl_modal-itens"> @@sexo@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Email: </b></label><label class="lbl_modal-itens"> @@email@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Telefone Residencial: </b></label><label class="lbl_modal-itens"> @@telefone_res@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Telefone Celular: </b></label><label class="lbl_modal-itens"> @@telefone_cel@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>CEP: </b></label><label class="lbl_modal-itens"> @@cep@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Endereço: </b></label><label class="lbl_modal-itens"> @@endereco@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Bairro: </b></label><label class="lbl_modal-itens"> @@bairro@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Estado: </b></label><label class="lbl_modal-itens"> @@estado@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Número: </b></label><label class="lbl_modal-itens"> @@numero@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Complemento: </b></label><label class="lbl_modal-itens"> @@complemento@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Nacionalidade: </b></label><label class="lbl_modal-itens"> @@nacionalidade@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Naturalidade: </b></label><label class="lbl_modal-itens"> @@naturalidade@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Estado Civil: </b></label><label class="lbl_modal-itens"> @@estado_civil@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Salário: </b></label><label class="lbl_modal-itens"> @@salario@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Status: </b></label><label class="lbl_modal-itens"> @@status@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Data de Criação: </b></label><label class="lbl_modal-itens"> @@date_create@@</label></div>';



                    $.each(select_especialidade_dados.data, function (index, value) {

                        select = select_especialidade_modelo.replace('@@id@@', value[0]);
                        select = select.replace('@@nome@@', ' ' + jsonDecodeAjax(value[1].replace('"', '').replace('"', '')));
                        select = select.replace('@@sobrenome@@', ' ' + jsonDecodeAjax(value[2].replace('"', '').replace('"', '')));
                        select = select.replace('@@cpf@@', ' ' + jsonDecodeAjax(value[3].replace('"', '').replace('"', '')));
                        select = select.replace('@@rg@@', ' ' + jsonDecodeAjax(value[4].replace('"', '').replace('"', '')));
                        select = select.replace('@@profissao@@', ' ' + jsonDecodeAjax(value[5].replace('"', '').replace('"', '')));
                        select = select.replace('@@status@@', ' ' + jsonDecodeAjax(value[6].replace('\\', '').replace('"', '').replace('"', '')));
                        select = select.replace('@@nome_conjuge@@', ' ' + jsonDecodeAjax(value[7].replace('"', '').replace('"', '')));
                        select = select.replace('@@sexo@@', ' ' + jsonDecodeAjax(value[8].replace('"', '').replace('"', '')));
                        select = select.replace('@@telefone_res@@', ' ' + jsonDecodeAjax(value[9].replace('"', '').replace('"', '')));
                        select = select.replace('@@telefone_cel@@', ' ' + jsonDecodeAjax(value[10].replace('"', '').replace('"', '')));
                        select = select.replace('@@nacionalidade@@', ' ' + jsonDecodeAjax(value[11].replace('"', '').replace('"', '')));
                        select = select.replace('@@naturalidade@@', ' ' + jsonDecodeAjax(value[12].replace('"', '').replace('"', '')));
                        select = select.replace('@@estado_civil@@', ' ' + jsonDecodeAjax(value[13].replace('"', '').replace('"', '')));
                        select = select.replace('@@cep@@', ' ' + jsonDecodeAjax(value[14].replace('"', '').replace('"', '')));
                        select = select.replace('@@endereco@@', ' ' + jsonDecodeAjax(value[15].replace('"', '').replace('"', '')));
                        select = select.replace('@@bairro@@', ' ' + jsonDecodeAjax(value[16].replace('"', '').replace('"', '')));
                        select = select.replace('@@estado@@', ' ' + jsonDecodeAjax(value[17].replace('"', '').replace('"', '')));
                        select = select.replace('@@numero@@', ' ' + jsonDecodeAjax(value[18].replace('"', '').replace('"', '')));
                        select = select.replace('@@complemento@@', ' ' + jsonDecodeAjax(value[19].replace('"', '').replace('"', '')));
                        select = select.replace('@@email@@', ' ' + jsonDecodeAjax(value[20].replace('"', '').replace('"', '')));
                        select = select.replace('@@salario@@', ' ' + jsonDecodeAjax(value[21].replace('"', '').replace('"', '')));
                        select = select.replace('@@date_create@@', ' ' + jsonDecodeAjax(value[22].replace("\\", "").replace("\\", "").replace("\\n", "").replace('"', '').replace('"', '')));
                        if ($.inArray(id, value[0])) {
                            inserir_html += select;
                        }

                        //console.log(id);

                    })



                    var select_especialidade = inserir_html;
                    conteudo = '\
                        <div class="container"> <div class="row" style="background: #efefef; margin: auto;"> ' + select_especialidade + '</div></div>\
                        ';



                    modal(titulo, conteudo, campos = 'none', "", 'false', '', id_form = '', class_form = '', action_form = '');
                }

            });




            $('#kt_table_12').on('click', '.editar-item', function (e) {

                e.preventDefault();
                var elemento = $(this).parents('tr');
                if ($(this).parents('tr').hasClass('child')) {

                    elemento = $(this).parents('tr').prev();
                }



                var data = table.row(elemento).data();
                var url = $("#kt_table_12").attr("button_editar_url");
                //var data = table.row($(this).parents('tr')).data();



                var data0 = data[0];
                //alert(url+"id="+data[0]);

                location.href = url + "id=" + data0;
                //alert( data[0] +"'s salary is: "+ data[ 5 ] );

            });
            $('#kt_table_12 tbody').on('click', '.excluir-item', function (e) {

                e.preventDefault();
                var elemento = $(this).parents('tr');
                if ($(this).parents('tr').hasClass('child')) {

                    elemento = $(this).parents('tr').prev();
                }

                var data = table.row(elemento).data();
                var url = $("#kt_table_12").attr("button_url_excluir");
                var data0 = data[0];
                var id = data0;
                //alert( data[0] +"'s salary is: "+ data[ 5 ] );

                //table.row($(this).parents('tr')).remove().draw();

                //$(this).row(parents('tr')).remove().draw();

                var elemento = $(this);
                //console.log(data0);

                var r = confirm("Deseja realmente excluir?");
                if (r == true) {

                    $.ajax({

                        method: "POST",
                        data: {

                            id: id,
                            action: 'delete'

                        },
                        dataType: 'json',
                        url: url,
                        success: function (r) {

                            //console.log(r.status);

                            //alert(r.msg);

                            elemento.parents('tr').find('td').remove().draw();
                            modal_basic(r.title, r.msg, '#28a745');
                        }

                    });
                }

            });
        };
        return {

            //main function to initiate the module

            init: function () {

                initTable1();
            },
        };
    }();



    jQuery(document).ready(function () {

        KTDatatablesBasicPaginations.init();
    });





    var KTDatatablesBasicPaginationsClientes = function () {



        initTable1 = function () {



            var url = $("#kt_table_clientes").attr("url");
            // begin first table

            var table = $('#kt_table_clientes').DataTable({

                responsive: true,
                ajax: {

                    "url": url,
                    "dataSrc": "data"

                },
                "language": {

                    "search": "Pesquisar",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "lengthMenu": "Exibir _MENU_ resultados",
                    "paginate": {

                        "previous": "Anterior",
                        "next": "Próximo",
                    }

                },
                pagingType: 'full_numbers',
                columnDefs: [

                    {

                        targets: -1,
                        title: 'Ações',
                        orderable: false,
                        render: function (data, type, full, meta) {

                            return `

                        <span class="dropdown">

                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">

                              <i class="la la-ellipsis-h"></i>

                            </a>

                            <div class="dropdown-menu dropdown-menu-right">

                                <a class="dropdown-item editar-status" href="#"><i class="la la-power-off"></i> Ativar/Desativar</a>

                                <a class="dropdown-item editar-item" id="edit" href="#"><i class="la la-edit"></i> Editar</a>

                                <a class="dropdown-item excluir-item" href="#"><i class="la la-trash"></i> Excluir</a>

                            </div>

                        </span>

                        `;
                        },
                    },
                ],
            });
            /* modal razao social */


				/* $('body').mouseover(function (e) {
					 $('.dataTable tr').each(function(){
						var dados_table = table.row($(this)).data();
						if( dados_table ){
							data = dados_table[6].split(' ');
							data = data[0].replace('-','').replace('-','');
							console.log();
							if( data <= '20190701' ){
								$(this).css('background','#ff00001a');
							}else{
								$(this).css('background','#ffffff');
							}
						}
					 })
				 })*/


            $('body').on('click', '#kt_table_clientes tr td', function (e) {

                var id = $(this).parents('tr').find('td').eq('0').text();
                var razao_social = $(this).parents('tr').find('td').eq('2').text();
                var nome_fantasia = $(this).parents('tr').find('td').eq('3').text();
                var cpf_cnpj = $(this).parents('tr').find('td').eq('4').text();
                var email = $(this).parents('tr').find('td').eq('5').text();
                if (razao_social == $(this).text() || nome_fantasia == $(this).text() || cpf_cnpj == $(this).text() || email == $(this).text()) {



                    titulo = 'Informações do Cliente';
                    var select_especialidade_dados = '';
                    $.ajax({

                        url: base_url + 'ajax/return_dados/?tabela=clientes&tipo=clientes&campos=id,nome_razao_social,end_res,cpf_cnpj,tel_con,email,cep_res,bairro_res,estado_res,numero_res,complemento_res,status,date_create&id=' + id,
                        async: false,
						dataType: 'json',
                        success: function (resposta) {

                            select_especialidade_dados = resposta;
                        },
                        error: function () {



                        }

                    });
                    var inserir_html = '';
                    var select_especialidade_modelo = '\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Nome/Razão Social: </b></label><label class="lbl_modal-itens">@@nome_razao_social@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>CPF/CNPJ: </b></label><label class="lbl_modal-itens">@@cpf_cnpj@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Email: </b></label><label class="lbl_modal-itens">@@email@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Telefone: </b></label><label class="lbl_modal-itens">@@tel_con@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>CEP: </b></label><label class="lbl_modal-itens">@@cep_res@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Endereço Residencial: </b></label><label class="lbl_modal-itens">@@end_res@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Bairro: </b></label><label class="lbl_modal-itens">@@bairro_res@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Estado: </b></label><label class="lbl_modal-itens">@@estado_res@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Número: </b></label><label class="lbl_modal-itens">@@numero_res@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Complemento: </b></label><label class="lbl_modal-itens">@@complemento_res@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Data do cadastro: </b></label><label class="lbl_modal-itens">@@date_create@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Status do Cliente: </b></label><label class="lbl_modal-itens">@@status@@</label></div>';



                    $.each(select_especialidade_dados.data, function (index, value) {

                        select = select_especialidade_modelo.replace('@@id@@', value[0]);
                        select = select.replace('@@nome_razao_social@@', ' ' + jsonDecodeAjax(value[1].replace('"', '').replace('"', '')));
                        select = select.replace('@@end_res@@', ' ' + jsonDecodeAjax(value[2].replace('"', '').replace('"', '')));
                        select = select.replace('@@cpf_cnpj@@', ' ' + jsonDecodeAjax(value[3].replace('\\', '').replace('"', '').replace('"', '')));
                        select = select.replace('@@tel_con@@', ' ' + jsonDecodeAjax(value[4].replace('"', '').replace('"', '')));
                        select = select.replace('@@email@@', ' ' + jsonDecodeAjax(value[5].replace('"', '').replace('"', '')));
                        select = select.replace('@@cep_res@@', ' ' + jsonDecodeAjax(value[6].replace('"', '').replace('"', '')));
                        select = select.replace('@@bairro_res@@', ' ' + jsonDecodeAjax(value[7].replace('"', '').replace('"', '')));
                        select = select.replace('@@estado_res@@', ' ' + jsonDecodeAjax(value[8].replace('"', '').replace('"', '')));
                        select = select.replace('@@numero_res@@', ' ' + jsonDecodeAjax(value[9].replace('"', '').replace('"', '')));
                        select = select.replace('@@complemento_res@@', ' ' + jsonDecodeAjax(value[10].replace('"', '').replace('"', '')));
                        select = select.replace('@@status@@', ' ' + jsonDecodeAjax(value[11].replace('"', '').replace('"', '')));
                        select = select.replace('@@date_create@@', ' ' + jsonDecodeAjax(value[12].replace("\\", "").replace("\\", "").replace("\\n", "").replace('"', '').replace('"', '').replace('<br />',' ')));
                        if ($.inArray(id, value[0])) {

                            inserir_html += select;
                        }

                        //console.log(id);

                    })



                    var select_especialidade = inserir_html;
                    conteudo = '\
                        <div class="container"> <div class="row" style="background: #efefef; margin: auto;"> ' + select_especialidade + '</div></div>\
                        ';



                    modal(titulo, conteudo, campos = 'none', "", 'false', '', id_form = '', class_form = '', action_form = '');
                }

            });

            $('#kt_table_clientes').on('click', '.editar-item', function (e) {



                e.preventDefault();
                var elemento = $(this).parents('tr');
                if ($(this).parents('tr').hasClass('child')) {

                    elemento = $(this).parents('tr').prev();
                }



                var data = table.row(elemento).data();
                var url = $("#kt_table_clientes").attr("button_editar_url");
                //var data = table.row($(this).parents('tr')).data();



                //var data0 = $(this).parents('tr').find('td').eq(0).text();

                var data0 = data[0];
                //var attr = $(this).parents('tr').find('td').eq(0).attr('data-id', data0);

                //alert(url+"id="+data[0]);

                location.href = url + "id=" + data0;
                //alert( data[0] +"'s salary is: "+ data[ 5 ] );

            });
            $('#kt_table_clientes').on('click', '.editar-status', function (e) {

                e.preventDefault();
                var elemento = $(this).parents('tr');
                if ($(this).parents('tr').hasClass('child')) {
                    elemento = $(this).parents('tr').prev();
                }

                var data = table.row(elemento).data();
                var url = $("#kt_table_clientes").attr("button_ordem_de_servico_url");
                //var data = table.row($(this).parents('tr')).data();

                var data0 = data[0];
                var nome_cliente = data[2];
                //alert(url+"id="+data[0]);
				var status_cliente = data[4];

                //location.href = url + "id=" + data0;
                //alert( data[0] +"'s salary is: "+ data[ 5 ] );
				
				var status_cliente_alterado = ( status_cliente != 'ativo' ? 'ativo' : 'inativo' );

				$.ajax({
					url: base_url+'ajax/clientes/?action=editar-status&status='+status_cliente+'&id='+data0,
					dataType: 'json',
					success: function(data){
						if(data.status == 'success'){
							//modal_basic('Sucesso','O status do(a) cliente "'+nome_cliente+'" foi alterado para "'+status_cliente_alterado+'"!', '');
							elemento.find('td').eq(4).text(status_cliente_alterado);
						}else{
							modal_basic('Erro','Algo deu errado, verifique sua conexão e tente novamente!', '', '');
						}
					},
					error: function(){
						modal_basic('Erro','Algo deu errado, verifique sua conexão e tente novamente!', '', '');
					}
				})


            });

            $('#kt_table_clientes tbody').on('click', '.excluir-item', function (e) {

                e.preventDefault();
                var elemento = $(this).parents('tr');
                if ($(this).parents('tr').hasClass('child')) {

                    elemento = $(this).parents('tr').prev();
                }



                var data = table.row(elemento).data();
                var url = $("#kt_table_clientes").attr("button_url_excluir");
                var data0 = data[0];
                var data1 = data[1];
                var id = data0;
                var id_zendesk = data1;
                //alert( data[0] +"'s salary is: "+ data[ 5 ] );

                //table.row($(this).parents('tr')).remove().draw();

                //$(this).parents('tr').find('td').remove().draw();



                var elemento = $(this);
                var r = confirm("Deseja realmente excluir?");
                if (r == true) {

                    $.ajax({

                        method: "POST",
                        data: {

                            id: id,
                            id_zendesk: id_zendesk,
                            action: 'delete'

                        },
                        dataType: 'json',
                        url: url,
                        success: function (r) {

                            //console.log(r.status);

                            //alert(r.msg);
							if( r.status == 'success' ){
								elemento.parents('tr').find('td').remove().draw();
							}
                            modal_basic(r.title, r.msg, '#28a745');
                        }

                    });
                }

            });
        };
        return {

            //main function to initiate the module

            init: function () {

                initTable1();
            },
        };
    }();



    KTDatatablesBasicPaginationsClientes.init();



















    var KTDatatablesBasicPaginationsSalas = function () {



        initTable1 = function () {



            var url = $("#kt_table_salas").attr("url");
            // begin first table

            var table = $('#kt_table_salas').DataTable({

                responsive: true,
                ajax: {

                    "url": url,
                    "dataSrc": "data"

                },
                "language": {

                    "search": "Pesquisar",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "lengthMenu": "Exibir _MENU_ resultados",
                    "paginate": {

                        "previous": "Anterior",
                        "next": "Próximo",
                    }

                },
                pagingType: 'full_numbers',
                columnDefs: [

                    {

                        targets: -1,
                        title: 'Ações',
                        orderable: false,
                        render: function (data, type, full, meta) {

                            return `

                        <span class="dropdown">

                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">

                              <i class="la la-ellipsis-h"></i>

                            </a>

                            <div class="dropdown-menu dropdown-menu-right">

                                <a class="dropdown-item editar-status" style="display: none;" href="#"><i class="la la-power-off"></i> Ativar/Desativar</a>

                                <a class="dropdown-item editar-item" id="edit" href="#"><i class="la la-edit"></i> Editar</a>

                                <a class="dropdown-item excluir-item" href="#"><i class="la la-trash"></i> Excluir</a>

                            </div>

                        </span>

                        `;
                        },
                    },
                ],
            });
            /* modal razao social */


				/* $('body').mouseover(function (e) {
					 $('.dataTable tr').each(function(){
						var dados_table = table.row($(this)).data();
						if( dados_table ){
							data = dados_table[6].split(' ');
							data = data[0].replace('-','').replace('-','');
							console.log();
							if( data <= '20190701' ){
								$(this).css('background','#ff00001a');
							}else{
								$(this).css('background','#ffffff');
							}
						}
					 })
				 })*/


            $('body').on('click', '#kt_table_clientes tr td', function (e) {

                var id = $(this).parents('tr').find('td').eq('0').text();
                var razao_social = $(this).parents('tr').find('td').eq('2').text();
                var nome_fantasia = $(this).parents('tr').find('td').eq('3').text();
                var cpf_cnpj = $(this).parents('tr').find('td').eq('4').text();
                var email = $(this).parents('tr').find('td').eq('5').text();
                if (razao_social == $(this).text() || nome_fantasia == $(this).text() || cpf_cnpj == $(this).text() || email == $(this).text()) {



                    titulo = 'Informações do Cliente';
                    var select_especialidade_dados = '';
                    $.ajax({

                        url: base_url + 'ajax/return_dados/?tabela=clientes&tipo=clientes&campos=id,nome_razao_social,end_res,cpf_cnpj,tel_con,email,cep_res,bairro_res,estado_res,numero_res,complemento_res,status,date_create&id=' + id,
                        async: false,
						dataType: 'json',
                        success: function (resposta) {

                            select_especialidade_dados = resposta;
                        },
                        error: function () {



                        }

                    });
                    var inserir_html = '';
                    var select_especialidade_modelo = '\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Nome/Razão Social: </b></label><label class="lbl_modal-itens">@@nome_razao_social@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>CPF/CNPJ: </b></label><label class="lbl_modal-itens">@@cpf_cnpj@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Email: </b></label><label class="lbl_modal-itens">@@email@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Telefone: </b></label><label class="lbl_modal-itens">@@tel_con@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>CEP: </b></label><label class="lbl_modal-itens">@@cep_res@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Endereço Residencial: </b></label><label class="lbl_modal-itens">@@end_res@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Bairro: </b></label><label class="lbl_modal-itens">@@bairro_res@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Estado: </b></label><label class="lbl_modal-itens">@@estado_res@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Número: </b></label><label class="lbl_modal-itens">@@numero_res@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Complemento: </b></label><label class="lbl_modal-itens">@@complemento_res@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Data do cadastro: </b></label><label class="lbl_modal-itens">@@date_create@@</label></div>\
                        <div class="col-12 col-md-6 mt-3"><label style="color: #464457 !important;"><b>Status do Cliente: </b></label><label class="lbl_modal-itens">@@status@@</label></div>';



                    $.each(select_especialidade_dados.data, function (index, value) {

                        select = select_especialidade_modelo.replace('@@id@@', value[0]);
                        select = select.replace('@@nome_razao_social@@', ' ' + jsonDecodeAjax(value[1].replace('"', '').replace('"', '')));
                        select = select.replace('@@end_res@@', ' ' + jsonDecodeAjax(value[2].replace('"', '').replace('"', '')));
                        select = select.replace('@@cpf_cnpj@@', ' ' + jsonDecodeAjax(value[3].replace('\\', '').replace('"', '').replace('"', '')));
                        select = select.replace('@@tel_con@@', ' ' + jsonDecodeAjax(value[4].replace('"', '').replace('"', '')));
                        select = select.replace('@@email@@', ' ' + jsonDecodeAjax(value[5].replace('"', '').replace('"', '')));
                        select = select.replace('@@cep_res@@', ' ' + jsonDecodeAjax(value[6].replace('"', '').replace('"', '')));
                        select = select.replace('@@bairro_res@@', ' ' + jsonDecodeAjax(value[7].replace('"', '').replace('"', '')));
                        select = select.replace('@@estado_res@@', ' ' + jsonDecodeAjax(value[8].replace('"', '').replace('"', '')));
                        select = select.replace('@@numero_res@@', ' ' + jsonDecodeAjax(value[9].replace('"', '').replace('"', '')));
                        select = select.replace('@@complemento_res@@', ' ' + jsonDecodeAjax(value[10].replace('"', '').replace('"', '')));
                        select = select.replace('@@status@@', ' ' + jsonDecodeAjax(value[11].replace('"', '').replace('"', '')));
                        select = select.replace('@@date_create@@', ' ' + jsonDecodeAjax(value[12].replace("\\", "").replace("\\", "").replace("\\n", "").replace('"', '').replace('"', '').replace('<br />',' ')));
                        if ($.inArray(id, value[0])) {

                            inserir_html += select;
                        }

                        //console.log(id);

                    })



                    var select_especialidade = inserir_html;
                    conteudo = '\
                        <div class="container"> <div class="row" style="background: #efefef; margin: auto;"> ' + select_especialidade + '</div></div>\
                        ';



                    modal(titulo, conteudo, campos = 'none', "", 'false', '', id_form = '', class_form = '', action_form = '');
                }

            });

            $('#kt_table_salas').on('click', '.editar-item', function (e) {



                e.preventDefault();
                var elemento = $(this).parents('tr');
                if ($(this).parents('tr').hasClass('child')) {

                    elemento = $(this).parents('tr').prev();
                }



                var data = table.row(elemento).data();
                var url = $("#kt_table_salas").attr("button_editar_url");
                //var data = table.row($(this).parents('tr')).data();



                //var data0 = $(this).parents('tr').find('td').eq(0).text();

                var data0 = data[0];
                //var attr = $(this).parents('tr').find('td').eq(0).attr('data-id', data0);

                //alert(url+"id="+data[0]);

                location.href = url + "id=" + data0;
                //alert( data[0] +"'s salary is: "+ data[ 5 ] );

            });
            $('#kt_table_salas').on('click', '.editar-status', function (e) {

                e.preventDefault();
                var elemento = $(this).parents('tr');
                if ($(this).parents('tr').hasClass('child')) {
                    elemento = $(this).parents('tr').prev();
                }

                var data = table.row(elemento).data();
                var url = $("#kt_table_salas").attr("button_ordem_de_servico_url");
                //var data = table.row($(this).parents('tr')).data();

                var data0 = data[0];
                var nome_salas = data[2];
                //alert(url+"id="+data[0]);
				var status_salas = data[4];

                //location.href = url + "id=" + data0;
                //alert( data[0] +"'s salary is: "+ data[ 5 ] );
				
				var status_salas_alterado = ( status_salas != 'ativo' ? 'ativo' : 'inativo' );

				$.ajax({
					url: base_url+'ajax/salas/?action=editar-status&status='+status_cliente+'&id='+data0,
					dataType: 'json',
					success: function(data){
						if(data.status == 'success'){
							//modal_basic('Sucesso','O status do(a) cliente "'+nome_cliente+'" foi alterado para "'+status_cliente_alterado+'"!', '');
							elemento.find('td').eq(4).text(status_salas_alterado);
						}else{
							modal_basic('Erro','Algo deu errado, verifique sua conexão e tente novamente!', '', '');
						}
					},
					error: function(){
						modal_basic('Erro','Algo deu errado, verifique sua conexão e tente novamente!', '', '');
					}
				})


            });

            $('#kt_table_salas tbody').on('click', '.excluir-item', function (e) {

                e.preventDefault();
                var elemento = $(this).parents('tr');
                if ($(this).parents('tr').hasClass('child')) {

                    elemento = $(this).parents('tr').prev();
                }



                var data = table.row(elemento).data();
                var url = $("#kt_table_salas").attr("button_url_excluir");
                var data0 = data[0];
                var data1 = data[1];
                var id = data0;
                var id_zendesk = data1;
                //alert( data[0] +"'s salary is: "+ data[ 5 ] );

                //table.row($(this).parents('tr')).remove().draw();

                //$(this).parents('tr').find('td').remove().draw();



                var elemento = $(this);
                var r = confirm("Deseja realmente excluir?");
                if (r == true) {

                    $.ajax({

                        method: "POST",
                        data: {

                            id: id,
                            id_zendesk: id_zendesk,
                            action: 'delete'

                        },
                        dataType: 'json',
                        url: url,
                        success: function (r) {

                            //console.log(r.status);

                            //alert(r.msg);

                            elemento.parents('tr').find('td').remove().draw();
                            modal_basic(r.title, r.msg, '#28a745');
                        }

                    });
                }

            });
        };
        return {

            //main function to initiate the module

            init: function () {

                initTable1();
            },
        };
    }();



    KTDatatablesBasicPaginationsSalas.init();


















    function readImage() {

        if (this.files && this.files[0]) {

            var file = new FileReader();
            file.onload = function (e) {

                document.getElementById("preview").src = e.target.result;
            };
            file.readAsDataURL(this.files[0]);
        }

    }



//document.getElementById("imgChooser").addEventListener("change", readImage, false);

    $("#imgChooser").on("change", readImage());





// jQuery Mask Plugin v1.14.11

// github.com/igorescobar/jQuery-Mask-Plugin



    var cpfMascara = function (val) {

        return val.replace(/\D/g, '').length > 11 ? '00.000.000/0000-00' : '000.000.000-009';
    },
            cpfOptions = {

                onKeyPress: function (val, e, field, options) {

                    field.mask(cpfMascara.apply({}, arguments), options);
                }

            };

    $('#cpfcnpj').mask(cpfMascara, cpfOptions);

	if( $('.alert-msg').length > 0 ){
		infos = $('.alert-msg').attr('modal-basic').split('|');
		modal_basic(infos[0],infos[1]);
	}

});



$(window).on('load', function () {

    $('.editar-item').each(function () {

        var data = table.row($(this).parents('tr')).data();
        tipo = data[3];
        if (data[3] == 'admin' && permissoes != 'admin') {

            $(this).parents('tr').find('.editar-item,.excluir').css('display', 'none');
        }

    });
})





function moeda(a, e, r, t) {

    let n = ""

            , h = j = 0

            , u = tamanho2 = 0

            , l = ajd2 = ""

            , o = window.Event ? t.which : t.keyCode;
    if (13 == o || 8 == o)
        return !0;
    if (n = String.fromCharCode(o),
            -1 == "0123456789".indexOf(n))
        return !1;
    for (u = a.value.length,
            h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
        ;
    for (l = ""; h < u; h++)
        -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
    if (l += n,
            0 == (u = l.length) && (a.value = ""),
            1 == u && (a.value = "0" + r + "0" + l),
            2 == u && (a.value = "0" + r + l),
            u > 2) {

        for (ajd2 = "",
                j = 0,
                h = u - 3; h >= 0; h--)
            3 == j && (ajd2 += e,
                    j = 0),
                    ajd2 += l.charAt(h),
                    j++;
        for (a.value = "",
                tamanho2 = ajd2.length,
                h = tamanho2 - 1; h >= 0; h--)
            a.value += ajd2.charAt(h);
        a.value += r + l.substr(u - 2, u)

    }

    return !1

}



/*function newRow(id) {



 var div_box = document.getElementById("box-endereco");
 var div_row = id.parentNode;
 var div_new = div_row.cloneNode(true);
 var new_id = "row-" + new Date().getTime();
 div_new.setAttribute("id", new_id);
 div_box.appendChild(div_new);
 var deleteList = div_box.getElementsByClassName("button-delete");
 var display = "none";
 if (deleteList.length > 1) {

 display = "";
 }

 for (i = 0; i < deleteList.length; i++) {

 deleteList[i].style.display = display;
 }





 }





 function deleteRow(id) {



 var div_box = document.getElementById("box-endereco");
 var div_row = id.parentNode;
 div_box.removeChild(div_row);
 var deleteList = div_box.getElementsByClassName("button-delete");
 if (deleteList.length < 2) {

 deleteList[0].style.display = "none";
 }

 }*/



$(function () {

    $("#valor").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
})



function mascaraData(val) {

    var pass = val.value;
    var expr = /[0123456789]/;
    for (i = 0; i < pass.length; i++) {

        // charAt -> retorna o caractere posicionado no índice especificado

        var lchar = val.value.charAt(i);
        var nchar = val.value.charAt(i + 1);
        if (i == 0) {

            // search -> retorna um valor inteiro, indicando a posição do inicio da primeira

            // ocorrência de expReg dentro de instStr. Se nenhuma ocorrencia for encontrada o método retornara -1

            // instStr.search(expReg);

            if ((lchar.search(expr) != 0) || (lchar > 3)) {

                val.value = "";
            }



        } else if (i == 1) {



            if (lchar.search(expr) != 0) {

                // substring(indice1,indice2)

                // indice1, indice2 -> será usado para delimitar a string

                var tst1 = val.value.substring(0, (i));
                val.value = tst1;
                continue;
            }



            if ((nchar != '/') && (nchar != '')) {

                var tst1 = val.value.substring(0, (i) + 1);
                if (nchar.search(expr) != 0)
                    var tst2 = val.value.substring(i + 2, pass.length);
                else
                    var tst2 = val.value.substring(i + 1, pass.length);
                val.value = tst1 + '/' + tst2;
            }



        } else if (i == 4) {



            if (lchar.search(expr) != 0) {

                var tst1 = val.value.substring(0, (i));
                val.value = tst1;
                continue;
            }



            if ((nchar != '/') && (nchar != '')) {

                var tst1 = val.value.substring(0, (i) + 1);
                if (nchar.search(expr) != 0)
                    var tst2 = val.value.substring(i + 2, pass.length);
                else
                    var tst2 = val.value.substring(i + 1, pass.length);
                val.value = tst1 + '/' + tst2;
            }

        }



        if (i >= 6) {

            if (lchar.search(expr) != 0) {

                var tst1 = val.value.substring(0, (i));
                val.value = tst1;
            }

        }

    }



    if (pass.length > 10)
        val.value = val.value.substring(0, 10);
    return true;
}





