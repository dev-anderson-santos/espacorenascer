function modalGlobalOpen( url , _title , _effect )
{

	let title  = _title || "";
	let effect = _effect || "fadeIn"; //expand | fadeIn | contract | wiggle | lightSpeedIn

	var modalGlobal = $( '#modalGlobal' );
	// evitar de fechar o modal clicando fora
	modalGlobal.modal( { backdrop: 'static' , keyboard: false } );
	modalGlobal.find( '.modal-title' ).text( title );

	// encapsulamento do modal-body
	var body = modalGlobal.find( '.modal-body' );

	$.ajax( {
		url        : url ,
		method     : 'get' ,
		beforeSend : function() {
			// trazendo o conteudo do carregamento.blade para evita requisições extras
			// let rand = '_'+Math.floor( (Math.random() * 10000) + 1 );
			body.html( '<div class="container-carregando" >\n' +
						   '<div>\n' +
							   '<i class="fa fa-spinner fa-pulse hidden-xs"></i>\n' +
							//    '<p>Carregando</p>\n' +
							//    '<p>Carregando <span id="'+rand+'">.</span></p>\n' +
						   '</div>\n' +
					   '</div>' );
			// carregamento( rand );
		} ,
	} ).done( function( data ) {
		body.html( data );
	} ).fail( function(error, errorThrown ) {
		if (error.status == 401) {
			setInterval(function () {
				body.html( "<div class='alert alert-info text-center'><i class='fa fa-exclamation-triangle fa-2x fa-fw'></i> <strong style='font-size: 20px;'>A sessão expirou, você será redirecionado(a) a tela de login.</strong></div>" );
			}, 3000);

			// location.reload();
		} else {
			body.html( "<div class='alert alert-danger text-center'><i class='fa fa-exclamation-triangle fa-2x fa-fw'></i> <strong style='font-size: 20px;'>Ocorreu um erro ao carregar os dados!</strong></div>" );
		}
	} );
}

function carregamento( id )
{
	let string = "...";
	let elem   = $( 'span#'+id );
	setInterval( function() {
		let len = elem.text().length;
		if( len < string.length )
			elem.text( elem.text() + string.substring( len , len + 1 ) );
		else
			elem.empty();
	} , 200 );
}