<?php
//CREATE
function inserir($con,$dados){
    $stmt = $con->prepare(
        "INSERT INTO USUARIOS (nome, username, email, senha)
        VALUES (?,?,?,?)"
    );
    $stmt -> execute([ $dados["nome"],
                       $dados["username"],
                       $dados["email"],
                       $dados["senha"]]);
    return $con->lasrInsertId();
}
//read
function listar($con){
    $stmt = $con -> query ("SELECT * FROM usuarios");
    return $stmt ->feaxhAll(PDO:: FETCH_ASSOC);
}
//UPDATE
function atualizar($con,$id,$dados){
    $stmt = $con->prepare(
        "UPDATE usuario SET senha = ?
            WHERE id_usuario=?"
    );
    $stmt -> execute([  $dados["senha"],
                        $id]);
}
//DELETE
function remover($con,$id){
    $stmt = $con->prepare(
        "DELETE FROM usuario WHERE id_usuario = ?"
    );
    $stmt -> execute([$id]);
}