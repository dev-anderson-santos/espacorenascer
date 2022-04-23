var button_gerenciar_medias;
var count_form_submit = 0;
var container_imagens_familias;






    function modal_basic(titulo = '', conteudo = '', cor = '#88888', redirect = '', id = 'exampleModalCenter') {



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
            <div class="modal-footer">\
                <button type="button" class="btn fechar-modal btn-secondary" ' + (redirect ? 'onclick="location=\'' + redirect + '\'"' : '') + ' style="background: ' + cor + '; border-color: ' + cor + ';" data-dismiss="modal">Fechar</button>\
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->\
            </div>\
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

        botao2 = (botao2 ? '<button type="button" class="btn btn-secondary btn-danger" onclick="' + (botao2 == "Terminar de preencher os formulários" || botao2 == "Enviar depois" || botao2 == "Fechar" || botao2 == "Carregar outro arquivo" ? "$('.modal').modal('hide');" : "window.location.reload()") + '" >' + botao2 + '</button>' : '');
        botao1 = (botao1 == 'false' ? '' : '<button type="button" class="btn btn-primary fechar-modal" onclick="' + (funcao ? funcao : '') + '">' + botao1 + '</button>');
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
                <div class="modal-footer ' + (!botao1 && !botao2 ? 'd-none' : '') + '">\
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





var table;
var click;
$(document).ready(function () {

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


	
    $('.alert').alert();
    

    $('body').on('click', '.fechar-modal, .modal-header .close', function () {

        var modal = $(this);
        //console.log('remover1');

        window.setTimeout(function () {

            modal.parents('.modal').remove();
            $('.modal-backdrop').remove();
        }, 900);
    })

    $('body').on('click', '.modal', function () {

        var modal = $(this);
        //console.log('remover2');

        window.setTimeout(function () {

            if ($('.modal').css('display') == 'none') {

                $('.modal').remove();
                $('.modal-backdrop').remove();
            }

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





    };
	
    sizeOfThings();
    window.addEventListener('resize', function () {

        //sizeOfThings();

    });



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
   






		$( "body" ).on("click",".gerenciador-de-medias", function( e ) {
		  button_gerenciar_medias = $(this);
		  container_imagens_familias = $(this).parents('.container-imagens-familias');
			e.preventDefault();
			

			var inputs_text = '';
			var selects = '';
			var select_html = '';
			var form = '';

			var campos = 'name,title,description,category_id';
			var campos = campos.split(",");

			var dados = ',,,';
			var dados = dados.split(",");

			

			$.each(campos,function(index,value){
				if( value ){
					titulo_campo = value.replace('_',' ').toUpperCase();
					disabled = '';
					if( value == 'name' || value == 'path' || value == 'date_create' || value == 'id' ){
						disabled = 'disabled';
					}
					if( value == 'category_id' ){
						form += '<input type="hidden" value="10" name="'+value+'">';
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


			var detail = button_gerenciar_medias.attr("data-detail");

			//form = '<form>'+form+'</form>';
			conteudo = '<div class="tab-content container-fluid" id="nav-tabContent"><div class="tab-pane fade show active row" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"><div class="col-12"><div class="row"><div class="col-md-'+( detail == 'disabled' ? '12' : '6' )+' upload-image"><input id="media_upload" preview-input="media_upload" preview-img="imagem-preview-modal" preview-placeholder="placeholder-preview-modal" type="file" name="media_upload" style="width: 0; height: 0; position: absolute;"><div onclick="$(this).prev().click();" style="display: table; cursor: pointer; width: 100%; border-radius: 10px; background: #ededed;  margin: auto; min-height: 300px;"><img class="imagem-preview d-none" id="imagem-preview-modal" src="#" style="width: 100%;margin: auto; height: auto;"><span class="remover-span" style="font-size: 20px; color: #888; display: table-cell; text-align: center; margin: auto; vertical-align: middle;" id="placeholder-preview-modal">CLIQUE AQUI PARA<br>CARREGAR A IMAGEM</span></div></div><div class="col-md-6 detail" '+( detail == 'disabled' ? 'style="position: absolute; width: 0; height: 0; overflow: hidden; opacity: 0;"' : '' )+' ><div class="row">'+form+'</div></div></div></div></div><div class="tab-pane fade row" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">\
			<div class="col-12"><select id="category-medias">\
				'+select_html+'\
			</select></div>\
			<div class="row pb-3 pt-3 text-left m-auto mt-3 content-medias-modal">\
			</div></div> </div>';

			titulo = 'Gerenciador de Medias<br><br><nav><div class="nav nav-tabs" id="nav-tab" role="tablist"><a class="nav-item nav-link active tab-medias" data-id="upload" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Upload</a><a class="nav-item nav-link tab-medias" data-id="galeria" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Galeria</a></div></nav>';

			//modal(titulo,conteudo,campos='',funcao='',botao1='Salvar Edição',botao2='Deletar Imagem',id_form='detalhes-media');
			modal(titulo,conteudo,campos='',funcao="$(this).parents('form').submit();",botao1='Confirmar',false,id_form='gerenciador-de-medias','','',largura_modal='600px');

			var category_default = '10';
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
   
   




    $('body').on('submit', '.form-ajax_cliente', function (e) {



        e.preventDefault();
        var form = this;
        var dados = $(this);
        var form_redirect = $(this).attr('redirect');
        var get_form = $(this).attr('get-form');
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
                            //form.reset();
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
					
					if ( response.status == 'success' ) {
						if (form_redirect) {
							//response.id
							get_form = $('input[name='+get_form+']').val();
							if (url.indexOf("insert") != '-1') {
								form.reset();
							}
							location = form_redirect + get_form;
							
						}else{
							form.reset();
						}
					}
                },
                error: function (response) {
                    modal_basic(response.title, response.msg, 'red');
                }

            });
        }, 500);
    });
//ajax do Cliente endereco



   
    if ($(".imagem-preview").length > 0 && $(".imagem-preview").attr("src") != "") {
        $(".msg-image-preview").addClass('d-none');
        $(".gerenciador-de-medias").css('background', 'none');
    }




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










    function readImage() {

        if (this.files && this.files[0]) {

            var file = new FileReader();
            file.onload = function (e) {

                document.getElementById("preview").src = e.target.result;
            };
            file.readAsDataURL(this.files[0]);
        }

    }



    $("#imgChooser").on("change", readImage());



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





