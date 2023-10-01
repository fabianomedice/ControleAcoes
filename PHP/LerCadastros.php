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
//echo "Fim ".date("Y-m-d")." Inicio ".date('Y-m-d', strtotime('-3 days'))."<br>";

//---------------------------------------
//Acesso ao Banco de dados 
//---------------------------------------

//Primeiro Notas Ficais
$sql = "SELECT * FROM notafiscal WHERE DataRegistro BETWEEN '".date('Y-m-d', strtotime('-3 days'))."' AND '".date("Y-m-d")."'";
//echo $sql;
$result = $BancoDeDados->query($sql);
if ($result->num_rows > 0) 
{
    // output data of each row
    //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
    while($row = mysqli_fetch_array($result)) 
    {
        $Banco_de_Dados_Recebido[] = [
        'Operacao'=>"NF",
        'NomeAcao'=>"-",
        'CodigoAcao'=>"-",
        'Corretora'=>$row["CorretoraNF"],
        'QuantidadeAcao'=>"-",
        'Valor'=>"-",
        'NotaFiscal'=>$row["NumeroNotaFiscal"], 
        'Data'=>$row["DataNotafiscal"], 
        'ValorOperacoesTotais'=>$row["ValorOperacoesTotais"], 
        'TaxaLiquidacao'=>$row["TaxaLiquidacao"],
        'Emolumentos'=>$row["Emolumentos"],
        'TaxaOperacao'=>$row["TaxaOperacao"],
        'Imposto'=>$row["Imposto"],
        'IRRFvista'=>$row["IRRFvista"], 
        'IRRFDayTrade'=>$row["IRRFDayTrade"],
        'DataRegistro'=>$row["DataRegistro"]
        ];
    }

    //Seleciona compras
    $sql = "SELECT * FROM compra WHERE DataRegistro BETWEEN '".date('Y-m-d', strtotime('-3 days'))."' AND '".date("Y-m-d")."'";
    //echo $sql;
    $result = $BancoDeDados->query($sql);
    if ($result->num_rows > 0) 
    {
        // output data of each row
        //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
        while($row = mysqli_fetch_array($result)) 
        {
            $Banco_de_Dados_Recebido[] = [
            'Operacao'=>"Compra",
            'NomeAcao'=>$row["NomeAcao"],
            'CodigoAcao'=>$row["CodigoAcao"],
            'Corretora'=>$row["CorretoraAcao"],
            'QuantidadeAcao'=>$row["QuantidadeAcaoComprada"],
            'Valor'=>$row["CustoAcao"],
            'NotaFiscal'=>$row["NotaFiscalAcao"], 
            'Data'=>$row["DataCompra"], 
            'ValorOperacoesTotais'=>'-', 
            'TaxaLiquidacao'=>'-', 
            'Emolumentos'=>'-', 
            'TaxaOperacao'=>'-', 
            'Imposto'=>'-', 
            'IRRFvista'=>'-', 
            'IRRFDayTrade'=>'-',
            'DataRegistro'=>$row["DataRegistro"]
            ];
        }

        //Seleciona Vendas
        $sql = "SELECT * FROM venda WHERE DataRegistro BETWEEN '".date('Y-m-d', strtotime('-3 days'))."' AND '".date("Y-m-d")."'";
        //echo $sql;
        $result = $BancoDeDados->query($sql);
        if ($result->num_rows > 0) 
        {
            // output data of each row
            //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
            while($row = mysqli_fetch_array($result)) 
            {
                $Banco_de_Dados_Recebido[] = [
                'Operacao'=>"Venda",
                'NomeAcao'=>$row["NomeAcao"],
                'CodigoAcao'=>$row["CodigoAcao"],
                'Corretora'=>$row["CorretoraAcao"],
                'QuantidadeAcao'=>$row["QuantidadeAcaoVendida"],
                'Valor'=>$row["PrecoVendido"],
                'NotaFiscal'=>$row["NotaFiscalAcao"], 
                'Data'=>$row["DataVenda"], 
                'ValorOperacoesTotais'=>'-', 
                'TaxaLiquidacao'=>'-', 
                'Emolumentos'=>'-', 
                'TaxaOperacao'=>'-', 
                'Imposto'=>'-', 
                'IRRFvista'=>'-', 
                'IRRFDayTrade'=>'-',
                'DataRegistro'=>$row["DataRegistro"]
                ];
            }

            //Mostra o registro de NF, Compras e Vendas cadastradas no periodo
            //print_r($Banco_de_Dados_Recebido); //printa ele na tela
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }
        else
        {
            //Não Há vendas cadastradas no periodo
            //Mostra o registro de NF e Compras cadastradas no periodo
            //print_r($Banco_de_Dados_Recebido); //printa ele na tela
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        } 
    } 
    else 
    {
        //Não Há compras cadastradas no periodo

        //Seleciona Vendas
        $sql = "SELECT * FROM venda WHERE DataRegistro BETWEEN '".date('Y-m-d', strtotime('-3 days'))."' AND '".date("Y-m-d")."'";
        //echo $sql;
        $result = $BancoDeDados->query($sql);
        if ($result->num_rows > 0) 
        {
            // output data of each row
            //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
            while($row = mysqli_fetch_array($result)) 
            {
                $Banco_de_Dados_Recebido[] = [
                'Operacao'=>"Venda",
                'NomeAcao'=>$row["NomeAcao"],
                'CodigoAcao'=>$row["CodigoAcao"],
                'Corretora'=>$row["CorretoraAcao"],
                'QuantidadeAcao'=>$row["QuantidadeAcaoVendida"],
                'Valor'=>$row["PrecoVendido"],
                'NotaFiscal'=>$row["NotaFiscalAcao"], 
                'Data'=>$row["DataVenda"], 
                'ValorOperacoesTotais'=>'-', 
                'TaxaLiquidacao'=>'-', 
                'Emolumentos'=>'-', 
                'TaxaOperacao'=>'-', 
                'Imposto'=>'-', 
                'IRRFvista'=>'-', 
                'IRRFDayTrade'=>'-',
                'DataRegistro'=>$row["DataRegistro"]
                ];
            }

            //Mostra o registro de NF e Vendas cadastradas no periodo
            //print_r($Banco_de_Dados_Recebido); //printa ele na tela
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }
        else
        {
            //Não Há Compras e Vendas cadastradas no periodo
            //Mostra o registro de NF cadastradas no periodo
            //print_r($Banco_de_Dados_Recebido); //printa ele na tela
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        } 
    }

} 
else 
{
    //Não Há notas fiscais cadastradas no periodo

    //Seleciona compras
    $sql = "SELECT * FROM compra WHERE DataRegistro BETWEEN '".date('Y-m-d', strtotime('-3 days'))."' AND '".date("Y-m-d")."'";
    //echo $sql;
    $result = $BancoDeDados->query($sql);
    if ($result->num_rows > 0) 
    {
        // output data of each row
        //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
        while($row = mysqli_fetch_array($result)) 
        {
            $Banco_de_Dados_Recebido[] = [
            'Operacao'=>"Compra",
            'NomeAcao'=>$row["NomeAcao"],
            'CodigoAcao'=>$row["CodigoAcao"],
            'Corretora'=>$row["CorretoraAcao"],
            'QuantidadeAcao'=>$row["QuantidadeAcaoComprada"],
            'Valor'=>$row["CustoAcao"],
            'NotaFiscal'=>$row["NotaFiscalAcao"], 
            'Data'=>$row["DataCompra"], 
            'ValorOperacoesTotais'=>'-', 
            'TaxaLiquidacao'=>'-', 
            'Emolumentos'=>'-', 
            'TaxaOperacao'=>'-', 
            'Imposto'=>'-', 
            'IRRFvista'=>'-', 
            'IRRFDayTrade'=>'-',
            'DataRegistro'=>$row["DataRegistro"]
            ];
        }

        //Seleciona Vendas
        $sql = "SELECT * FROM venda WHERE DataRegistro BETWEEN '".date('Y-m-d', strtotime('-3 days'))."' AND '".date("Y-m-d")."'";
        //echo $sql;
        $result = $BancoDeDados->query($sql);
        if ($result->num_rows > 0) 
        {
            // output data of each row
            //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
            while($row = mysqli_fetch_array($result)) 
            {
                $Banco_de_Dados_Recebido[] = [
                'Operacao'=>"Venda",
                'NomeAcao'=>$row["NomeAcao"],
                'CodigoAcao'=>$row["CodigoAcao"],
                'Corretora'=>$row["CorretoraAcao"],
                'QuantidadeAcao'=>$row["QuantidadeAcaoVendida"],
                'Valor'=>$row["PrecoVendido"],
                'NotaFiscal'=>$row["NotaFiscalAcao"], 
                'Data'=>$row["DataVenda"], 
                'ValorOperacoesTotais'=>'-', 
                'TaxaLiquidacao'=>'-', 
                'Emolumentos'=>'-', 
                'TaxaOperacao'=>'-', 
                'Imposto'=>'-', 
                'IRRFvista'=>'-', 
                'IRRFDayTrade'=>'-',
                'DataRegistro'=>$row["DataRegistro"]
                ];
            }

            //Mostra o registro de Compras e Vendas cadastradas no periodo
            //print_r($Banco_de_Dados_Recebido); //printa ele na tela
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }
        else
        {
            //Não Há NF e Vendas cadastradas no periodo
            //Mostra o registro de Compras cadastradas no periodo
            //print_r($Banco_de_Dados_Recebido); //printa ele na tela
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        } 
    } 
    else 
    {
        //Não Há NF e Compras cadastradas no periodo

        //Seleciona Vendas
        $sql = "SELECT * FROM venda WHERE DataRegistro BETWEEN '".date('Y-m-d', strtotime('-3 days'))."' AND '".date("Y-m-d")."'";
        //echo $sql;
        $result = $BancoDeDados->query($sql);
        if ($result->num_rows > 0) 
        {
            // output data of each row
            //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
            while($row = mysqli_fetch_array($result)) 
            {
                $Banco_de_Dados_Recebido[] = [
                'Operacao'=>"Venda",
                'NomeAcao'=>$row["NomeAcao"],
                'CodigoAcao'=>$row["CodigoAcao"],
                'Corretora'=>$row["CorretoraAcao"],
                'QuantidadeAcao'=>$row["QuantidadeAcaoVendida"],
                'Valor'=>$row["PrecoVendido"],
                'NotaFiscal'=>$row["NotaFiscalAcao"], 
                'Data'=>$row["DataVenda"], 
                'ValorOperacoesTotais'=>'-', 
                'TaxaLiquidacao'=>'-', 
                'Emolumentos'=>'-', 
                'TaxaOperacao'=>'-', 
                'Imposto'=>'-', 
                'IRRFvista'=>'-', 
                'IRRFDayTrade'=>'-',
                'DataRegistro'=>$row["DataRegistro"]
                ];
            }

            //Mostra o registro de Vendas cadastradas no periodo
            //print_r($Banco_de_Dados_Recebido); //printa ele na tela
            $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
            echo $Banco_de_Dados_Recebido_Em_JSON;
        }
        else
        {
            //Não Há NF, Compras e Vendas cadastradas no periodo
            echo "Nenhum registro encontrado";
        } 
    }
}



//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();
?>