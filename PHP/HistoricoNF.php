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

$DataInicial = $_POST["DataInicial"];
$DataFinal = $_POST["DataFinal"];
$Duracao = $_POST["Duracao"];
/*
$DataInicial = "2020-12-01";
$DataFinal = '2020-12-07';
$Duracao = "";
*/
//---------------------------------------
//Acesso ao Banco de dados
//---------------------------------------
if ($Duracao == "Tudo")
{
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
            $Banco_de_Dados_Recebido[] = ['CorretoraNF'=>$row["CorretoraNF"],'NotaFiscal'=>$row["NumeroNotaFiscal"], 'Data'=>$row["DataNotafiscal"], 'ValorOperacoesTotais'=>$row["ValorOperacoesTotais"], 'CustoTotalOperacao'=>$row["CustoTotalOperacao"]];
        }

        //print_r($Banco_de_Dados_Recebido); //printa ele na tela
        $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
        echo $Banco_de_Dados_Recebido_Em_JSON;

    } 
    else 
    {
        echo "Nenhuma Nota Fiscal Encontrada";
    }
}
else
{
    //Pega o dia
    $sql = "SELECT * FROM notafiscal WHERE DataNotafiscal BETWEEN '".$DataInicial."' AND '".$DataFinal."'";
    //echo $sql;
    $result = $BancoDeDados->query($sql);
    if ($result->num_rows > 0) 
    {
        // output data of each row
        //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
        while($row = mysqli_fetch_array($result)) 
        {
            $Banco_de_Dados_Recebido[] = ['CorretoraNF'=>$row["CorretoraNF"],'NotaFiscal'=>$row["NumeroNotaFiscal"], 'Data'=>$row["DataNotafiscal"], 'ValorOperacoesTotais'=>$row["ValorOperacoesTotais"], 'CustoTotalOperacao'=>$row["CustoTotalOperacao"]];
        }
        //print_r($Banco_de_Dados_Recebido); //printa ele na tela
        $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
        echo $Banco_de_Dados_Recebido_Em_JSON;

    } 
    else 
    {
        echo "Nenhuma Nota Fiscal Encontrada";
    }
}


//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();
?>