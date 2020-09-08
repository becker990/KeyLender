function d(msg) {
	 console.log(msg);
}

function do_login(senha) {
	
	senha = $("#inputPassword").val();
	
	$.ajax({
	  method : "POST",
	  url    : "api.php",
	  data   : {
		method : "get_login",		
		senha : senha,	
	  },
	  success: function(r) {
		
		d(r);
		
		var obj = jQuery.parseJSON(r);
		
		if (obj == "OK")
			window.location.replace("armarios.php");
		else
			alert("Senha Incorreta");
	  }
	});
}

function do_logout() {

	$.ajax({
	  method : "POST",
	  url    : "api.php",
	  data   : {
		method : "get_logout",		
	  },
	  success: function(r) {
		
		var obj = jQuery.parseJSON(r);
		
		if (obj == "OK")
			window.location.replace("login.php");
		
	  }
	});
}

function cel_vazia() {
	
	var ret = "";
	
	ret += '<div class="dsp-vazia"></div>';
	
	return ret;
	
}

function cel_ocupada(foto, cartao, nome) {
	
	var ret = "";	
				
	ret += '<img src="' + foto +'" class="meupro mx-auto d-block img-fluid">';

	ret += '<div class="dsp-cartao text-center">' + cartao + '</div>';
	
	ret += '<div class="dsp-nome overflow-hidden text-break">' + nome +'</div>';
	
	return ret;
	
}

function render_armarios(arr) {
	
	var ret = "";
	
	var num = 0;		
	
	for (var a = 0; a < 5; a++) {	
		ret += '<div class="col-md armario m-1 py-3">';
		//ret += '<div class="armario">';
			

	 
			for (var j = 0; j < 4; j++) { 				
				ret += '<div class="row">';
		
				for (var i = 0; i < 2; i++) {											
					ret += '<div class="col p-2">';
					ret += '<div class="celula">';
					
					
						
						ret += '<div class="dsp-num"><strong>' + (num + 1)+'</strong></div>';
					
						if (arr[num]['status'] == "1"){
							
							foto   = 'fotos/' + arr[num]["cartao"] + '.jpg';
							cartao = arr[num]["cartao"];
							nome   = arr[num]["nome"];
							
							ret += cel_ocupada(foto, cartao, nome);
						} else {
							ret += cel_vazia();
						}						
						num++;
					
					ret += "</div>";			
					ret += "</div>";			
				}			
				
				ret += "</div>";
			}
						
		//ret += "</div>";
		ret += "</div>";
	}

	$("#mycont").html(ret);
}

function fill_home() {
	
	$.ajax({
	  method : "GET",
	  url    : "apikeys.php",	  
	  success: function(r) {
		
		var obj = jQuery.parseJSON(r);
		
		d(obj);
		
		render_armarios(obj);
				
	  }
	});
	
	$("#codbarra").focus();

};

function ask_chave() {
	var result = null;
	$.ajax({
	  method : "POST",
	  url    : "api.php",
	  async  : false,
	  data   : {
		method: "ask_chave"
	  },
	  success: function(r) {
		
		result = jQuery.parseJSON(r);
			
	  }
	});
	return result;	
};

function aluno_login() {
		
	$.ajax({
				method : "POST",				
				url    : "api.php",	 
				data   : {
							'method' : "aluno_login",
							'cartao' : $("#cartao").val(),
							'senha'  : $("#senha").val(),
						}
			}).done( function(r1, code, xhr) {

				//d("r1" + r1);
				
				nome = jQuery.parseJSON(r1);

				if (nome == "FALSE"){
					alert("Senha incorreta.");
					return;
				}

				var sugestao = ask_chave();

				if (sugestao == "FULL"){		
					alert("Armários lotados.");
					fill();
					return;
				}
					
				var greet = "ALUNO: " + nome + "\n\n";
				var greet = greet + "CARTAO: " + $("#cartao").val() + "\n\n";
					
				var id_chave = prompt(greet + "Chave sugerida número: " + sugestao + "\n\n", sugestao);

				id_chave = parseInt(id_chave);

				if(isNaN(id_chave) || !Number.isInteger(id_chave) || id_chave < 1 || id_chave > 40){
					alert("Chave não existe.");					
					return;
				}
					
				$.ajax({
							method : "POST",
							url    : "api.php",							
							data   : {
										'method'   : "get_chave",
										'id_chave' : id_chave,
										'cartao'   : $("#cartao").val(),
										'nome'     : nome,
									}
						}).done(function (r2, code2, xhr2) {

							d(r2);

							result = jQuery.parseJSON(r2);

							if (result == "OCCUPIED"){		
								alert("Chave ocupada.");
								return;
							}

							if (result == "OUTOFBOUNDS"){		
								alert("Chave fora dos limites.");
								return;
							}

							if (result == "ISNOTINT"){		
								alert("Chave não existe.");
								return;
							}
							
							if (result == "OK"){								
								$("#cartao").val("");
								$("#senha").val("");
								$("#cartao").focus();
							}
						
							fill();

						});// sucess
			});// ajax aluno_login
	
};//aluno_login()

function render_historico(hist) {

	var ret = "";
	
	for ( var line in hist) {
				
		var id_transacao = hist[line]["id_transacao"];
		var id_chave     = hist[line]["id_chave"];
		var operacao     = hist[line]["operacao"];
		var cartao       = hist[line]["cartao"];
		var data_hora    = hist[line]["data_hora"];
		
		
		
		if (operacao == 1) {
			operacao = "Retirada";
		} else {
			operacao = "Devolução";
		}	
		
		ret = ret + "<tr>" +
					  "<th>" + id_transacao + "</th>" +
					  "<td>" + id_chave     + "</td>" +					  					  
					  "<td>" + operacao     + "</td>" +					  			
					  "<td>" + cartao       + "</td>" +					  			
					  "<td>" + data_hora    + "</td>" +
					"</tr>";
		
	}
	
	$("#historico_tabela").html(ret);
}
	
function fill_tabela() {
	
	$.ajax({
	  method : "POST",
	  url    : "api.php",
	  data   : {
		method : "get_historico",		
	  },
	  success: function(r) {
		
		d(r);
		
		var obj = jQuery.parseJSON(r);
		
		render_historico(obj);		
		
	  }
	});

}


function devolver_chave() {
	
	codbarra = $("#codbarra").val();
				
	codbarra = parseInt(codbarra);
	
	if(!Number.isInteger(codbarra)){
			alert("Chave não existe.");
			return;
		}
		
		if(codbarra < 0){
			alert("Chave não existe.");
			return;
		}
		
		$.ajax({
					method : "POST",
					url    : "api.php",
					cache: false,				  
					data   : {
					method   : "devolve_chave",
					codbarra : codbarra,					
					},
				}).done(function(r) {

					//d(r);

					result = jQuery.parseJSON(r);

					if (result == "DEV"){		
						alert("Chave não está em uso.");
					}

					if (result == "FALSE"){		
						alert("Não executada.");
					}

					$("#codbarra").val("");

					fill();

					
				});
		
		fill();
	
}
	

$(function() {
   
	d("main.js")
	
		
	$("#btn-login").click( function(e) {
		
		e.preventDefault();
		
		do_login();
		
	});	
	
	$("#btn-logout").click( function(e) {
		
		e.preventDefault();
		
		do_logout();
		
	});	
	
	$("#cartao").on('keypress',function(e) {		
		if(e.which == 13) {
			e.preventDefault();
			$("#senha").focus();
		}
	});
	
	$("#btn-login").click(function(e) {
		e.preventDefault();
		
		aluno_login();			
	});
	
	$("#btn-devolver").click(function(e) {
		
		e.preventDefault();
	
		devolver_chave();
		
		
	});		
	
});

