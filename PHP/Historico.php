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


//---------------------------------------
//Acesso ao Banco de dados
//---------------------------------------
if ($Duracao == "Tudo")
{
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
            $Banco_de_Dados_Recebido[] = ['Operacao'=>'Compra','NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'Quantidade'=>$row["QuantidadeAcaoComprada"], 'Custo'=>$row["CustoAcao"],'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'Data'=>$row["DataCompra"]];
        }

        //print_r($Banco_de_Dados_Recebido); //printa ele na tela

        //Segundo das Vendas
        $sql = "SELECT * FROM venda";
        //echo $sql;
        $result = $BancoDeDados->query($sql);
        if ($result->num_rows > 0) 
        {
            while($row = mysqli_fetch_array($result)) 
            {
                $Banco_de_Dados_Recebido[] = ['Operacao'=>'Venda','NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'Quantidade'=>$row["QuantidadeAcaoVendida"], 'Custo'=>$row["PrecoVendido"],'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'Data'=>$row["DataVenda"]];
            }
            //Manda o Banco com compras e vendas
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }
        else
        {
            //Manda o Banco com apenas as compras
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }
    } 
    else 
    {
        //Segundo das Vendas
        $sql = "SELECT * FROM venda";
        //echo $sql;
        $result = $BancoDeDados->query($sql);
        if ($result->num_rows > 0) 
        {
            while($row = mysqli_fetch_array($result)) 
            {
                $Banco_de_Dados_Recebido[] = ['Operacao'=>'Venda','NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'Quantidade'=>$row["QuantidadeAcaoVendida"], 'Custo'=>$row["PrecoVendido"],'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'Data'=>$row["DataVenda"]];
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
else
{
    //Pega o dia
    $sql = "SELECT * FROM compra WHERE DataCompra BETWEEN '".$DataInicial."' AND '".$DataFinal."'";
    //echo $sql;
    $result = $BancoDeDados->query($sql);
    if ($result->num_rows > 0) 
    {
        // output data of each row
        //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
        while($row = mysqli_fetch_array($result)) 
        {
            $Banco_de_Dados_Recebido[] = ['Operacao'=>'Compra','NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'Quantidade'=>$row["QuantidadeAcaoComprada"], 'Custo'=>$row["CustoAcao"],'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'Data'=>$row["DataCompra"]];
        }
        //print_r($Banco_de_Dados_Recebido); //printa ele na tela

        //Segundo das Vendas
        $sql = "SELECT * FROM venda WHERE DataVenda BETWEEN '".$DataInicial."' AND '".$DataFinal."'";
        //echo $sql;
        $result = $BancoDeDados->query($sql);
        if ($result->num_rows > 0) 
        {
            while($row = mysqli_fetch_array($result)) 
            {
                $Banco_de_Dados_Recebido[] = ['Operacao'=>'Venda','NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'Quantidade'=>$row["QuantidadeAcaoVendida"], 'Custo'=>$row["PrecoVendido"],'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'Data'=>$row["DataVenda"]];
            }
            //Manda o Banco com compras e vendas
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }
        else
        {
            //Manda o Banco com apenas as compras
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }
    } 
    else 
    {
        //Segundo das Vendas
        $sql = "SELECT * FROM venda WHERE DataVenda BETWEEN '".$DataInicial."' AND '".$DataFinal."'";
        //echo $sql;
        $result = $BancoDeDados->query($sql);
        if ($result->num_rows > 0) 
        {
            while($row = mysqli_fetch_array($result)) 
            {
                $Banco_de_Dados_Recebido[] = ['Operacao'=>'Venda','NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'Quantidade'=>$row["QuantidadeAcaoVendida"], 'Custo'=>$row["PrecoVendido"],'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'Data'=>$row["DataVenda"]];
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