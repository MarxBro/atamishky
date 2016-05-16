<?php
/*
 ***************************************************************
 Atencion: 
    este archivo es super secreto... ^_^
    Poner aca la contraseña maestra (o sea la única que tenemos), y 
    un salt para hashear la gran hashead de los hashiz.
 Nota: 
    este archivo es solamente levantado por functions.php y NO por 
    el conf.php que anda por ahí.
 ***************************************************************
*/

$PASS_BIBLIO_MASTER = 'pruebateta_2016';
$PASS_BIBLIO_MASTER_append = 'sabaduba$$&/()N';
$SALTI = '$5/HSm7=#u8nkhaahhaojno//8na=)=)????(j,.ksny61nnm18m1io"3g"u"W';
$PASS_PRESTAMO = md5(md5($PASS_BIBLIO_MASTER) . $SALTI) . $PASS_BIBLIO_MASTER_append;

?>
