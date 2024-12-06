<?php
include 'conexao.php'; // Conexão com o banco de dados

// Verifica se o parâmetro 'id' foi passado na URL
if (isset($_GET['editar'])) {
    $idProduto = $_GET['editar']; // Obtém o ID do produto que será editado

    // Consulta o produto no banco de dados
    $sql = "SELECT * FROM mostrar WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $idProduto); // 'i' para inteiro
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    // Verifica se o produto existe
    if ($resultado->num_rows > 0) {
        $produto = $resultado->fetch_assoc(); // Obtém os dados do produto
    } else {
        echo "Produto não encontrado.";
        exit;
    }
}

// Verifica se os dados de edição foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {
    $idProduto = $_POST['idProduto']; // ID do produto a ser editado
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];

    // Atualizando os dados no banco de dados
    $sqlEditar = "UPDATE mostrar SET nome = ?, descricao = ?, preco = ?, quantidade = ? WHERE id = ?";
    $stmt = $conexao->prepare($sqlEditar);
    $stmt->bind_param('ssdii', $nome, $descricao, $preco, $quantidade, $idProduto); // 's' para string, 'd' para decimal, 'i' para inteiro
    $stmt->execute();
    $stmt->close();

    // Redireciona para a página do catálogo após a edição
    header('Location: catalogo.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="editar.css">
</head>
<body>
    <h1>Editar Produto</h1>

    <form action="editar.php" method="POST">
        <input type="hidden" name="idProduto" value="<?php echo $produto['id']; ?>"> <!-- ID do produto -->

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>

        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" value="<?php echo htmlspecialchars($produto['descricao']); ?>" required>

        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco" value="<?php echo $produto['preco']; ?>" step="0.01" required>

        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" value="<?php echo $produto['quantidade']; ?>" required>

        <div class="buttons-container">
            <button class="voltar"><a href="catalogo.php"> < Voltar</a></button>
            <button type="submit" name="editar">Salvar Alterações</button>
        </div>
    </form>

    <footer>
        <p>Desenvolvido por  <a href="https://github.com/lorranalacerda">Lorrana Lacerda</a>
            <br> Técnica em Desenvolvimento de Sistemas
        </p> 
    </footer>
</body>
</html>
