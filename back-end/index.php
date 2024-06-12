<?php

header("Access-Control-Allow-Origin: *");

require("data/db_context.php");

$tipo = 0;

if(isset($_GET['tipo'])){
    $tipo = $_GET['tipo'];
}
else {
    $error = array('error' => 'Parametro TIPO não indicado na requisicao');
    echo json_encode($error);
}

$db_context = new DbContext();

$db_context->conectar();

//condição para adicionar um aluno
if($tipo == 1){
    if(isset($_GET['nome'])) {
        $nome = $_GET['nome'];
        $especie = $_GET['especie'];
        $raca = $_GET['raca'];
        $dataChegada = $db_context->formatData($_GET['dataChegada']);
        $dataNasci = $db_context->formatData($_GET['dataNasci']);

        $resultado = $db_context->adicionar($nome, $especie, $raca, $dataChegada, $dataNasci);
        echo $resultado;
    }else{
        $error = array('error' => 'Parametro NOME nao indicado na requisicao');
        echo json_encode($error);
    }
}
else if($tipo == 5){
    if (isset($_GET['nome'])){
        $nome = $_GET['nome'];
        $resultado = $db_context->consultaByName($nome);
        echo json_encode($resultado);
    }
    else{
        $error = array('error' => 'Parametro name não indicado na requisicao');
        echo json_encode($error);
    }
}
else if($tipo == 3){
    if (isset($_GET['nome'])){
        $nome = $_GET['nome'];
        $especie = $_GET['especie'];
        $raca = $_GET['raca'];
        $dataChegada = $db_context->formatData($_GET['dataChegada']);
        $dataNasci = $db_context->formatData($_GET['dataNasci']);

        $resultado = $db_context->atualizar($nome, $especie, $raca, $dataChegada, $dataNasci);
        echo $resultado;
    }
    else{
        $error = array('error' => 'Paramertro ID não indicado na requisicao');
        echo json_encode($error);
    }

    echo $resultado;
}
else if($tipo == 4){
    if (isset($_GET['nome'])){
        $nome = $_GET['nome'];

        $resultado = $db_context->deletar($nome);
        echo $resultado;
    }
    else{
        $error = array('error' => 'Paramertro ID não indicado na requisicao');
        echo json_encode($error);
    }
}
else if($tipo == 2){
    $resultado = $db_context->consultar();
    echo $resultado;
}

$db_context->desconectar();

?>