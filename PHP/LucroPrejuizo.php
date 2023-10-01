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
/*$DataInicial = "2020-01-01";
$DataFinal = "2020-12-08";*/

//---------------------------------------
//Acesso ao Banco de dados
//---------------------------------------
//Pega todo o histórico
//Primeiro das Compras
$sql = "SELECT * FROM compra";
//echo $sql;
$result = $BancoDeDados->query($sql);
if ($result->num_rows > 0) 
{
    // output data of each row
    //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
    while($row = mysqli_fetch_array($result)) 
    {
        $Banco_de_Dados_Recebido[] = ['Operacao'=>'Compra','NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'QuantidadeTotal'=>$row["QuantidadeAcaoComprada"], 'QuantidadeRestante'=>$row["QuantidadeRestante"], 'Custo'=>$row["CustoAcao"],'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'Data'=>$row["DataCompra"]];
    }

    //print_r($Banco_de_Dados_Recebido); //printa ele na tela

    //Segundo das Compras no prazo para Daytrade
    $sql = "SELECT * FROM compra WHERE DataCompra BETWEEN '".$DataInicial."' AND '".$DataFinal."'";
    //echo $sql;
    $result = $BancoDeDados->query($sql);
    if ($result->num_rows > 0) 
    {
        while($row = mysqli_fetch_array($result)) 
        {
            $Banco_de_Dados_Recebido[] = ['Operacao'=>'DayTrade','NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'QuantidadeTotal'=>$row["QuantidadeAcaoComprada"], 'QuantidadeRestante'=>$row["QuantidadeRestante"], 'Custo'=>$row["CustoAcao"],'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'Data'=>$row["DataCompra"]];
        }

        //Terceiro das Vendas no prazo
        $sql = "SELECT * FROM venda WHERE DataVenda BETWEEN '".$DataInicial."' AND '".$DataFinal."'";
        //echo $sql;
        $result = $BancoDeDados->query($sql);
        if ($result->num_rows > 0) 
        {
            while($row = mysqli_fetch_array($result)) 
            {
                $Banco_de_Dados_Recebido[] = ['Operacao'=>'Venda','NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'QuantidadeTotal'=>$row["QuantidadeAcaoVendida"], 'QuantidadeRestante'=>'0', 'Custo'=>$row["PrecoVendido"],'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'Data'=>$row["DataVenda"]];
            }
            //Manda o Banco com compras, daytrade e vendas
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }
        else
        {
            //Manda o Banco com apenas as compras e daytrade
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }
    }
    else
    {
        //Terceiro das Vendas no prazo
        $sql = "SELECT * FROM venda WHERE DataVenda BETWEEN '".$DataInicial."' AND '".$DataFinal."'";
        //echo $sql;
        $result = $BancoDeDados->query($sql);
        if ($result->num_rows > 0) 
        {
            while($row = mysqli_fetch_array($result)) 
            {
                $Banco_de_Dados_Recebido[] = ['Operacao'=>'Venda','NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'QuantidadeTotal'=>$row["QuantidadeAcaoVendida"], 'QuantidadeRestante'=>'0', 'Custo'=>$row["PrecoVendido"],'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'Data'=>$row["DataVenda"]];
            }
            //Manda o Banco apenas com compras e vendas
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }
        else
        {
            //Manda o Banco apenas com compras
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }  
    }   
} 
else 
{
    //Segundo das Compras no prazo para Daytrade
    $sql = "SELECT * FROM compra WHERE DataCompra BETWEEN '".$DataInicial."' AND '".$DataFinal."'";
    //echo $sql;
    $result = $BancoDeDados->query($sql);
    if ($result->num_rows > 0) 
    {
        while($row = mysqli_fetch_array($result)) 
        {
            $Banco_de_Dados_Recebido[] = ['Operacao'=>'DayTrade','NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'QuantidadeTotal'=>$row["QuantidadeAcaoComprada"], 'QuantidadeRestante'=>$row["QuantidadeRestante"], 'Custo'=>$row["CustoAcao"],'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'Data'=>$row["DataCompra"]];
        }

        //Terceiro das Vendas no prazo
        $sql = "SELECT * FROM venda WHERE DataVenda BETWEEN '".$DataInicial."' AND '".$DataFinal."'";
        //echo $sql;
        $result = $BancoDeDados->query($sql);
        if ($result->num_rows > 0) 
        {
            while($row = mysqli_fetch_array($result)) 
            {
                $Banco_de_Dados_Recebido[] = ['Operacao'=>'Venda','NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'QuantidadeTotal'=>$row["QuantidadeAcaoVendida"], 'QuantidadeRestante'=>'0', 'Custo'=>$row["PrecoVendido"],'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'Data'=>$row["DataVenda"]];
            }
            //Manda o Banco apenas com vendas e daytrade
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }
        else
        {
            //Manda o Banco apenas com daytrade
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }  
    }
    else
    {
        //Terceiro das Vendas no prazo
        $sql = "SELECT * FROM venda WHERE DataVenda BETWEEN '".$DataInicial."' AND '".$DataFinal."'";
        //echo $sql;
        $result = $BancoDeDados->query($sql);
        if ($result->num_rows > 0) 
        {
            while($row = mysqli_fetch_array($result)) 
            {
                $Banco_de_Dados_Recebido[] = ['Operacao'=>'Venda','NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'QuantidadeTotal'=>$row["QuantidadeAcaoVendida"], 'QuantidadeRestante'=>'0', 'Custo'=>$row["PrecoVendido"],'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'Data'=>$row["DataVenda"]];
            }
            //Manda o Banco apenas com vendas
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }
        else
        {
            //Nenhuma ação encontrada
            echo "Nenhuma Ação Encontrada";
        }  
    }   
}

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();
?>