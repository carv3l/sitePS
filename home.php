<html>
<link rel="stylesheet" type="text/css" href="CSS.css" />

<h1> <p align="middle">Bem-vindo!</h1>
 <p align="center">Bem-vindo ao site de Masterflix.gp<br>
Aqui podes ver informa��es sobre filmes , s�ries e animes.<br>
Mas primeiro tens entrar conta <br>

<img src=IMG/ENTRETENIMENTO.png class="img1">

<form action="inserir.php" method="post">
<table style="text-align:center;"  border="1">
<tr><td>Codigo do cliente:</td>
<td><input type="text" name="cod"></td></tr>
<tr><td>Nome do cliente:</td>
<td><input type"text" name="nome"></td></tr>
<tr><td>Morada do cliente:</td>
<td><input type="text" name="morada"></td></tr>
<tr><td colspan="2" align="center">
  <input type="submit" value="Registar">
  </td></tr>
</table>
</form>
<a align="center" href="listar.php">Listar registos</a><br>
<a align="center" href="procurar.php">Procurar registos</a><br>


</body>
 </html>