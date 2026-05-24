<?php

// Importa o arquivo de conexão com o banco
require_once "conexao.php";


// Verifica se o formulário foi enviado usando método POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Pega o valor digitado no input "nome"
    $nome = $_POST["nome"];

    // Pega o modelo digitado
    $modelo = $_POST["modelo"];

    // Pega a cor digitada
    $cor = $_POST["cor"];

    // Pega a quilometragem digitada
    $quilometragem = $_POST["quilometragem"];


    // Cria variável da foto inicialmente vazia
    $foto = null;


    // Verifica se o usuário selecionou uma foto
    if (!empty($_FILES["foto"]["name"])) {

        // Cria um nome único para evitar fotos repetidas
        // time() pega o timestamp atual
        $nomeFoto = time() . "_" . $_FILES["foto"]["name"];

        // Define o caminho onde a foto será salva
        $caminhoFoto = "uploads/" . $nomeFoto;

        // Move a foto temporária para a pasta uploads
        move_uploaded_file(
            $_FILES["foto"]["tmp_name"],
            $caminhoFoto
        );

        // Guarda o caminho da foto no banco
        $foto = $caminhoFoto;
    }


    // SQL para inserir os dados no banco
    $sql = "INSERT INTO carros
            (nome, modelo, cor, quilometragem, foto)

            VALUES
            (:nome, :modelo, :cor, :quilometragem, :foto)";


    // Prepara o SQL para execução segura
    // Isso evita SQL Injection
    $stmt = $pdo->prepare($sql);


    // Executa o SQL enviando os valores
    $stmt->execute([

        // :nome recebe o valor da variável $nome
        ":nome" => $nome,

        // :modelo recebe $modelo
        ":modelo" => $modelo,

        // :cor recebe $cor
        ":cor" => $cor,

        // :quilometragem recebe $quilometragem
        ":quilometragem" => $quilometragem,

        // :foto recebe o caminho da imagem
        ":foto" => $foto
    ]);


    // Redireciona para index.php após cadastrar
    header("Location: index.php");

    // Finaliza o script
    exit;
}

?>


<!-- TÍTULO DA PÁGINA -->
<h1>Cadastrar Carro</h1>


<!--
enctype="multipart/form-data"
É obrigatório para upload de imagens
-->
<form method="POST" enctype="multipart/form-data">


    <!-- INPUT NOME -->
    <label>Nome do carro:</label><br>

    <!-- Campo texto -->
    <input
        type="text"
        name="nome"
        required
    >

    <br><br>


    <!-- INPUT MODELO -->
    <label>Modelo:</label><br>

    <input
        type="text"
        name="modelo"
        required
    >

    <br><br>


    <!-- INPUT COR -->
    <label>Cor:</label><br>

    <input
        type="text"
        name="cor"
        required
    >

    <br><br>


    <!-- INPUT QUILOMETRAGEM -->
    <label>Quilometragem:</label><br>

    <input
        type="number"
        name="quilometragem"
        required
    >

    <br><br>


    <!-- INPUT FOTO -->
    <label>Foto:</label><br>

    <!-- type="file" cria upload -->
    <input
        type="file"
        name="foto"
    >

    <br><br>


    <!-- BOTÃO CADASTRAR -->
    <button type="submit">
        Cadastrar
    </button>

</form>


<br>


<!-- LINK VOLTAR -->
<a href="index.php">
    Voltar
</a>