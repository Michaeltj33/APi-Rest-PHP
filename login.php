<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="estilo.css" />

    <style>
        input {
            font-size: 140%;
            margin-bottom: 5%;
        }

        label {
            font-size: 150%;
        }
    </style>
</head>

<body>
    <form action="verSenha.php" method="POST" class="form-style-6" name="form1" id="form1">
        <div>
            <h1>Digite a Senha para acessar os Logs</h1>
        </div>
        <div>
            <label>Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite a senha" required />
        </div>
        <input type="submit">
    </form>
</body>

</html>