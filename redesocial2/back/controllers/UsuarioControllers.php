<?php
require_once __DIR__ . "/../models/UsuarioModel.php";

function teste() {
    echo json_encode([
        "mensagem" => "Back-end respondendo com sucesso!"
    ]);
    exit;
}
//receber e validar os dados 
function receberDadosUsuario(){
    $dados = json_decode(
        file_get_contents("php://input"),true);
        if(!is_array($dados)){
            http_response_code(400);
            echo json_encode([
                "erro"=>"Envie um objeto JSON com dados!"
            ]);
            return null;
        }
        //nome, username, email e senha -> se existe 
        foreach(["nome", "username", "email", "senha"] as $campo){
            if(!isset($dados[$campo]) ||
                !is_string($dados[$campo]) ||
                trim($dados[$campo])===""){
                    http_response_code(400);
                    echo json_encode([
                        "erro"=>
                        "o campo $campo é obrigatorio e deve ser um texto!"
                    ]);
                    return null;
                }
    }            
}
function receberIdUsuario(){
    $id = filter_var($_GET["id"] ?? null,
                 FILTER_VALIDATE_INT,
                 ["options"=> ["min_range"=>1]]);
    if($id === false){
        http_response_code(400);
        echo json_encode([
            "erro" => "Informe um id de usuario valido"
        ]);
        return null;
    }
    return $id;
}
function createUsuario($con){
    $dados = receberDadosUsuarios();
    if($dados === null){
        return;
    }
    $id = inserir ($con,$dados);
    http_response_code(201);
    echo json_encode([
        "mensagem" => "usuario criado com sucesso",
        "id" => $id
    ]);
}
function readUsuaruio($con){
    $id = receberIdUsuario();
    if($id === null){
        return;
    }
    $dados = receberDadosUsuario();
    if($dados === null){
        return;
    }
atualizar($con, $id, $dados);
echo json_encode([
    "mensagem" => "senha alterada com sucesso!"
]);
}
function deleteUsuario($con){
    $id =receberIdUsuario();
    if($id === null){
        return;
    }
    remover($con,$id);
    echo json_encode([
        "mensagem" => "usuario removido com sucesso!"
    ]);
}