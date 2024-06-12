document.getElementById('cadastrar').addEventListener('click',function(){
    var nome = document.getElementById('nome').value;
    var especie = document.getElementById('especie').value;
    var raca = document.getElementById('raca').value;
    var dataChegada = document.getElementById('dataChegada').value;
    var dataNasci = document.getElementById('dataNasci').value;

    fazerRequisicao(1, nome, especie, raca, dataChegada, dataNasci);
});

document.getElementById('listar').addEventListener('click',function(){
    fazerRequisicao(2, undefined, undefined, undefined, undefined);
});

document.getElementById('atualizar').addEventListener('click',function(){
    var nome = document.getElementById('nomeAtt').value;
    var especie = document.getElementById('especieAtt').value;
    var raca = document.getElementById('racaAtt').value;
    var dataChegada = document.getElementById('dataChegadaAtt').value;
    var dataNasci = document.getElementById('dataNasciAtt').value;
    
    fazerRequisicao(3, nome, especie, raca, dataChegada, dataNasci);
});

document.getElementById('consultar').addEventListener('click',function(){
    var nome = document.getElementById('nomeCon').value;
    fazerRequisicao(5 , nome, undefined, undefined, undefined, undefined);
});

document.getElementById('deletar').addEventListener('click',function(){
    var nome = document.getElementById('nomeDel').value;

    fazerRequisicao(4, nome, undefined, undefined, undefined, undefined);
});


function fazerRequisicao(tipo, nome, especie, raca, dataChegada, dataNasci) {
    var url = `http://localhost/phpOng/back-end/index.php?tipo=${tipo}&`;

    if(nome != undefined){
        url += `nome=${nome}&`;
    }

    if(especie != undefined){
        url += `especie=${especie}&`;
    }

    if(raca != undefined){
        url += `raca=${raca}&`;
    }

    if(dataChegada != undefined){
        url += `dataChegada=${dataChegada}&`;
    }

    if(dataNasci != undefined){
        url += `dataNasci=${dataNasci}&`;
    }

    fetch(url, {method: 'get'}).then(function(response){

        if(tipo == 2){
            console.log("tipo2");
            return response.json();
        }else if( tipo == 5){
            return response.json();
        }
    }).then(function(data){

        if(tipo == 2){
            let animais = data;
            let table = document.getElementsByTagName("table");
            let linhas = "";

            for (var i = 0; i < animais.length; i++){
                linhas += "<tr>"
                + `<td>${animais[i].nome}</td>`
                + `<td>${animais[i].raca}</td>`
                + "</tr>"
            }

            table[0].innerHTML = "";

            table[0].innerHTML = "<tr>"
            + "<th>Nome</th>"
            + "<th>Raca</th>"
            + "</tr>"
            + linhas;
        }
        else if(tipo == 5){
            let animal = JSON.parse(data);
            console.log(animal);
            let nome = document.getElementById("nomeInf");
            let especie = document.getElementById("especieInf");
            let raca = document.getElementById("racaInf");
            let nasci = document.getElementById("nasciInf");
            let chegada = document.getElementById("chegadaInf");
            nome.innerHTML  = nome.innerHTML + `<text>${animal[0].nome.toUpperCase()}</text>`;
            especie.innerHTML  = especie.innerHTML + `<text>${animal[0].especie.toUpperCase()}</text>`;
            raca.innerHTML  = raca.innerHTML + `<text>${animal[0].raca.toUpperCase()}</text>`;
            nasci.innerHTML  = nasci.innerHTML + `<text>${formatData(animal[0].dataNascimento)}</text>`;
            chegada.innerHTML  = chegada.innerHTML + `<text>${formatData(animal[0].dataChegada)}</text>`;
        }   
    });

    document.getElementById('nome').value = "";
    document.getElementById("especie").value = "";
    document.getElementById("raca").value = "";
    document.getElementById("dataChegada").value = "";
    document.getElementById("dataNasci").value = "";
}

function formatData(stringDate){
    let dia = stringDate.substring(8,10);
    let mes = stringDate.substring(5,7);
    let ano = stringDate.substring(0,4);
    let dateOK = dia + "/" + mes + "/" + ano;
    return dateOK;
  }