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
$sql = "SELECT NomeAcao, CodigoAcao, CorretoraAcao, QuantidadeAcaoComprada, QuantidadeRestante, CustoAcao, NotaFiscalAcao, DataCompra FROM compra WHERE QuantidadeRestante  NOT LIKE '0'";
//echo $sql;
$result = $BancoDeDados->query($sql);
if ($result->num_rows > 0) 
{
    // output data of each row
    //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
    while($row = mysqli_fetch_array($result)) 
    {
        $Banco_de_Dados_Recebido[] = ['NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'QuantidadeAcaoComprada'=>$row["QuantidadeAcaoComprada"], 'QuantidadeRestante'=>$row["QuantidadeRestante"], 'CustoAcao'=>$row["CustoAcao"], 'NotaFiscalAcao'=>$row["NotaFiscalAcao"], 'DataCompra'=>$row["DataCompra"]];        
    }
    $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
    echo $Banco_de_Dados_Recebido_Em_JSON;


    /*
    while($row = mysqli_fetch_array($result)) 
    {
        $NomeAcao[] = $row["NomeAcao"];
        $CodigoAcao[] = $row["CodigoAcao"];
        $CorretoraAcao[] = $row["CorretoraAcao"];
        $QuantidadeAcaoComprada[] = $row["QuantidadeAcaoComprada"];
        $QuantidadeRestanteAcao[] = $row["QuantidadeRestante"];
        $CustoAcao[] = $row["CustoAcao"];
        $NotaFiscalAcao[] = $row["NotaFiscalAcao"];
        $DataCompra[] = $row["DataCompra"];
        //$Banco_de_Dados_Recebido[] = ['NomeAcao'=>$row["NomeAcao"], 'CodigoAcao'=>$row["CodigoAcao"], 'CorretoraAcao'=>$row["CorretoraAcao"], 'QuantidadeRestante'=>$row["QuantidadeRestante"], 'CustoAcao'=>$row["CustoAcao"], 'DataCompra'=>$row["DataCompra"]];        
        $NomeEmOrdem[] = $row["NomeAcao"]." - ".$row["CodigoAcao"];
    }
    // Coloca em ordem
    sort($NomeEmOrdem);
    //Cria o banco de dados em ordem
    for ($i=0;$i<count($NomeAcao);$i++)
    {
        for ($j=0;$j<count($NomeEmOrdem);$j++)
        {
            if($NomeAcao[$i]." - ".$CodigoAcao[$i] == $NomeEmOrdem[$j])
            {
                $Banco_de_Dados_Recebido[$j] = ['NomeAcao'=>$NomeAcao[$i], 'CodigoAcao'=>$CodigoAcao[$i], 'CorretoraAcao'=>$CorretoraAcao[$i], 'QuantidadeAcaoComprada'=>$QuantidadeAcaoComprada[$i], 'QuantidadeRestante'=>$QuantidadeRestanteAcao[$i], 'CustoAcao'=>$CustoAcao[$i], 'NotaFiscalAcao'=>$NotaFiscalAcao[$i], 'DataCompra'=>$DataCompra[$i]];        
            }
        }
    }
    $Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);
    echo $Banco_de_Dados_Recebido_Em_JSON;
    
    print_r($Banco_de_Dados_Recebido);
    echo "<br>";
    for ($i=0;$i<count($NomeAcao);$i++)
    {
        echo $Banco_de_Dados_Recebido[$i]['NomeAcao']." - ".$Banco_de_Dados_Recebido[$i]['CodigoAcao']."<br>";
    }
    echo "<br>";
    
    //Criando a div para a entrada dos dados
    echo '<div><!-- div vazia --></div>
         <div style="text-align: center;">
            <h2>Ações em Carteira</h2>
            <div style="grid-template-rows: 1fr; display: grid">
                <div style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr; display: grid">
                    <div>
                        <b>Ações</b>
                    </div>
                    <div>
                        <b>Corretora</b>
                    </div>
                    <div>
                        <b>Quantidade</b>
                    </div>
                    <div>
                        <b>Custo</b>
                    </div>
                    <div>
                        <b>Data da Compra</b>
                    </div>
                </div>
            </div>';
        for ($i=0;$i<count($NomeAcao);$i++)
        {    
            echo
            '<div style="grid-template-rows: 1fr; display: grid">
                <div style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr; display: grid">
                    <div>'.
                        $Banco_de_Dados_Recebido[$i]['NomeAcao']." - ".$Banco_de_Dados_Recebido[$i]['CodigoAcao'].
                    '</div>
                    <div>'.
                        $Banco_de_Dados_Recebido[$i]['CorretoraAcao'].
                    '</div>
                    <div>'.
                        $Banco_de_Dados_Recebido[$i]['QuantidadeRestante'].
                    '</div>
                    <div>'.
                        $Banco_de_Dados_Recebido[$i]['CustoAcao'].
                    '</div>
                    <div>'.
                        $Banco_de_Dados_Recebido[$i]['DataCompra'].
                    '</div>
                </div>
            </div>';

            if($i+1!=count($NomeAcao))
            {
                //Não é o ultimo termo
                if($Banco_de_Dados_Recebido[$i]['NomeAcao']!=$Banco_de_Dados_Recebido[$i+1]['NomeAcao'])
                {   
                    //Adiona uma linha entre os tipos de ações
                    echo '<div style="grid-template-rows: 1fr; display: grid"> <br> </div>';
                }
            }
            
        }
    echo'
        </div>
        <div>
            <h2>Cadastrar Venda</h2>
            <div style="grid-template-columns: 1fr 1fr; display: grid">
                <div style="text-align: right;">
                    <label for="NomeAcao">Nome da Ação:</label><br><br>
                    <label for="QuantidadeAcaoVendida">Quantidade da Ações Vendidas:</label><br><br>
                    <label for="PrecoVendido">Valor da Venda (Preço Bruto):</label><br><br>
                    <label for="NotaFiscalAcao">Nota Fiscal da Ação:</label><br><br>
                    <label for="DataVenda">Data da venda da Ação:</label><br><br>
                </div>
                <div>
                    <form method="POST" action="PHP/RegistraVenda.php" id="RegistraVenda">
                        <select name="NomeAcao" id="NomeAcao">';
                        for ($i=0;$i<count($NomeAcao);$i++)
                        {
                            $valor = '{"NomeAcao":"'.$Banco_de_Dados_Recebido[$i]['NomeAcao'].'","CodigoAcao":"'.$Banco_de_Dados_Recebido[$i]['CodigoAcao'].'","CorretoraAcao":"'.$Banco_de_Dados_Recebido[$i]['CorretoraAcao'].'"}';
                            echo '<option value='.$valor.'> '.$Banco_de_Dados_Recebido[$i]['NomeAcao']." - ".$Banco_de_Dados_Recebido[$i]['CodigoAcao'].'</option>';
                        }
    echo                '</select><br><br>
                        <input type="number" name="QuantidadeAcaoVendida" id="QuantidadeAcaoVendida" min="0" placeholder="Quantidade" required><br><br>
                        <input type="number" name="PrecoVendido" id="PrecoVendido" min="0" placeholder="Valor Bruto da Venda" step="0.001" onchange="ColocarOzero()" required><br><br>
                        <input type="number" name="NotaFiscalAcao" id="NotaFiscalAcao" min="0" placeholder="Nota Fiscal" required><br><br>
                        <input type="date" name="DataVenda" id="DataVenda" style="width: 172px;" required><br><br>
                    </form>
                </div>
            </div>
            <div style="text-align: center;">
                <div>
                    <input type="submit" value="Cadastrar Venda de Ações" form="RegistraVenda">
                </div>
            </div>
        </div>';
    */
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