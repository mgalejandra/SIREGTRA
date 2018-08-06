<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="css/stilos.css" type="text/css">
  </head>
  <DIV class="pagina">
<DIV align="left">

<? 
echo $_FILES['file']['tmp_name'];
$destino = 'archivos'; 
if(copy($_FILES['file']['tmp_name'], $destino.'/'.$_FILES['file']['name']))echo ' archivo arriba'; 
else echo ' falla';
?>


<form action="" method="post" enctype="multipart/form-data" > 
 <input type="file" name="file" />
 <input type="hidden" name="MAX_FILE_SIZE" value="100000000"> 
 <input type="submit" name="submit" value="Subir imagen" /> 
</form>

</DIV>
</body>
</html>

