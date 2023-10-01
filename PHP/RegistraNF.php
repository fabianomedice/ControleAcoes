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

$CorretoraAcao = $_POST["CorretoraNF"];
$NumeroNotaFiscal = $_POST["NumeroNotaFiscal"];
$DataNotafiscal = $_POST["DataNotafiscal"];
$ValorOperacoesTotais = $_POST["ValorOperacoesTotais"];
$TaxaLiquidacao = $_POST["TaxaLiquidacao"];
$Emolumentos = $_POST["Emolumentos"];
$TaxaOperacao = $_POST["TaxaOperacao"];
$Imposto = $_POST["Imposto"];
$IRRFvista = $_POST["IRRFvista"];
$IRRFDayTrade = $_POST["IRRFDayTrade"];
$CustoTotalOperacao = $TaxaLiquidacao+$Emolumentos+$TaxaOperacao+$Imposto;


//---------------------------------------
//Acesso ao Banco de dados
//---------------------------------------
//Procura se a nota fiscal já foi cadastrada antes
$sql = "SELECT * FROM notafiscal WHERE CorretoraNF = '".$CorretoraAcao."' AND NumeroNotaFiscal = '".$NumeroNotaFiscal."' AND DataNotafiscal = '".$DataNotafiscal."' AND ValorOperacoesTotais = '".$ValorOperacoesTotais."' AND TaxaLiquidacao = '".$TaxaLiquidacao."' AND Emolumentos = '".$Emolumentos."' AND TaxaOperacao = '".$TaxaOperacao."' AND Imposto = '".$Imposto."' AND IRRFvista = '".$IRRFvista."' AND IRRFDayTrade = '".$IRRFDayTrade."';";
//echo $sql;
$result = $BancoDeDados->query($sql);
if ($result->num_rows > 0) 
{
    //já existe a nota fiscal
    echo "<script>alert('Erro: A Nota Fiscal já foi Cadastrada')</script>";
} 
else 
{
    //Nenhuma nota fisca anterior encontrada

    //---------------------------------------
    //Acesso ao Banco de dados de notafiscal
    //---------------------------------------
    //Procura de termo
    $sql = "INSERT INTO notafiscal(CorretoraNF, NumeroNotaFiscal, DataNotafiscal, ValorOperacoesTotais, TaxaLiquidacao, Emolumentos, TaxaOperacao, Imposto, IRRFvista, IRRFDayTrade, CustoTotalOperacao, DataRegistro) VALUES ('".$CorretoraAcao."','".$NumeroNotaFiscal."','".$DataNotafiscal."','".$ValorOperacoesTotais."','".$TaxaLiquidacao."','".$Emolumentos."','".$TaxaOperacao."','".$Imposto."','".$IRRFvista."','".$IRRFDayTrade."','".$CustoTotalOperacao."','".date("Y-m-d")."');";
    //echo $sql;
    $result = $BancoDeDados->query($sql);

    echo "<script>alert('Nota Fiscal Cadastrada')</script>";
}

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();

echo '<script>window.location.href ="/notafiscal.html"</script>;'
?>