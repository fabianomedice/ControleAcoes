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
$CodigoAcao = htmlspecialchars($_POST["CodigoAcao"]);
$CorretoraAcao = htmlspecialchars($_POST["CorretoraAcao"]);
$QuantidadeAcaoComprada = htmlspecialchars($_POST["QuantidadeAcaoComprada"]);
$CustoAcao = htmlspecialchars($_POST["CustoAcao"]);
$NotaFiscalAcao = htmlspecialchars($_POST["NotaFiscalAcao"]);
$DataCompra = htmlspecialchars($_POST["DataCompra"]);

/*
echo $NomeAcao."<br>";
echo $CodigoAcao."<br>";
echo $CorretoraAcao."<br>";
echo $QuantidadeAcaoComprada."<br>";
echo $CustoAcao."<br>";
echo $NotaFiscalAcao."<br>";
echo $DataCompra."<br>";
*/

//---------------------------------------
//Acesso ao Banco de dados
//---------------------------------------
//Procura se a ação já foi cadastrada antes
$sql = "SELECT CodigoAcao FROM compra WHERE NomeAcao LIKE '".$NomeAcao."';";
//echo $sql;
$result = $BancoDeDados->query($sql);
if ($result->num_rows > 0) 
{
    $UltimoCodigoAcao = 0;
    // output data of each row
    //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
    while($row = mysqli_fetch_array($result)) 
    {
        $Dados_Recebidos = $row["CodigoAcao"];
        if($UltimoCodigoAcao<=$Dados_Recebidos)
        {
            $UltimoCodigoAcao = $Dados_Recebidos;
        }
    }
} 

if ($UltimoCodigoAcao == $CodigoAcao)
{
    //É a ultima ação cadastrada

    //---------------------------------------
    //Acesso ao Banco de dados
    //---------------------------------------
    //Procura de termo
    $sql = "DELETE FROM compra WHERE NomeAcao = '".$NomeAcao."' AND CodigoAcao = '".$CodigoAcao."' AND CorretoraAcao = '".$CorretoraAcao."' AND QuantidadeAcaoComprada = '".$QuantidadeAcaoComprada."' AND CustoAcao = '".$CustoAcao."' AND NotaFiscalAcao = '".$NotaFiscalAcao."' AND DataCompra = '".$DataCompra."' AND QuantidadeRestante = '".$QuantidadeAcaoComprada."';";
    //echo $sql;
    $result = $BancoDeDados->query($sql);
    echo "<script>alert('Compra Descadastrada')</script>";
    echo '<script>window.location.href ="/cancelarcadastro.html"</script>;';
}
else
{
    //Não é a ultima ação cadastrada
    echo 'Não é a ultima ação cadastrada <br>';

    //---------------------------------------
    //Acesso ao Banco de dados
    //---------------------------------------
    //Procura de termo
    $sql = "DELETE FROM compra WHERE NomeAcao = '".$NomeAcao."' AND CodigoAcao = '".$CodigoAcao."' AND CorretoraAcao = '".$CorretoraAcao."' AND QuantidadeAcaoComprada = '".$QuantidadeAcaoComprada."' AND CustoAcao = '".$CustoAcao."' AND NotaFiscalAcao = '".$NotaFiscalAcao."' AND DataCompra = '".$DataCompra."' AND QuantidadeRestante = '".$QuantidadeAcaoComprada."';";
    //echo $sql."<br>";
    $result = $BancoDeDados->query($sql);

    //Atualiza o código das próximas para não ficar um vázio
    for ($i = 0; $i < ($UltimoCodigoAcao-$CodigoAcao) ; $i++) 
    {
        $sql = "UPDATE compra SET CodigoAcao = '".($CodigoAcao+$i)."' WHERE NomeAcao = '".$NomeAcao."' AND CodigoAcao = '".($CodigoAcao+$i+1)."';";
        //echo $sql."<br>";
        $result = $BancoDeDados->query($sql);
    }
    echo "<script>alert('Compra Descadastrada')</script>";
    echo '<script>window.location.href ="/cancelarcadastro.html"</script>;';
}

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();

?>