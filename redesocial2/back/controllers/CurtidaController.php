<?php

require_once __DIR__ . "/../models/CurtidaModel.php";

function receberDadosCurtida(){
    $dados = json_decode(
        file_get_contents("php://input"), true
    );

    if(!is_array($dados)){
        http_response_code(400);
        echo json_encode([
            "erro" => "Envie um objeto JSON com dados!"
        ]);
        return null;
    }

    foreach(["id_usuario", "id_publicacao"] as $campo){
        if(!isset($dados[$campo]) ||
           filter_var($dados[$campo], FILTER_VALIDATE_INT) === false ||
           $dados[$campo] < 1){
            http_response_code(400);
            echo json_encode([
                "erro" => "Informe um $campo válido!"
            ]);
            return null;
        }
    }

    return $dados;
}

function receberIdCurtida(){
    $id = filter_var(
        $_GET["id"] ?? null,
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 1]]
    );

    if($id === false){
        http_response_code(400);
        echo json_encode([
            "erro" => "Informe um id de curtida válido!"
        ]);
        return null;
    }

    return $id;
}

function createCurtida($con){
    $dados = receberDadosCurtida();

    if($dados === null){
        return;
    }

    $id = inserirCurtida($con, $dados);

    http_response_code(201);
    echo json_encode([
        "mensagem" => "Curtida adicionada com sucesso!",
        "id" => $id
    ]);
}

function readCurtida($con){
    $dados = listarCurtidas($con);

    echo json_encode($dados);
}

function deleteCurtida($con){
    $id = receberIdCurtida();

    if($id === null){
        return;
    }

    removerCurtida($con, $id);

    echo json_encode([
        "mensagem" => "Curtida removida com sucesso!"
    ]);
}