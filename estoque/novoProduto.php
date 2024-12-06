<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Produto</title>
    <link rel="stylesheet" href="novoProduto.css">
</head>
<body>
    <form action="cadastrar.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" placeholder="Insira o nome do produto" required>

        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" placeholder="Descreva as características do produto" required>

        <label for="preco">Preço em R$:</label>
        <input type="number" id="preco" name="preco" placeholder="Digite o valor do produto" step="0.01" required>

        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" placeholder="Digite quantas unidades há" required>
   
        <div class="buttons-container">
        <button class="voltar"><a href="index.php"> < Voltar </a></button>
        <button type="submit">Cadastrar</button>
    </div>
        
</form>

    
    <footer>
        <p>Desenvolvido por  <a href="https://github.com/lorranalacerda">Lorrana Lacerda</a>
            <br> Técnica em Desenvolvimento de Sistemas
        </p> 
    </footer>
</body>
</html>
