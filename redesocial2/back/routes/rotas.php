
<?php

require_once __DIR__ . "/../controllers/PostagemController.php";
require_once __DIR__ . "/../controllers/CurtidaController.php";

$rota = $_GET["rota"] ?? "";
$metodo = $_SERVER["REQUEST_METHOD"];

if($rota === "postagem"){

    switch($metodo){

        case "POST":
            createPostagem($con);
            break;

        case "GET":
            readPostagem($con);
            break;

        case "PUT":
            updatePostagem($con);
            break;

        case "DELETE":
            deletePostagem($con);
            break;

        default:
            http_response_code(405);
            echo json_encode([
                "erro" => "Método não permitido!"
            ]);
    }

} elseif($rota === "curtida"){

    switch($metodo){

        case "POST":
            createCurtida($con);
            break;

        case "GET":
            readCurtida($con);
            break;

        case "DELETE":
            deleteCurtida($con);
            break;

        default:
            http_response_code(405);
            echo json_encode([
                "erro" => "Método não permitido!"
            ]);
    }

} else {

    http_response_code(404);
    echo json_encode([
        "erro" => "Rota não encontrada!"
    ]);

}
