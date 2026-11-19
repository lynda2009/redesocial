<?php

require_once __DIR__ . "/../models/PostagemModel.php";

function receberDadosPostagem(){
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

    foreach(["id_usuario", "legenda"] as $campo){
        if(!isset($dados[$campo]) ||
           trim((string)$dados[$campo]) === ""){
            http_response_code(400);
            echo json_encode([
                "erro" => "O campo $campo é obrigatório!"
            ]);
            return null;
        }
    }

    if(filter_var($dados["id_usuario"], FILTER_VALIDATE_INT) === false ||
       $dados["id_usuario"] < 1){
        http_response_code(400);
        echo json_encode([
            "erro" => "Informe um id de usuário válido!"
        ]);
        return null;
    }

    return $dados;
}

function receberIdPostagem(){
    $id = filter_var(
        $_GET["id"] ?? null,
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 1]]
    );

    if($id === false){
        http_response_code(400);
        echo json_encode([
            "erro" => "Informe um id de postagem válido!"
        ]);
        return null;
    }

    return $id;
}

function createPostagem($con){
    $dados = receberDadosPostagem();

    if($dados === null){
        return;
    }

    $id = inserirPostagem($con, $dados);

    http_response_code(201);
    echo json_encode([
        "mensagem" => "Postagem criada com sucesso!",
        "id" => $id
    ]);
}

function readPostagem($con){
    $dados = listarPostagens($con);

    echo json_encode($dados);
}

function updatePostagem($con){
    $id = receberIdPostagem();

    if($id === null){
        return;
    }

    $dados = receberDadosPostagem();

    if($dados === null){
        return;
    }

    atualizarPostagem($con, $id, $dados);

    echo json_encode([
        "mensagem" => "Postagem atualizada com sucesso!"
    ]);
}

function deletePostagem($con){
    $id = receberIdPostagem();

    if($id === null){
        return;
    }

    removerPostagem($con, $id);

    echo json_encode([
        "mensagem" => "Postagem removida com sucesso!"
    ]);
}