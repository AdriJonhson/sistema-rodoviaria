var selectOrigem               = document.getElementById('origem');
var ultimo_assento_selecionado = 0;
var assento_selecionado        = null;
var escolha                    = 0;


selectOrigem.addEventListener('change', function(){

	$('#destino').empty();

	var id_origem = this.value;

	//Verificando a página que está execuntado o script e definindo como chegar no arquivo de rotas
	pag_atual = getPaginaAtual();

	if(pag_atual != 'index.php'){
		var url_route = '../routes.php';
	}else{
		var url_route = 'routes.php'
	}

	getDestinos(url_route, id_origem);
});


function getPaginaAtual()
{
	var url_atual = window.location.href;

	var pag = url_atual.split('/');

	var pag_atual = pag[pag.length - 1];

	if(pag_atual == ""){
		pag_atual = 'index.php';
	}

	return pag_atual;
}




function carregarAssentos(poltronasOcupadas)
{

	var imagens = document.getElementsByTagName('img');

	var livre = "../public/images/livre.png";
	var ocupado = "../public/images/ocupado.png";
	var selecionado = "../public/images/usuario.png";

	for(var i = 0; i < imagens.length; i++){
		//Problema: Somar mais 1 pois os números da poltrona não começam no ZERO
		if(poltronasOcupadas.indexOf((1 + i)+ "") != -1){
			imagens[i].src = ocupado;
		}else{
			imagens[i].src = livre;
			imagens[i].name = i;

			imagens[i].addEventListener('click', function(){
				selecionarPoltrona(parseInt(this.name) + 1);

				escolha += 1;

				if(escolha == 0){
					ultimo_assento_selecionado = this.id;
					assento_selecionado = this.id;
				}else{
					ultimo_assento_selecionado = assento_selecionado;
					assento_selecionado = this.id;
				}

				trocarCor(ultimo_assento_selecionado, assento_selecionado);
			});
		}
	}
}

function verificarPoltronasLivre(id)
{
	$.ajax({
		type: "POST",
		url: "../routes.php",
		data: {acao: 'verificarPoltronas', idRota: id},
		dataType: 'json',
		success: function (json) {
           // console.log(json[2][0]);
           //console.log(json.length);

           var poltronasOcupadas = [];

           for(var i = 0; i < json.length; i++){
           	poltronasOcupadas.push(json[i][0]);
           }

           carregarAssentos(poltronasOcupadas);

        },
        error: function(data){
        	aler('Erro no AJAX');
        	console.log(data);
        }
	});
}

function selecionarPoltrona(numPoltrona)
{
	var spanNumPoltrona = document.getElementById('spanNumPoltrona');
	var poltronaSelecionada = document.getElementById('poltronaSelecionada');
	var btnContinuar = document.getElementById('btnContinuar');


	spanNumPoltrona.innerHTML = "<b>"+numPoltrona+"</b>";
	poltronaSelecionada.value = numPoltrona;
	btnContinuar.disabled = false;
}

function setIdRota(idRotaSelecionada)
{
	var idRota = document.getElementById('idRota');
	idRota.value = idRotaSelecionada;
}

//select - index.php
function getDestinos(url_route, id_origem)
{
	$.ajax({
		type: "POST",
		url: url_route,
		data: {acao: 'getDestinos', id_origem: id_origem},
		dataType: 'json',
		success: function (data) {
           
        	data.forEach(function(cidade_destino){
        		$('#destino').append('<option value = '+ cidade_destino.id +' >'+ cidade_destino.destino +'</option>');
        	});

        },
        error: function(data){
        	alert('Erro no AJAX');
        	console.log(data);
        }
	});
}

//Função que troca a cor da poltrona quando selecionado pelo usuário
function trocarCor(id_assento_anterior, id_assento_selecionado)
{
	var assento_anterior     = document.getElementById(id_assento_anterior);
	var assento_selecionado  = document.getElementById(id_assento_selecionado);

	var selecionado = "../public/images/usuario.png";
	var livre       = "../public/images/livre.png";

	assento_selecionado.src = selecionado;
	assento_anterior.src    = livre;
}

//Limpa o span do número da poltrona quando o modal for fechado
$('#modalPoltronas').on('hidden.bs.modal', function () {
	var spanNumPoltrona = document.getElementById('spanNumPoltrona');
	spanNumPoltrona.innerHTML = "";
	btnContinuar.disabled = true;
});