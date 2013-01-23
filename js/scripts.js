// JavaScript Document

function login() {
	var user = $('#username').val();
	var pass = $('#password').val();

	if( (user.length < 1 || pass.length < 1) && ($('.alert').length == 0) ) {
		$('#password').after('<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times</button>Dados incorrectos.</div>');
		return;
	}
	// change this to having the form sending the info directly. It may be vulnerable this way
	$.ajax({url:"./api/login.php", processData:"false", type:"POST", dataType:"JSON", data:{username:user, password:pass}}).done(function(response){
		if(response['result'] == "SUCCESS") {
			document.location.href='index.php';
		} else {
			if($('.alert').length == 0) {
				$('#password').after('<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times</button>Dados incorrectos.</div>');
			}
		}
	});
}

function loadPage() {
	$.ajax({url:"./api/getTaxes.php", type:"GET", processData:"false", dataType:"JSON"}).done(function(response){
		if(response['result'] == "SUCCESS") {
			var taxes = response['data'];
			if(taxes.length == 0) {
				$('body > .container').append('<div class="well well-large away-from-top">Não existem impostos na base de dados.</div>');
			} else {
				$('body > .container').append('<table class="table table-hover table-condensed away-from-top"></table>');
				$('table').append('<tr><th>Nome</th><th>NIF</th><th>Viatura</th><th>Matrícula</th><th>Data Limite</th><th></th></tr>');

				var overdueTaxes = false, nearLimitTaxes = false;
				for(var i = 0; i < taxes.length; i++) {
					var tax = taxes[i];
					$('table').append('<tr id="'+tax.id+'"></tr>');

					var now = new Date();
					var taxLimitDate = new Date(tax.dataLimitePagamento);
					var remainingDays = diffDaysToNow(new Date(tax.dataLimitePagamento)); // not working on Firefox

					if(remainingDays < 0) {
						overdueTaxes = true;
						$('table tr:last-child').addClass('info');
					} else {
						if(now.getFullYear() == taxLimitDate.getFullYear()) {
							if(now.getMonth() == taxLimitDate.getMonth()) {
								$('table tr:last-child').addClass('error');
								nearLimitTaxes = true;
							} else if(now.getMonth() == (taxLimitDate.getMonth() - 1)) {
								$('table tr:last-child').addClass('warning');
							} else {
								$('table tr:last-child').addClass('success');
							}
						} else {
							if((now.getMonth() == 11) && (taxLimitDate.getMonth() == 0)) {
								$('table tr:last-child').addClass('error');
							} else if((now.getMonth() == 11) && (taxLimitDate.getMonth() == 1)) {
								$('table tr:last-child').addClass('warning');
							} else {
								$('table tr:last-child').addClass('success');
							}
						}
					}
					$('table tr:last-child').append('<td><i class="icon-user"></i><a href="client.php?clientID='+tax.idCliente+'"> '+fillClientName(tax.nome)+'</a></td><td>'+tax.nif+'</td><td>'+tax.marca+' '+tax.modelo+'</td><td>'+tax.matricula+'</td><td>'+fillLimitDate(tax.dataLimitePagamento)+'</td>');
					$('table tr:last-child').append('<td><div class="btn-group"><button class="btn btn-inverse btn-mini">Opções</button><button class="btn btn-inverse btn-mini dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu"><li><a href="#" onclick="return changeTaxLimitDate('+tax.id+',1)"><i class="icon-ok"></i> Pago</a></li><li><a href="#" onclick="return changeTaxLimitDate('+tax.id+',2)"><i class="icon-remove"></i> Não Pago</a></li><li><a href="client.php?clientID='+tax.idCliente+'"><i class="icon-user"></i> Ver Perfil</a></li><li class="divider"></li><li><a href="#" onClick="return deleteTax('+tax.id+')"><i class="icon-trash"></i> Eliminar imposto</a></li></ul></div></td>');
				}
				if(overdueTaxes) {
					$('table').before('<div class="alert alert-error fade in away-from-top"><button type="button" class="close" data-dismiss="alert">&times</button><strong>Aviso!</strong> Há impostos cujo prazo já passou.</div>');
				}
				if(nearLimitTaxes) {
					$('table').before('<div class="alert alert-warning fade in away-from-top"><button type="button" class="close" data-dismiss="alert">&times</button><strong>Aviso!</strong> Há impostos cujo prazo está próximo.</div>');
					if(overdueTaxes) {
						$('div.alert-warning').removeClass('away-from-top');
					}
				}
			}
		} else {
			$('body > .container').append('<div class="alert alert-error fade in away-from-top"><strong>Ups!</strong> Alguma coisa correu mal. Tenta outra vez e se continuar a dar erro avisa-me.</div>');
		}
	});
}

function changeTaxLimitDate(taxID, option) {
	option == 1 ? option = "PAID" : option = "UNPAID";
	$.ajax({url:"./api/updateDateLimit.php", processData:"false", type:"GET", dataType:"JSON", data:{vehicleID:taxID, option:option}}).done(function(response){
		if(response['result'] == "SUCCESS") {
			window.location.reload(); // TEMPORARY. It should use AJAX to update the page without a refresh
		} else {
			alert('Ups! Alguma coisa correu mal. Tenta outra vez e se continuar a dar erro avisa-me.');
		}
	});
}

function addNewClient(option) { // if option is 1 it should show the alerts
	$('div.alert').remove();

	// validate the info
	var name = $('#newClientName').val();
	var address = $('#newClientAddress').val();
	var local = $('#newClientLocal').val();
	var parish = $('#newClientParish').val();
	var postal = $('#newClientPostal').val();
	var nif = $('#newClientNIF').val();

	var validInputs = true;
	var numberPatt = /[0-9]/i;
	var postalPatt = /^[0-9]{4}(-[0-9]{3}){0,1}$/i;
	var nifPatt = /^(1|2|5|6|8|9)[0-9]{8}$/i

	if(name.length < 2 || numberPatt.test(name)) { // invalid name
		validInputs = false;
		$('#newClientName + .help-inline').html('O nome deve ter pelo menos 2 caracteres e não pode ter números.');
		$('#newClientName').parent().parent().addClass('error');
	} else {
		$('#newClientName + .help-inline').html('');
		$('#newClientName').parent().parent().removeClass('error');
	}

	if(address <= 5) { // invalid
		validInputs = false;
		$('#newClientAddress + .help-inline').html('A morada deve ter pelo menos 6 caracteres.');
		$('#newClientAddress').parent().parent().addClass('error');
	} else {
		$('#newClientAddress + .help-inline').html('');
		$('#newClientAddress').parent().parent().removeClass('error');
	}

	if(local.length < 3 || numberPatt.test(local)) { // invalid local
		validInputs = false;
		$('#newClientLocal + .help-inline').html('A localidade deve ter pelo menos 3 caracteres e não pode ter números.');
		$('#newClientLocal').parent().parent().addClass('error');
	} else {
		$('#newClientLocal + .help-inline').html('');
		$('#newClientLocal').parent().parent().removeClass('error');
	}

	if(parish.length < 3 || numberPatt.test(parish)) { // invalid parish
		validInputs = false;
		$('#newClientParish + .help-inline').html('A freguesia deve ter pelo menos 3 caracteres e não pode ter números.');
		$('#newClientParish').parent().parent().addClass('error');
	} else {
		$('#newClientParish + .help-inline').html('');
		$('#newClientParish').parent().parent().removeClass('error');
	}

	if(!postalPatt.test(postal)) { // invalid postal
		validInputs = false;
		$('#newClientPostal + .help-inline').html('O código postal deve ter o formato XXXX ou XXXX-XXX.');
		$('#newClientPostal').parent().parent().addClass('error');
	} else {
		$('#newClientPostal + .help-inline').html('');
		$('#newClientPostal').parent().parent().removeClass('error');
	}

	if(!nifPatt.test(nif)) { // invalid nif
		validInputs = false;
		$('#newClientNIF + .help-inline').html('O NIF deve ter 9 algarismos e começar por 1, 2, 5, 6, 8 ou 9.');
		$('#newClientNIF').parent().parent().addClass('error');
	} else {
		$('#newClientNIF + .help-inline').html('');
		$('#newClientNIF').parent().parent().removeClass('error');
	}

	if(validInputs) {
		$.ajax({url:"./api/addNewClient.php", processData:"false", type:"POST", dataType:"JSON", data:{name:name, address:address, local:local, parish:parish, postal:postal, nif:nif}}).done(function(response){
			if(response['result'] == "SUCCESS") {
				fullFormReset();
				if(option == 1) {
					$('form#newClient').after('<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">&times</button>O cliente foi adicionado com sucesso.</div>');
				}
			} else {
				if(option == 1) {
					$('form#newClient').after('<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times</button><strong>Ups!</strong> Alguma coisa correu mal. Tenta outra vez e se continuar a dar erro avisa-me.</div>');
				}
			}
			setTimeout(function() {
				$('div.alert').remove();
			}, 10000);
		});
	}
}

function addTaxToExistingClient() {
	$('#newTaxTypeClient').remove();
	$('body > .container').append('<form class="form-horizontal away-from-top" id="newTax"></form>');
	$('#newTax').append('<div class="control-group"><label class="control-label" for="inputClient">Cliente</label><div class="controls"><select></select></div></div>');

	// fill the select
	$.ajax({url:"./api/getClientList.php", processData:"false", type:"GET", dataType:"JSON"}).done(function(response){
		if(response['result'] == "SUCCESS") {
			var clients = response['data'];
			for(var i = 0; i < clients.length; i++) {
				var currClient = clients[i];
				$('select').append('<option value="'+currClient.id+'">'+currClient.nome+'</option>');
			}
		} else {
			alert('Ups! Alguma coisa correu mal na listagem dos clientes. Tenta outra vez e se continuar a dar erro avisa-me.');
		}
	});

	$('#newTax').append('<div class="control-group"><label class="control-label" for="inputBrand">Marca</label><div class="controls"><input type="text" id="newTaxBrand" placeholder="Marca"><span class="help-inline"></span></div></div>');
	$('#newTax').append('<div class="control-group"><label class="control-label" for="inputModel">Modelo</label><div class="controls"><input type="text" id="newTaxModel" placeholder="Modelo"><span class="help-inline"></span></div></div>');
	$('#newTax').append('<div class="control-group"><label class="control-label" for="inputLicencePlate">Matrícula</label><div class="controls"><input type="text" id="newTaxLicencePlate" placeholder="Matrícula"><span class="help-inline"></span></div></div>');
	$('#newTax').append('<div class="control-group"><label class="control-label" for="inputLicencePlateDate">Data Matrícula</label><div class="controls"><input type="text" id="newTaxLicencePlateDate" placeholder="YYYY-MM-DD"><span class="help-inline"></span></div></div>');
	$('#newTax').append('<div class="control-group"><label class="control-label" for="inputLimitDate">Data Limite</label><div class="controls"><input type="text" id="newTaxLimitDate" placeholder="YYYY-MM-DD"><span class="help-inline"></span></div></div>');
	$('#newTax').append('<div class="controls"><button type="button" class="btn btn-success" onClick="return addTaxToExistingClientAux()">Adicionar</button><button type="reset" class="btn" onClick="return resetForm()">Apagar</button></div>');
}

function addTaxToExistingClientAux() {
	$('div.alert').remove();
	// validate the info
	var brand = $('#newTaxBrand').val();
	var model = $('#newTaxModel').val();
	var licencePlate = $('#newTaxLicencePlate').val();
	var licencePlateDate = $('#newTaxLicencePlateDate').val();
	var limitDate = $('#newTaxLimitDate').val();

	var validInputs = true;
	var brandPatt = /^[a-zA-z]{2,}$/i;
	var licencePatt = /^(([a-zA-z]|[0-9]){2}-){2}([a-zA-z]|[0-9]){2}$/i
	var datePatt = /^(1|2)(9|0)[0-9]{2}-((0[1-9]{1})|(1[0-2]{1}))-((0[1-9]{1})|((1|2)[0-9]{1})|(3[0-1]{1}))$/i;

	if(!brandPatt.test(brand)) { // invalid brand
		validInputs = false;
		$('#newTaxBrand + .help-inline').html('A marca deve ter pelo menos 2 caracteres e não ter números nem símbolos.');
		$('#newTaxBrand').parent().parent().addClass('error');
	} else {
		$('#newTaxBrand + .help-inline').html('');
		$('#newTaxBrand').parent().parent().removeClass('error');
	}

	if(model.length < 2) { // invalid model
		validInputs = false;
		$('#newTaxModel + .help-inline').html('O modelo deve ter pelo menos 2 caracteres.');
		$('#newTaxModel').parent().parent().addClass('error');
	} else {
		$('#newTaxModel + .help-inline').html('');
		$('#newTaxModel').parent().parent().removeClass('error');
	}
	
	if(!licencePatt.test(licencePlate)) { // invalid licence plate
		validInputs = false;
		$('#newTaxLicencePlate + .help-inline').html('Este formato de matrícula é inválido.');
		$('#newTaxLicencePlate').parent().parent().addClass('error');
	} else {
		$('#newTaxLicencePlate + .help-inline').html('');
		$('#newTaxLicencePlate').parent().parent().removeClass('error');
	}

	if(!datePatt.test(licencePlateDate)) { // invalid licence plate date
		validInputs = false;
		$('#newTaxLicencePlateDate + .help-inline').html('Data inválida. Usa o formato YYYY-MM-DD.');
		$('#newTaxLicencePlateDate').parent().parent().addClass('error');
	} else {
		$('#newTaxLicencePlateDate + .help-inline').html('');
		$('#newTaxLicencePlateDate').parent().parent().removeClass('error');
	}

	if(!datePatt.test(limitDate)) { // invalid licence plate date
		validInputs = false;
		$('#newTaxLimitDate + .help-inline').html('Data inválida. Usa o formato YYYY-MM-DD.');
		$('#newTaxLimitDate').parent().parent().addClass('error');
	} else {
		$('#newTaxLimitDate + .help-inline').html('');
		$('#newTaxLimitDate').parent().parent().removeClass('error');
	}

	if(validInputs) {
		$.ajax({url:"./api/addNewTax.php", processData:"false", type:"POST", dataType:"JSON", data:{brand:brand, model:model, licence:licencePlate, licenceDate:licencePlateDate, limit:limitDate, clientID:($('select').val())}}).done(function(response){
			//console.log(response);
			if(response['result'] == "SUCCESS") {
				fullFormReset();
				$('form#newTax').after('<div class="alert alert-success fade in"><button type="button" class="close" data-dismiss="alert">&times</button>O imposto foi adicionado com sucesso.</div>');
			} else {
				$('form#newTax').after('<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times</button><strong>Ups!</strong> Alguma coisa correu mal. Tenta outra vez e se continuar a dar erro avisa-me.</div>');
			}
			setTimeout(function() {
				$('div.alert').remove();
			}, 10000);
		});
	}
}

function addNewTask() {
	//$('.modal-footer > .alert').remove();

	var task = $('textarea').val();
	var limitDate = $('#inputDate').val();
	var noError = true;
	var datePatt = /^(1|2)(9|0)[0-9]{2}-((0[1-9]{1})|(1[0-2]{1}))-((0[1-9]{1})|((1|2)[0-9]{1})|(3[0-1]{1}))$/i;

	if(task.length < 3) {
		noError = false;
		if($('#newTask .alert').length == 0) {
			$('#cancelBtn').before('<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times</button>A tarefa é demasiado curta. 3 caracteres no mínimo.</div>');
		} else {
			$('#newTask .alert').html('<button type="button" class="close" data-dismiss="alert">&times</button>A tarefa é demasiado curta. 3 caracteres no mínimo.');
		}
	}
	if(limitDate.length > 0 && !datePatt.test(limitDate)) {
		noError = false;
		$('#inputDate + span').html('Data inválida.').parent().addClass('error');
	}
	if(noError) {
		if(limitDate.length == 0) {
			limitDate = "1988-11-11 08:00:00";
		}
		var priority = $('button.active').html();
		if(priority == "Baixa") {
			priority = 3;
		} else if (priority == "Normal") {
			priority = 2;
		} else {
			priority = 1;
		}

		$.ajax({url:"./api/addNewTask.php", processData:"false", type:"GET", dataType:"JSON", data:{task:task, date:limitDate, priority:priority}}).done(function(response){
			if(response['result'] == "SUCCESS") {
				window.location.reload();
				$('#newTask').modal('hide');
			} else {
				$('.modal-footer > .alert').remove();
				if($('#newTask .alert').length == 0) {
					$('#cancelBtn').before('<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times</button><strong>Ups!</strong> Alguma coisa correu mal. Tenta outra vez.</div>');
				} else {
					$('#newTask .alert').html('<button type="button" class="close" data-dismiss="alert">&times</button><strong>Ups!</strong> Alguma coisa correu mal. Tenta outra vez.');
				}
			}
		});
	}
}

function removeTask(taskID) {
	$.ajax({url:"./api/removeTask.php", processData:"false", type:"GET", dataType:"JSON", data:{id:taskID}}).done(function(response){
		if(response['result'] == "SUCCESS") {
			$('#'+taskID).fadeOut().remove();
		}
	});
}

function resetForm() {
	$('.help-inline').html('');
	$('.help-inline').parent().parent().removeClass('error');
}

function fullFormReset() {
	resetForm();
	$('input').val('');
}

function clearModal() {
	$('textarea').val('');
	$('#inputDate').val('');
	$('.modal-footer > .alert').remove();
}

function fillClientName(name) {
	var nameLength = name.length;
	var posFirst = name.indexOf(' ');
	
	if(posFirst == -1)
		return name;
	else {
		var posLast = name.lastIndexOf(' ');
		var firstName = name.substr(0, posFirst);
		var lastName = name.substr(posLast+1, nameLength - posLast+1);
		var newName = firstName + ' ' + lastName;
		return newName;
	}
}

function fillLimitDate(date) {
	var pos = date.indexOf(' ');
	return date.substr(0, pos);	
}

function diffDaysToNow(date) {
	var now = new Date();
	var diffDates = date - now;
	return Math.round(( (Math.round(diffDates / 1000) / 60) / 60) / 24);
}