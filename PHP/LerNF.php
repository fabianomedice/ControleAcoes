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
//Recebe entradas
//---------------------------------------

//---------------------------------------
//Acesso ao Banco de dados
//---------------------------------------
//Pega todo o histórico
//Primeiro das Compras
$sql = "SELECT * FROM notafiscal";
//echo $sql;
$result = $BancoDeDados->query($sql);
if ($result->num_rows > 0) 
{
    // output data of each row
    //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
    while($row = mysqli_fetch_array($result)) 
    {
        $Banco_de_Dados_Recebido[] = ['CorretoraNF'=>$row["CorretoraNF"],'NotaFiscal'=>$row["NumeroNotaFiscal"], 'Data'=>$row["DataNotafiscal"], 'ValorOperacoesTotais'=>$row["ValorOperacoesTotais"], 'CustoTotalOperacao'=>$row["CustoTotalOperacao"], 'IRRFvista'=>$row["IRRFvista"], 'IRRFDayTrade'=>$row["IRRFDayTrade"]];
    }

    //print_r($Banco_de_Dados_Recebido); //printa ele na tela
    $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
    echo $Banco_de_Dados_Recebido_Em_JSON;

} 
else 
{
    echo "Nenhuma Nota Fiscal Encontrada";
}


//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();
?>