<html>
  <body bgcolor="#EDF1E3" >



<?php
$nomerem=$_POST ['nome'];
if (!$nomerem) {
	echo 'Volte atras e escreva o nome.';
	exit;
	}
echo '<p> Nome a remover:'.$nomerem.'<p>';
$ligax=mysqli_connect ('localhost','root');
if (!$ligax) {
	echo '<p>Erro: Falha na ligacao.';
	exit;}
mysqli_select_db ($ligax, 'vendas');
$consulta="select * from clientes";
$result =mysqli_query ($ligax,$consulta);
$nregistos_antes= mysqli_num_rows ($result);
$remove="delete from clientes where nome='".$nomerem."'";
$result=mysqli_query($ligax,$remove);
if ($result==0) echo"<p>Nao removido<br>";
echo 'Resultado:'.$result;
$consulta="select * from clientes";
$result=mysqli_query ($ligax,$consulta);
//$nregistos_depois=myqli_num_rows($result);
$nregistos_removidos=$nregistos_antes-$nregistos_depois;
echo '<p>N de registos removidos:'.$nregistos_removidos;
?>
<a href="listar.php"><p>Listar registos</p></a><br>
</body></html>