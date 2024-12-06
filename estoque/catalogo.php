<?php 
include 'conexao.php';

// Verifica se há um termo de pesquisa
$termoPesquisa = '';
if (isset($_GET['search'])) {
    $termoPesquisa = $_GET['search'];
    $sql = "SELECT * FROM mostrar WHERE nome LIKE ? OR descricao LIKE ?";
    $stmt = $conexao->prepare($sql);
    $pesquisaTermo = '%' . $termoPesquisa . '%';  // Preparando o termo para a consulta
    $stmt->bind_param('ss', $pesquisaTermo, $pesquisaTermo); // 'ss' para duas strings
} else {
    // Caso não haja pesquisa, exibe todos os produtos
    $sql = "SELECT * FROM mostrar";
    $stmt = $conexao->prepare($sql);
}

$stmt->execute();
$resultado = $stmt->get_result();

// Verifica se um produto foi excluído
if (isset($_GET['excluir'])) {
    $idExcluir = $_GET['excluir']; // Recebe o índice do produto a ser excluído
    $sqlExcluir = "DELETE FROM mostrar WHERE id = ?";
    $stmt = $conexao->prepare($sqlExcluir);
    $stmt->bind_param('i', $idExcluir); // 'i' é o tipo de dado (integer)
    $stmt->execute();
    $stmt->close();
    header('Location: catalogo.php'); // Redireciona para evitar reenvio do formulário
    exit;
}

?>

<!-- Exibindo os dados em uma tabela -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo de Produtos</title>
    <link rel="stylesheet" href="catalogoProdutos.css">
    <script type="text/javascript">
        // Função para confirmar a exclusão do produto
        function confirmarExclusao(id) {
            if (confirm('Tem certeza de que deseja excluir este produto?')) {
                window.location.href = 'catalogo.php?excluir=' + id;
            }
        }
    </script>

    <style>

    form {
        display: flex;
    }
    form input {
    padding: 10px 20px;
    font-size: 1em;
    border-radius: 5px;
    border: 1px solid #007BFF;
    width: 100rem;
    max-width: 350px; /* Limita a largura do input */
    box-sizing: border-box;
    transition: all 0.3s ease;
}

form input:focus {
    outline: none;
    border-color: #0056b3;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

form button {
    padding: 10px 20px;
    font-size: 1em;
    color: white;
    background-color: #007BFF;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-left: 10px;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>
    <h1>Catalogo de Produtos</h1>

    <!-- Formulário de pesquisa -->
    <form action="catalogo.php" method="get">
        <input type="text" name="search" placeholder="Pesquisar por nome ou descrição" value="<?php echo htmlspecialchars($termoPesquisa); ?>">
        <button type="submit">Pesquisar</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultado->num_rows > 0) {
                while ($produto = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $produto['id'] . "</td>";
                    echo "<td>" . $produto['nome'] . "</td>";
                    echo "<td>" . $produto['descricao'] . "</td>";
                    echo "<td>" . number_format($produto['preco'], 2, ',', '.') . "</td>";
                    echo "<td>" . $produto['quantidade'] . "</td>";
                    echo "<td>
                            <a href='editar.php?editar=" . $produto['id'] . "'>Editar</a> | 
                            <a href='#' onclick='confirmarExclusao(" . $produto['id'] . ")'>Excluir</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Nenhum produto encontrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <button><a href="index.php">Voltar</a></button>

    <footer>
        <p>Desenvolvido por <a href="https://github.com/lorranalacerda">Lorrana Lacerda</a>
            <br> Técnica em Desenvolvimento de Sistemas
        </p> 
    </footer>
</body>
</html>
