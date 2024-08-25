<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biomedicina";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Criar conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Coletar dados do formulário
    $nome_exame = $_POST['nome_exame'];
    $tipo = $_POST['tipo'];
    $dtrealizado = $_POST['dtrealizado'];
    $id_cliente = $_POST['id_cliente'];
    $id_info_referencia = $_POST['id_info_referencia'];

    // Preparar e vincular
    $stmt = $conn->prepare("INSERT INTO amostras (sample_id, sample_type, collection_datetime, patient_name, birthdate, gender, contact_info, requester_name, requester_council, requester_council_number, requester_institution, analysis_type, request_datetime, responsible_lab, analysis_status, additional_notes, created_at, result, result_notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssisssssssssss", $sample_id, $sample_type, $collection_datetime, $patient_name, $birthdate, $gender, $contact_info, $requester_name, $requester_council, $requester_council_number, $requester_institution, $analysis_type, $request_datetime, $responsible_lab, $analysis_status, $additional_notes, $created_at, $result, $result_notes);

    // Definir parâmetros e executar
    $sample_id = ""; // Definir um valor apropriado
    $sample_type = $tipo == 1 ? 'Exame' : 'Amostra';
    $collection_datetime = $dtrealizado;
    $patient_name = ""; // Definir um valor apropriado
    $birthdate = ""; // Definir um valor apropriado
    $gender = ""; // Definir um valor apropriado
    $contact_info = ""; // Definir um valor apropriado
    $requester_name = ""; // Definir um valor apropriado
    $requester_council = ""; // Definir um valor apropriado
    $requester_council_number = ""; // Definir um valor apropriado
    $requester_institution = ""; // Definir um valor apropriado
    $analysis_type = $nome_exame;
    $request_datetime = date('Y-m-d H:i:s');
    $responsible_lab = ""; // Definir um valor apropriado
    $analysis_status = "Pendente";
    $additional_notes = ""; // Definir um valor apropriado
    $created_at = date('Y-m-d H:i:s');
    $result = ""; // Definir um valor apropriado
    $result_notes = ""; // Definir um valor apropriado

    $stmt->execute();

    echo "<p>Solicitação enviada com sucesso!</p>";

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Pedido de Exame</title>
    <style>
        body {
            background-color: #e8f5e9;
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
        }

        .container {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .sidebar h2 {
            margin-top: 0;
            font-size: 1.8rem;
            color: #2e7d32;
        }

        .sidebar .user {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .sidebar .user .button {
            background-color: #66bb6a;
            color: #fff;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .sidebar .user p {
            margin: 0;
            color: #2e7d32;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            color: #2e7d32;
            text-decoration: none;
            border-bottom: 1px solid #eee;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #e0f2f1;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        .content h1 {
            margin-top: 0;
            font-size: 2rem;
            color: #2e7d32;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #66bb6a;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2e7d32;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="sidebar">
        <h2>Biomedicina</h2>
        <div class="user">
            <div class="button">C</div>
            <div>
                <p>Crisdayane</p>
                <p>Coordenador</p>
            </div>
        </div>
        <a href="index.php">Início</a>
        <a href="resultados.php">Amostras Cadastradas</a>
        <a href="search.html">Localizar Paciente</a>
        <a href="#">Resultados</a>
        <a href="solicitarpedidos.php">Solicitar Exames</a>
        <a href="pagcoordenador.html">Voltar</a>
    </div>
    <div class="content">
        <h1>Solicitar Pedido de Exame</h1>
        <form action="solicitarpedidos.php" method="post">
            <label for="nome_exame">Nome do Exame/Amostra:</label>
            <input type="text" id="nome_exame" name="nome_exame" required>

            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo" required>
                <option value="1">Exame</option>
                <option value="0">Amostra</option>
            </select>

            <label for="dtrealizado">Data da Realização:</label>
            <input type="datetime-local" id="dtrealizado" name="dtrealizado" required>

            <label for="id_cliente">Código Único do Cliente:</label>
            <input type="number" id="id_cliente" name="id_cliente" required>

            <label for="id_info_referencia">Código Único de Informações e Referência:</label>
            <input type="number" id="id_info_referencia" name="id_info_referencia" required>

            <button type="submit">Enviar Solicitação</button>
        </form>
    </div>
</div>

</body>
</html>
