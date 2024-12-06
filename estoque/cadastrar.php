<?php

include 'conexao.php'; // Certifique-se de que a conexão está configurada corretamente

// Verificando se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os dados do formulário de forma segura
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];

    // Usando prepared statements para evitar SQL Injection
    $sql = "INSERT INTO mostrar (nome, descricao, preco, quantidade) VALUES (?, ?, ?, ?)";
    
    if ($stmt = $conexao->prepare($sql)) {
        // 's' para string, 'd' para decimal/double e 'i' para integer
        $stmt->bind_param("ssdi", $nome, $descricao, $preco, $quantidade); 
        
        // Executa a consulta
        if ($stmt->execute()) {
            echo "Novo produto inserido com sucesso!";
        } else {
            echo "Erro ao inserir produto: " . $stmt->error;
        }
        
        // Fecha a declaração
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conexao->error;
    }

    // Redireciona para a página do catálogo após a inserção
    header('Location: catalogo.php');
    exit;
}

// Fechando a conexão
$conexao->close();

?>

<footer>
    <p>Desenvolvido por  <a href="https://github.com/lorranalacerda">Lorrana Lacerda</a>
        <br> Técnica em Desenvolvimento de Sistemas
    </p> 
</footer>
