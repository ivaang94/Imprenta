<?php
ob_start();
include("../adminuser/adminpro_class.php");
$prot=new protect("1");
if ($prot->showPage) {
$curUser=$prot->getUser();
include("../lib/mysql.php");
$db = new MySQL();
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<a href="#">Sistema de ERP<span>

</head>
<body>


            
           	<?php
				$db = new MySQL();
				$factura = $_GET['numero'];
				$registro = $_GET['key'];
				
			
				$db->consulta("DELETE FROM detalle_factura WHERE id_detalle_fact='".$registro."';");
				
				$link = "Location: ficha_factura.php?numero=$factura";
				header($link);
				
				
			?>
 

</body>
</html>
<?php
}
ob_end_flush();
?>