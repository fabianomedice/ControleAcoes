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


//echo $Acao = json_decode($_POST["NomeAcao"]);
$Acao = json_decode($_POST["NomeAcao"]);
$NomeAcao = $Acao->NomeAcao;
$CodigoAcao = $Acao->CodigoAcao;
$CorretoraAcao = $Acao->CorretoraAcao;
$QuantidadeAcaoVendida = htmlspecialchars($_POST["QuantidadeAcaoVendida"]);
$PrecoVendido = htmlspecialchars($_POST["PrecoVendido"]);
$NotaFiscalAcao = htmlspecialchars($_POST["NotaFiscalAcao"]);
$DataVenda = htmlspecialchars($_POST["DataVenda"]);


/*echo 'NomeAcao = '.$NomeAcao.'<br>';
echo 'CodigoAcao = '.$CodigoAcao.'<br>';
echo 'QuantidadeAcaoVendida = '.$QuantidadeAcaoVendida.'<br>';
echo 'PrecoVendido = '.$PrecoVendido.'<br>';
echo 'NotaFiscalAcao = '.$NotaFiscalAcao.'<br>';
echo 'DataVenda = '.$DataVenda.'<br>';*/


//---------------------------------------
//Acesso ao Banco de dados
//---------------------------------------
//Procura os valores restantes
$sql = "SELECT QuantidadeRestante FROM compra WHERE NomeAcao LIKE '".$NomeAcao."' AND CodigoAcao LIKE '".$CodigoAcao."';";
//echo $sql;
$result = $BancoDeDados->query($sql);
if ($result->num_rows > 0) 
{
    // output data of each row
    //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
    while($row = mysqli_fetch_array($result)) 
    {
        $Dados_Recebidos = $row["QuantidadeRestante"];
    }
    $QuantidadeRestante = $Dados_Recebidos-$QuantidadeAcaoVendida;
} 

//Procura de termo
$sql = "UPDATE compra SET QuantidadeRestante='".$QuantidadeRestante."' WHERE NomeAcao ='".$NomeAcao."' AND CodigoAcao ='".$CodigoAcao."';";
//echo $sql;
$result = $BancoDeDados->query($sql);

echo '<br>';

//---------------------------------------
//Acesso ao Banco de dados de venda
//---------------------------------------
//Procura de termo
$sql = "INSERT INTO venda(NomeAcao, CodigoAcao, CorretoraAcao, QuantidadeAcaoVendida, PrecoVendido, NotaFiscalAcao, DataVenda, DataRegistro) VALUES ('".$NomeAcao."','".$CodigoAcao."','".$CorretoraAcao."','".$QuantidadeAcaoVendida."','".$PrecoVendido."','".$NotaFiscalAcao."','".$DataVenda."','".date("Y-m-d")."');";
//echo $sql;
$result = $BancoDeDados->query($sql);


//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();

echo "<script>alert('Venda Cadastrada')</script>";
echo '<script>window.location.href ="/venda.html"</script>;'
?>