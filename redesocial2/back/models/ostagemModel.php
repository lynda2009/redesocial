<?php

function inserirPostagem($con, $dados){
    $stmt = $con->prepare(
        "INSERT INTO publicacoes (id_usuario, legenda, imagem_url)
        VALUES (?, ?, ?)"
    );

    $stmt->execute([
        $dados["id_usuario"],
        $dados["legenda"],
        $dados["imagem_url"] ?? null
    ]);

    return $con->lastInsertId();
}

function listarPostagens($con){
    $stmt = $con->query(
        "SELECT * FROM publicacoes"
    );

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function atualizarPostagem($con, $id, $dados){
    $stmt = $con->prepare(
        "UPDATE publicacoes
        SET legenda = ?, imagem_url = ?
        WHERE id_publicacao = ?"
    );

    $stmt->execute([
        $dados["legenda"],
        $dados["imagem_url"] ?? null,
        $id
    ]);
}

function removerPostagem($con, $id){
    $stmt = $con->prepare(
        "DELETE FROM publicacoes
        WHERE id_publicacao = ?"
    );

    $stmt->execute([$id]);
}