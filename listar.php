<html>
  <body bgcolor="#EDF1E3" >


<h2>Listar Registos</h2>
<?php
$ligax=mysqli_connect ('localhost', 'root');
if (!$ligax) {
	echo '<p>Erro: falha na ligacao.';
	exit; }
mysqli_select_db ($ligax, 'vendas');
$consulta="select * from clientes";
$result=mysqli_query ($ligax,$consulta);
$nregisto= mysqli_num_rows ($result);
echo 'N de resgistos encontrados:'.$nregistos;
?>

<table border="1">
<tr><td>Codigo:<td>Nome:<td>Morada<td>Editar:</tr>
<?php
for ($i=0;$i<$nregisto;$i++)  
{
	$registo=mysqli_fetch_assoc ($result);
	echo '<tr>';
	echo '<td>' .$registo ['codcli']. '</td>';
	echo '<td>' .$registo ['Nome']. '</td>';
	echo '<td>' .$registo ['Morada']. '</td>';
	echo '<td><a href=index.php?codcli='.$registo ['codcli'].'">Editar </a></td>';
	echo '</tr>';
	echo '</p>';
}
?>
</table></body></html>
