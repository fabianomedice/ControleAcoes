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

/*
echo $CorretoraAcao."<br>";
echo $NumeroNotaFiscal."<br>";
echo $DataNotafiscal."<br>";
echo $ValorOperacoesTotais."<br>";
echo $TaxaLiquidacao."<br>";
echo $Emolumentos."<br>";
echo $TaxaOperacao."<br>";
echo $Imposto."<br>";
echo $IRRFvista."<br>";
echo $IRRFDayTrade."<br>";
*/

//---------------------------------------
//Acesso ao Banco de dados
//---------------------------------------
//Procura de termo
$sql = "DELETE FROM notafiscal WHERE CorretoraNF = '".$CorretoraAcao."' AND NumeroNotaFiscal = '".$NumeroNotaFiscal."' AND DataNotafiscal = '".$DataNotafiscal."' AND ValorOperacoesTotais = '".$ValorOperacoesTotais."' AND TaxaLiquidacao = '".$TaxaLiquidacao."' AND Emolumentos = '".$Emolumentos."' AND TaxaOperacao = '".$TaxaOperacao."' AND Imposto = '".$Imposto."' AND IRRFvista = '".$IRRFvista."' AND IRRFDayTrade = '".$IRRFDayTrade."';";
//echo $sql;
$result = $BancoDeDados->query($sql);

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();
echo "<script>alert('Nota Fiscal Descadastrada')</script>";
echo '<script>window.location.href ="/cancelarcadastro.html"</script>;'
?>