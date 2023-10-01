<?php
//---------------------------------------
//Conexão
//---------------------------------------
//$servername = '127.0.0.1'; //ou "localhost"
$servername = "localhost"; //ou "localhost"
$username = 'root';
$password = ''; //To be completed if you have set a password to root
$database = 'acoes'; //To be completed to connect to a database. The database must exist.
$port = 3306; //Default must be NULL to use default port
$BancoDeDados = new mysqli($servername, $username, $password, $database, $port);

//---------------------------------------
//Acesso ao Banco de dados
//---------------------------------------
//Procura se a ação já foi cadastrada antes
$sql = "SELECT NomeAcao, CodigoAcao, CorretoraAcao, QuantidadeRestante, CustoAcao, NotaFiscalAcao, DataCompra FROM compra WHERE QuantidadeRestante  NOT LIKE '0'";
//echo $sql;
$result = $BancoDeDados->query($sql);
if ($result->num_rows > 0) 
{
    // output data of each row
    //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
    while($row = mysqli_fetch_array($result)) 
    {
        $Banco_de_Dados_Recebido[] = ['NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'QuantidadeRestante'=>$row["QuantidadeRestante"], 'CustoAcao'=>$row["CustoAcao"], 'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'DataCompra'=>$row["DataCompra"]];
    }

    //print_r($Banco_de_Dados_Recebido); //printa ele na tela

    $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
    echo $Banco_de_Dados_Recebido_Em_JSON;
} 
else 
{
    //Nenhuma ação encontrada
    echo "Nenhuma Ação Encontrada";
}

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();
?>