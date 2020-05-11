<html>
<link rel="stylesheet" type="text/css" href="CSS.css" />
  <body bgcolor="#EDF1E3" >

<h2>Atualizar Registos</h2>
<?php
$codcli=$_GET ["codcli"];
$nome =$_POST ["nome"];
$morada=$_POST ["morada"];
if (!$codcli||!$nome||!$morada) {
	echo 'Campos em falta. Volte atrás e tente de novo.';
    exit;}
echo 'Dados Recebidos:<br>';
echo 'Codigo:'.$codcli.'<br>';
echo 'Nome:'.$nome.'<br>';
echo 'Morada:'.$morada.'<br>';
$ligax=mysqli_connect ('localhos','root');
if (!$ligax) {
	echo '<p>Erro: Falha na ligacao.';
	exit;}	
mysqli_select_db ($ligax,'vendas');
$atualiza="update clientes set nome='".$nome."',morada='".$morada."' where codcli='".$codcli."'";
$result=mysqli_query ($ligax,$atualiza);
if ($result==1) echo "<p>Dados atualizados.<br>";
else echo "<p> Dados nao atualizados. <br>";
?>
<a href="index.php"> Voltar a entrada</a><br>
<a href="listar.php"> Listar registos </a><br>
</body>
</html>
