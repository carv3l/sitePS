<html>
  <body bgcolor="#EDF1E3" >

<table >
<tr>
		<td align="center" height="100" WIDTH=500 > <a href="./index.php?page=home.php"><Img src="IMG/PaginaInicial.png"></a></td>
		<td align="center" height="100" WIDTH=500 > <a href="./index.php?page=Filmes.php"><Img src="IMG/Filmes.png"></a></td>
		<td align="center" height="100" WIDTH=500 > <a href="./index.php?page=Serie.php"><Img src="IMG/Series.png"></a></td>
		<td align="center" height="100" WIDTH=500 > <a href="./index.php?page=Animes.php"><Img src="IMG/Animes.png"></a></td>
		<td align="center" height="100" WIDTH=500 > <a href="./index.php?page=Ajuda.php"><Img src="IMG/Ajuda.png"></a></td>
	</tr>
	</td>
</table>

<?php
$cod=$_POST['cod'];
$nome=$_POST['nome'];
$morada=$_POST['morada'];
echo 'Dados recebidos:<br>';
echo 'Codigo:'.$cod.'<br>';
echo 'Nome:'.$nome.'<br>';
echo 'Morada:'.$morada.'<br>';
$ligax=mysqli_connect('localhost','root');
if (!$ligax){
    echo '<p>Erro: Falha na ligacao.';
    exit;}
mysqli_select_db($ligax,'vendas');
$insere="insert into clientes values('".$cod."','".$nome."','".$morada."')";
$result=mysqli_query($ligax,$insere);
if ($result==1) echo "<p>Dados Inseridos.<br>";
else echo "<p> Dados nao Inseridos.<br>";
?>
<a href="index.php">Voltar a entrada </a><br>
<a href="listar.php">Listar registos</a><br>
</body>
</html>
align="center" height="100" WIDTH=50