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


$AcaoVenda = json_decode($_POST["NomeAcaoVenda"]);
//{"NomeAcao":"BR63","CodigoAcao":"2","CorretoraAcao":"Ativa","QuantidadeAcaoVendida":"200","PrecoVendido":"16","NotaFiscalAcao":"49854184","DataVenda":"2020-12-02"}
$AcaoCompra = json_decode($_POST["NomeAcaoCompra"]);
//{"NomeAcao":"BR63","CodigoAcao":"3","QuantidadeDisponivel":"100"}
$QuantidadeAcaoTransferida = $_POST["QuantidadeAcaoTransferida"];
//100


//---------------------------------------
//Acesso ao Banco de dados Compra
//---------------------------------------
//Altera a quantidade das ações compradas
$sql = "UPDATE compra SET QuantidadeRestante ='".($AcaoCompra->QuantidadeDisponivel-$QuantidadeAcaoTransferida)."' WHERE NomeAcao ='".$AcaoCompra->NomeAcao."' AND CodigoAcao ='".$AcaoCompra->CodigoAcao."';";
//echo $sql."<br>";
$result = $BancoDeDados->query($sql);

//---------------------------------------
//Acesso ao Banco de dados Compra
//---------------------------------------
//Busca a quantidade da ação vendida
$sql = "SELECT QuantidadeRestante FROM compra WHERE NomeAcao ='".$AcaoVenda->NomeAcao."' AND CodigoAcao ='".$AcaoVenda->CodigoAcao."';";
//echo $sql."<br>";
$result = $BancoDeDados->query($sql);
if ($result->num_rows > 0) 
{
    // output data of each row
    //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
    while($row = mysqli_fetch_array($result)) 
    {
        $Dados_Recebidos = $row["QuantidadeRestante"];
    }
    $QuantidadeFinalAtualizada = $Dados_Recebidos+$QuantidadeAcaoTransferida;
} 
//Altera a quantidade da ação vendida (devolve para a cartela)
$sql = "UPDATE compra SET QuantidadeRestante ='".$QuantidadeFinalAtualizada."' WHERE NomeAcao ='".$AcaoVenda->NomeAcao."' AND CodigoAcao ='".$AcaoVenda->CodigoAcao."';";
//echo $sql."<br>";
$result = $BancoDeDados->query($sql);

//---------------------------------------
//Acesso ao Banco de dados Venda
//---------------------------------------
//Altera a ação de Venda
if($AcaoVenda->QuantidadeAcaoVendida - $QuantidadeAcaoTransferida ==0)
{
    //Quantidade da Venda Zerou
    //Deleta a venda
    $sql = "DELETE FROM venda WHERE NomeAcao ='".$AcaoVenda->NomeAcao."' AND CodigoAcao ='".$AcaoVenda->CodigoAcao."' AND CorretoraAcao ='".$AcaoVenda->CorretoraAcao."' AND PrecoVendido ='".$AcaoVenda->PrecoVendido."' AND NotaFiscalAcao ='".$AcaoVenda->NotaFiscalAcao."' AND DataVenda ='".$AcaoVenda->DataVenda."';";
}
else
{
    //Só altera a quantidade da venda
    $sql = "UPDATE venda SET QuantidadeAcaoVendida ='".($AcaoVenda->QuantidadeAcaoVendida - $QuantidadeAcaoTransferida)."' WHERE NomeAcao ='".$AcaoVenda->NomeAcao."' AND CodigoAcao ='".$AcaoVenda->CodigoAcao."' AND CorretoraAcao ='".$AcaoVenda->CorretoraAcao."' AND PrecoVendido ='".$AcaoVenda->PrecoVendido."' AND NotaFiscalAcao ='".$AcaoVenda->NotaFiscalAcao."' AND DataVenda ='".$AcaoVenda->DataVenda."';";
}
//echo $sql."<br>";
$result = $BancoDeDados->query($sql);
//Cria a venda sobre os dados da troca


//Confere se já tem venda ou não

//---------------------------------------
//Acesso ao Banco de dados venda
//---------------------------------------
//Busca a quantidade da ação vendida
$sql = "SELECT *  FROM venda WHERE NomeAcao ='".$AcaoCompra->NomeAcao."' AND CodigoAcao ='".$AcaoCompra->CodigoAcao."';";
//echo $sql."<br>";
$result = $BancoDeDados->query($sql);
if ($result->num_rows > 0) 
{
    $achou = false;
    // output data of each row
    //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
    while($row = mysqli_fetch_array($result)) 
    {
        if( $AcaoVenda->CorretoraAcao == $row["CorretoraAcao"] && $AcaoVenda->PrecoVendido == $row["PrecoVendido"] && $AcaoVenda->NotaFiscalAcao == $row["NotaFiscalAcao"] && $AcaoVenda->DataVenda == $row["DataVenda"])
        {
            //Mesma venda
            $QuantidadeRegistrada= $row["QuantidadeAcaoVendida"];
            $achou = true;
        }
        else
        {
            //Não achou a venda
            if(!$achou)
            {
                $QuantidadeRegistrada= 0;
            }
        }
        
    }
}
else
{
    //Não achou a venda
    $QuantidadeRegistrada= 0;
}

if($QuantidadeRegistrada == 0)
{
    //Venda não existe
    $sql = "INSERT INTO venda(NomeAcao, CodigoAcao, CorretoraAcao, QuantidadeAcaoVendida, PrecoVendido, NotaFiscalAcao, DataVenda ) VALUES ('".$AcaoCompra->NomeAcao."','".$AcaoCompra->CodigoAcao."','".$AcaoVenda->CorretoraAcao."','".$QuantidadeAcaoTransferida."','".$AcaoVenda->PrecoVendido."','".$AcaoVenda->NotaFiscalAcao."','".$AcaoVenda->DataVenda."');";
}
else
{
    //Existe a venda
    $sql = "UPDATE venda SET QuantidadeAcaoVendida ='".($QuantidadeRegistrada + $QuantidadeAcaoTransferida)."' WHERE NomeAcao ='".$AcaoCompra->NomeAcao."' AND CodigoAcao ='".$AcaoCompra->CodigoAcao."' AND CorretoraAcao ='".$AcaoVenda->CorretoraAcao."' AND PrecoVendido ='".$AcaoVenda->PrecoVendido."' AND NotaFiscalAcao ='".$AcaoVenda->NotaFiscalAcao."' AND DataVenda ='".$AcaoVenda->DataVenda."';";
}
//echo $sql;
$result = $BancoDeDados->query($sql);

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();

echo "<script>alert('Venda Alterada')</script>";
echo '<script>window.location.href ="/mudancavenda.html"</script>;'
?>