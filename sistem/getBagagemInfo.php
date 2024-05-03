<?php
// Conexão com o banco de dados
include('../connections/connection.php');

// Verifica se o código da bagagem foi recebido na requisição
if(isset($_GET['codigoBagagem'])) {
    $codigoBagagem = $_GET['codigoBagagem'];

    // Consulta SQL para obter todas as informações da bagagem e da passagem relacionada
    $sql = "SELECT BAGAGENS.*, PASSAGENS.*, VOOS.*
            FROM BAGAGENS B
            INNER JOIN PASSAGENS P ON B.FK_PASSAGENS_ID_PASSAGEM = P.ID_PASSAGEM
            INNER JOIN VOOS V ON P.FK_VOOS_ID_VOO = V.ID_VOO
            WHERE B.CODIGO_BAGAGEM = '$codigoBagagem'";

    $result = $conn->query($sql);

    if($result) {
        if($result->num_rows > 0) {
            // Extrai os dados da bagagem e da passagem relacionada
            $row = $result->fetch_assoc();

            // Prepara um array associativo com os dados da bagagem e da passagem
            $bagagemInfo = array(
                'bagagem' => array(
                    'ID_BAGAGEM' => $row['ID_BAGAGEM'],
                    'CODIGO_BAGAGEM' => $row['CODIGO_BAGAGEM'],
                    'PESO' => $row['PESO'],
                    'TIPO' => $row['TIPO'],
                    'DESCRICAO' => $row['DESCRICAO'],
                    'STATUS_BAGAGEM' => $row['STATUS_BAGAGEM']
                ),
                'passagem' => array(
                    'ID_PASSAGEM' => $row['ID_PASSAGEM'],
                    'NOME_PASSAGEIRO' => $row['NOME_PASSAGEIRO'],
                    'CPF_PASSAGEIRO' => $row['CPF_PASSAGEIRO']
                )
            );

            // Retorna o JSON com os dados da bagagem e da passagem
            header('Content-Type: application/json');
            echo json_encode($bagagemInfo);
            exit; // Encerrar o script após enviar a resposta JSON
        } else {
            // Se a bagagem não for encontrada, retorna uma mensagem de erro
            echo json_encode(array('error' => 'Bagagem não encontrada.'));
            exit; // Encerrar o script após enviar a resposta JSON
        }
    } else {
        // Se houver um erro na consulta SQL, retorna uma mensagem de erro
        echo json_encode(array('error' => 'Erro na consulta SQL: ' . $conn->error));
        exit; // Encerrar o script após enviar a resposta JSON
    }
} else {
    // Se o código da bagagem não for recebido na requisição, retorna uma mensagem de erro
    echo json_encode(array('error' => 'Código da bagagem não fornecido.'));
    exit; // Encerrar o script após enviar a resposta JSON
}

?>
