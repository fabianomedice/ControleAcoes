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


$NomeAcao = htmlspecialchars($_POST["NomeAcao"]);
$CorretoraAcao = htmlspecialchars($_POST["CorretoraAcao"]);
$QuantidadeAcaoComprada = htmlspecialchars($_POST["QuantidadeAcaoComprada"]);
$CustoAcao = htmlspecialchars($_POST["CustoAcao"]);
$NotaFiscalAcao = htmlspecialchars($_POST["NotaFiscalAcao"]);
$DataCompra = htmlspecialchars($_POST["DataCompra"]);

//---------------------------------------
//Acesso ao Banco de dados
//---------------------------------------
//Procura se a ação já foi cadastrada antes
$sql = "SELECT CodigoAcao, DataCompra FROM compra WHERE NomeAcao LIKE '".$NomeAcao."';";
//echo $sql;
$result = $BancoDeDados->query($sql);
if ($result->num_rows > 0) 
{
    $CodigoAcao = 0;
    $UltimaData = '';
    // output data of each row
    //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
    while($row = mysqli_fetch_array($result)) 
    {
        $Dados_Recebidos = $row["CodigoAcao"];
        if($CodigoAcao<=$Dados_Recebidos)
        {
            $CodigoAcao = $Dados_Recebidos+1;
            $UltimaData = $row["DataCompra"];
        }
    }
} 
else 
{
    //Nenhuma ação anterior encontrada
    $CodigoAcao = "1";
    $UltimaData = "1990-01-01";
}

//Atualiza a trava de dia para no máximo 3 dias antes do ultimo cadastro.
$UltimaDataMenos3 = date ("Y-m-d", strtotime ($UltimaData ."-3 days"));

if($DataCompra>=$UltimaDataMenos3)
{
    //echo "<br>A data de compra (".$DataCompra.") é maior ou igual a ultima data registrada (".$UltimaData.")<br>Registra<br><br>";

    //---------------------------------------
    //Acesso ao Banco de dados
    //---------------------------------------
    //Procura de termo
    $sql = "INSERT INTO compra(NomeAcao, CodigoAcao, CorretoraAcao, QuantidadeAcaoComprada, CustoAcao, NotaFiscalAcao, DataCompra, QuantidadeRestante, DataRegistro) VALUES ('".$NomeAcao."','".$CodigoAcao."','".$CorretoraAcao."','".$QuantidadeAcaoComprada."','".$CustoAcao."','".$NotaFiscalAcao."','".$DataCompra."','".$QuantidadeAcaoComprada."','".date("Y-m-d")."');";
    //echo $sql;
    $result = $BancoDeDados->query($sql);
    echo "<script>alert('Compra Cadastrada')</script>";
    echo '<script>window.location.href ="/compra.html"</script>;';
}
else
{
    //echo "<br>A data de compra (".$DataCompra.") é menor a ultima data registrada (".$UltimaData.")<br>Não registra<br><br>";
    echo "<script>alert('ERRO: Compra Não Cadastrada')</script>";

    //---------------------------------------
    //Acesso ao Banco de dados
    //---------------------------------------
    //Procura se a ação já foi cadastrada antes
    $sql = "SELECT * FROM compra WHERE NomeAcao = '".$NomeAcao."' AND CorretoraAcao = '".$CorretoraAcao."' AND CustoAcao = '".$CustoAcao."' AND NotaFiscalAcao = '".$NotaFiscalAcao."' AND DataCompra = '".$DataCompra."';";
    //echo $sql;
    $result = $BancoDeDados->query($sql);
    if ($result->num_rows > 0) 
    {
        // output data of each row
        //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
        while($row = mysqli_fetch_array($result)) 
        {
            echo '<span style="font-size:50px">Favor conferir em "<b>Histórico de Notas Fiscais</b>" a ação '.$row["NomeAcao"].' - '.$row["CodigoAcao"].' comprada em '.$row["DataCompra"].'.</span><br>';
        }
    }
    else 
    {
        //Nenhuma ação anterior encontrada
        echo '<span style="font-size:50px">Conferir se a operação é Venda ou se tudo foi digitado certo. O último papel '.$NomeAcao.' da '.$CorretoraAcao.' cadastrado foi em '.$UltimaData.' e você está querendo registrar uma ação do dia '.$DataCompra.' que é pelo menos mais de 3 dias anterior ao último registro.</span><br>';
    }

    echo '<br><button type="button" onclick="window.location.href ='."'/compra.html'".'" style="font-size:50px">Voltar</button>';
}


//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();

?>