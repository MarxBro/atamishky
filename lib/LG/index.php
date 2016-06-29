<!DOCTYPE html>
<html>  

<?php
include("verif.inc");
echo $header_bit;
?>

<body>
<div class="atamishky">
<h1 style="color: grey;">Autentificación ATAM</h1>

<div class="entry1">
    <p>Es necesario autentificarse para ver el enlace.</p>
    <p><b>Utilice sus datos de ingreso a la plataforma de Apoyo Virtual</b>.</p>
</div>

<div class="whitebox">
<div class="content">
<div align="right">
    <form id="formulario" method="post" action="submit.php">
        <fieldset>
            <legend>Login</legend>
            Nombre de Usuario: <input class="elemento" type="text" placeholder="Nombre de Usuario" name="nombreapellido" required>
            <br/>
            Contraseña: <input class="elemento" type="password" placeholder="Contraseña" name="pass" required>
        </fieldset>
        <button class="button" type="submit" value="<?php echo $_SESSION['secreto'];?>" name="formSubmit">INGRESAR</button>
    </form>
</div>
</div>
</div>


</div>
</body>
</html>
