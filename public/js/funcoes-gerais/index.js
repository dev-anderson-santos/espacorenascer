function logout() {
    $.get('logout', function (params) {
        location.replace('/');
    })
}

function clearForm(oForm){
    
    if(oForm != undefined) {
        var frm_elements = oForm.elements;
        for (i = 0; i < frm_elements.length; i++)
        {
            field_type = frm_elements[i].type.toLowerCase();
            switch (field_type)
            {
            case "text":
            case "number":
            case "password":
            case "textarea":
                frm_elements[i].value = "";     
                break;
            case "radio":
            case "checkbox":
                if (frm_elements[i].checked)
                {
                    frm_elements[i].checked = false;
                }
                break;
            case "select-one":
            case "select-multi":
                frm_elements[i].selectedIndex = 0;
                break;
            case "button":
                frm_elements[i].click();
                break;
            default:
                break;
            }
        }
    }
}

function validarCPF(cpf)
{
	cpf = cpf.replace( /[^\d]+/g , '' );
	if( cpf.length != 11 ) return false;

	// Elimina CPFs invalidos conhecidos
	if(
		cpf == "00000000000" ||
		cpf == "11111111111" ||
		cpf == "22222222222" ||
		cpf == "33333333333" ||
		cpf == "44444444444" ||
		cpf == "55555555555" ||
		cpf == "66666666666" ||
		cpf == "77777777777" ||
		cpf == "88888888888" ||
		cpf == "99999999999" )
		return false;

	// Valida 1o digito
	let add = 0;
	for( let i = 0 ; i < 9 ; i++ )
		add += parseInt( cpf.charAt( i ) ) * (10 - i);
	let rev = 11 - (add % 11);
	if( rev == 10 || rev == 11 )
		rev = 0;
	if( rev != parseInt( cpf.charAt( 9 ) ) )
		return false;
	// Valida 2o digito
	add = 0;
	for( let i = 0 ; i < 10 ; i++ )
		add += parseInt( cpf.charAt( i ) ) * (11 - i);
	rev = 11 - (add % 11);
	if( rev == 10 || rev == 11 )
		rev = 0;
	if( rev != parseInt( cpf.charAt( 10 ) ) )
		return false;
	return true;
}

function removeFeedbackMessageValidation(fieldId, classElementGroup) {
    if ($(fieldId).hasClass('is-invalid')) {
        $(`${classElementGroup} .invalid-feedback`).hide();
        $(fieldId).removeClass('is-invalid');
    }
}

function doNotPermitMoreThanOneSpace(textField) {
    return textField.replace(/\s\s+/g, ' ');
}

function reloadDataTableHtml($table, html) {
    // destroy
    $($table).DataTable().destroy();
    // insert
    $($table).find('tbody').html(html);
    // create
    $($table).removeClass('runDataTable');
    // $($table).DataTable();
}

function reloadTableHtml($table, html) {
    // destroy
    $($table).DataTable().destroy();
    // insert
    $($table).find('tbody').html(html);
    // create
    $($table).removeClass('runDataTable');
    // $($table).DataTable();
}