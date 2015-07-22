<?php
session_start();
ob_start();
?>
<?php include("../adminuser/adminpro_class.php");
$prot=new protect("1");
if ($prot->showPage) {
$curUser=$prot->getUser();
?> 

<?php
			header("Pragma: ");
			header('Cache-control: ');
			header("Expires: Mon, 26 Jul 2017 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Content-type: application/vnd.ms-excel");
			header("Content-disposition: attachment; filename=proveedores.xls");
		
			
?>
<html>
<head>
<title>
</title>
</head>
<body>			
			<table>
			<tr><td align="center" colspan="14"><h4>Sistema ERP</h4></td></tr>
			<tr><td align="center" colspan="14"><b>Cat&aacute;logo de Proveedores</b></td></tr>
            <tr><td align="center" colspan="14">&nbsp;</td></tr>
			</table>
			
			<table border="1px" border-color="#889b08">
			
			<tr valign="middle" align="center" bgcolor="#e3ef77">
            <td rowspan="2"><b>Clave</b></td>
			<td rowspan="2"><b>Nombre</b></td>
            <td rowspan="2"><b>Contacto</b></td>
            <td colspan="7"><b>Domicilio</b></td>
			<td rowspan="2"><b>Tel&eacute;fono</b></td>
            <td rowspan="2"><b>E-mail</b></td>
            <td rowspan="2"><b>RFC</b></td>
            <td rowspan="2"><b>D&iacute;as de Cr&eacute;dito</b></td>
            </tr>
            <tr valign="middle" align="center" bgcolor="#e3ef77">
			<td><i>Calle</i></td>
			<td><i>N&uacute;mero</i></td>
			<td><i>Colonia</i></td>
			<td><i>C.P.</i></td>
			<td><i>Ciudad</i></td>
			<td><i>Estado</i></td>
			<td><i>Pa&iacute;s</i></td>
			</tr>
			
			<?php 
				include("../lib/mysql.php");
				$db = new MySQL();

				$lista_proveedores = $db->consulta("SELECT *  FROM `proveedor` ORDER BY id_proveedor;");
				while ($row = $db->fetch_array($lista_proveedores))
					{
					$numero = $row['id_proveedor'];
					$nombre = $row['nombre'];
					$calle = $row['calle'];
					$num = $row['numero'];
					$colonia = $row['colonia'];
					$ciudad = $row['ciudad'];
					$estado = $row['estado'];
					$tel = $row['telefono'];
					$cp = $row['codigo_postal'];
					$mail = $row['correo'];
					$rfc = $row['rfc'];
					$contacto = $row['contacto'];
					$dias = $row['dias'];
					
					$cve_pais = $row['pais'];
					$consulta_pais = $db->consulta("SELECT *  FROM `pais` WHERE `Code` = '".$cve_pais."';");
					while ($row2 = $db->fetch_array($consulta_pais))
					{
						$pais = utf8_decode($row2['Name']);
					}
					
					
					 echo "<tr><td align=\"center\">".$numero."</td>
					 <td>".$nombre."</td>
					 <td>".$contacto."</td>	
					 <td align=\"left\">".$calle."</td>
					 <td align=\"left\">".$num."</td>
					 <td align=\"left\">".$colonia."</td>
					 <td align=\"left\">".$cp."</td>
					 <td align=\"left\">".$ciudad."</td>
					 <td align=\"left\">".$estado."</td>
					 <td align=\"left\">".$pais."</td>
					 <td align=\"left\">".$tel."</td>
					 <td align=\"left\">".$mail."</td>
					 <td align=\"left\">".$rfc."</td>
					 <td align=\"center\">".$dias."</td>
					 </tr>";
					
					}
			?>
			
			
			</table>
			
</body>
</html>
<?php
}
?> 
<?php
ob_end_flush();
?> 
