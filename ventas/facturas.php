<?php include("../adminuser/adminpro_class.php");
$prot=new protect("1");
if ($prot->showPage) {
$curUser=$prot->getUser();
include("../lib/mysql.php");
$db = new MySQL();
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="../images/favicon.ico">
<title>Sistema de ERP</title>
<link href="../styles/templatemo_style.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="../js/jquery.js"></script> 
<script type="text/javascript" src="../js/jquery-latest.js"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.pager.js"></script>
<script type="text/javascript" src="../js/chili/chili-1.8b.js"></script>
<script type="text/javascript" src="../js/docs.js"></script>

<script type="text/javascript" src="../js/jquery.alerts.js"></script>
<script src="../js/jquery.ui.draggable2.js"></script>

<!-- script que hace el ordenamiento de la tabla -->
<script type="text/javascript">
	$(document).ready(function() 
		{ 
			$("#tablesorter-test").tablesorter({sortList:[[0,1]], widthFixed: true, widgets: ['zebra'], headers: { 4:{sorter: false},5:{sorter: false},6:{sorter: false}}});
			 $("#tablesorter-test").tablesorterPager({container: $("#pager")});
		} 
	);
</script>
<!--Script que confirma el borrado de un registro -->
<script language="JavaScript">
	function confirma (url,numero) {
	if (confirm("CUIDADO!!!\nEst\u00e1 seguro que desea eliminar o cancelar la factura n\u00famero " + numero +"?\nTodos los registros ser\u00e1n eliminados y la operaci\u00f3n no podr\u00e1 ser revertida")) location.replace(url);
	}
</script>

<SCRIPT LANGUAGE="JavaScript">
<!-- Funcion que valida que se hayan escrito los campos obligatorios en el formulario de buscar-->
	function validarBusqueda() {
		if (document.busqueda.parametro.value == "") {
			alert ('Debe escribir un valor en el campo de busqueda');
			document.getElementById('parametro').focus();
			return false;
		}
	}
</script>

</head>
<body>

<div id="templatemo_wrapper">

	<div id="templatemo_header">

    	<div id="site_title">
            <h1><a href="#">Sistema de ERP<span><?php echo 'Bienvenido, <b> '.$curUser.' </b>'; ?></span></a></h1>
        </div> <!-- end of site_title -->
        
        <div class="cleaner"></div>
    </div> <!-- end of templatemo_header -->
    
    <div id="templatemo_menu">
        <ul>
            <li><a href="../inicio.php">Inicio</a></li>
            <li><a href="ventas.php">Ventas</a></li>
            <li><a href="facturas.php" class="current">Facturaci&oacute;n</a></li>
           	<li><a href="#" onclick="javascript:document.forms['salir'].submit();">Salir</a></li>
         <?php
			echo '<form action="logout.php" method="POST" name="salir" id="salir">
			<input type="hidden" name="action" value="logout">';
			echo'</form>';
		?>
        </ul>    	
    </div> <!-- end of templatemo_menu -->

    <div id="templatemo_banner_wrapper">
    
    <div id="templatemo_banner_thin"> 
    
    	
    
    	<div class="cleaner"></div>
        
    </div> <!-- end of banner -->
    
    </div>	<!-- end of banner_wrapper -->
    
    <div id="templatemo_service_bar_wrapper">
    
    <div id="templatemo_service_bar">
    
    	<div class="sb_box sb_box_last">
                
            <img src="../images/iconos/onebit_78.png" alt="image 3" />
            <a href="nueva_factura.php">Nueva Factura</a>
            
        </div>

         <div class="sb_box">
            <a href="#">Buscar</a>
            <img src="../images/iconos/onebit_02.png" alt="image 1" />
            <form method="get" action="facturas.php" name="busqueda" id="busqueda" onSubmit="return validarBusqueda()"> 
            <input type="text" class="texto" width="30" name="parametro" id="parametro" />
            <input class="submit_btn reset" type="submit" value="Ir"/>
            </form>
        </div>
        
        
        
    
    </div> <!-- end of templatemo_service_bar -->
    
    </div> <!-- end of templatemo_service_bar_wrapper -->
    
    <div id="templatemo_content_wrapper">
    <div id="templatemo_content">
    
    	<div class="col_w565">
    
            <h2>Lista de Facturas</h2>
            
            
            <table id="tablesorter-test" class="tablesorter" cellspacing="0">
            <thead>
                <tr align="center">
                    <th class="header">No.</th>
                    <th class="header">Cliente</th>
                    <th class="header">Fecha</th>
                    <th class="header">Estado</th>
                    <th>Ver</th>
                    <th>Editar</th>
                    <th>Eliminar/<br />Cancelar</th>
                </tr>
            </thead>
            <tbody>
            
				<?php 
                    $db = new MySQL();
    				$i = 1;
					
					if (isset($_GET['parametro'])) {
						  $buscar = $_GET['parametro'];
						  $cons ="SELECT * FROM `factura` WHERE `id_factura`= '$buscar' OR `id_cliente` in (SELECT `id_cliente` FROM `cliente` WHERE `nombre` like '%$buscar%') ORDER BY id_factura DESC;";
						  $lista_facturas = $db->consulta($cons);
						  
						  $mensaje = "Resultados de la b&uacute;squeda que contienen la palabra clave <b>$buscar</b>";
					  }else{
						  $lista_facturas = $db->consulta("SELECT * FROM `factura` ORDER BY id_factura DESC LIMIT 20;");
						  $mensaje = "Se muestran las ultimas 20 facturas generadas, para localizar una factura en especifico, use el campo de busqueda.";
					  }
					  
					echo "<span><i>$mensaje<i></span>";
                    while ($rowf = $db->fetch_array($lista_facturas))
                        {
							$clave = $rowf['id_factura'];
							$folio = $rowf['folio'];
							$id_serie = $rowf['id_serie'];
							
							//consultare si la serie tiene alguna letra
							$consulta_ser = $db->consulta("SELECT letra  FROM `series` WHERE `id_serie` = '".$id_serie."';");
							while ($row2 = $db->fetch_array($consulta_ser)){
								$serie = $row2['letra'];
							}
							$interno = $folio." ".$serie;
							
							//voy a separar la fecha de la hora
							$fecha = $rowf['fecha'];
							$fechas = explode("T", $fecha);
							$solo_fecha = $fechas[0];
							
							$id_cli= $rowf['id_cliente'];
							//buscar el nombre del cliente
							/*$consulta_cte = $db->consulta("SELECT *  FROM `cliente` WHERE `id_cliente` = '".$id_cte."';");
							while ($row2 = $db->fetch_array($consulta_cte)){
								$cliente = $row2['nombre'];
							}*/
							
							
							$sql_cli = "SELECT * FROM cliente where `id_cliente`='".$id_cli."'";
							$consulta_cli = $db->consulta($sql_cli);
							while($row_cli = mysql_fetch_array($consulta_cli)){
								$nom_cliente=$row_cli['nombre'];
							}
							
							
							
							$id_status = $rowf['id_status_factura'];
							//buscar el status
							$consulta_sta = $db->consulta("SELECT *  FROM `status_factura` WHERE `id_status_factura` = '".$id_status."';");
							while ($row3 = $db->fetch_array($consulta_sta)){
								$status = $row3['status'];
							}
							
							
							 echo "<tr align=\"center\">
							 <td class=\"listado\">".$clave."</td>
							 <td align=\"left\">".utf8_decode($nom_cliente)."</td>
							 <td class=\"listado\">".$solo_fecha."</td>
							 <td class=\"listado\">".$status."</td>
							 <td class=\"listado\"><a class=\"icono\" title=\"Ver Factura\" href=\"ficha_factura.php?numero=".$clave."\"><img src=\"../images/iconos/onebit_39.png\" width=\"24px\" align=\"center\"></a></td>";
							 if($id_status==1){
								 echo "<td class=\"listado\"><a class=\"icono\" title=\"Editar Factura\" href=\"editar_factura.php?numero=".$clave."\"><img src=\"../images/iconos/onebit_20.png\" width=\"24px\" align=\"center\"></a></td>
							 <td class=\"listado\"><a class=\"icono\" title=\"Borrar Factura\" href=JavaScript:confirma(\"http://localhost/imprenta/ventas/borrar_factura.php?numero=$clave\",\"$clave\");><img src=\"../images/iconos/onebit_33.png\" width=\"24px\" align=\"center\"></a></td>
							 </tr>";
							 }else{
								 if($id_status==2){
									 echo "<td class=\"listado\">Operacion <br>No Permitida</td>
							 		<td class=\"listado\"><a class=\"icono\" title=\"Cancelar Factura\"  href=JavaScript:confirma(\"http://localhost/imprenta/ventas/cancelar_factura.php?numero=$clave\",\"$clave\");><img src=\"../images/iconos/onebit_35.png\" width=\"24px\" align=\"center\"></a></td></tr>";
								 }else{
									 echo "<td class=\"listado\">Operacion <br>No Permitida</td>
							 		<td class=\"listado\">Operacion <br>No Permitida</td></tr>";
								 }
								 
							 }
							 
							 
							$i++;
                        }
						
                ?>
            </tbody>
            </table>
        <br /> <br />
         <div id="pager" class="tablesorterPager" align="center">
        <form>
            <img src="../images/first.png" class="first"/>
            <img src="../images/prev.png" class="prev"/>
            <input type="text" class="pagedisplay"/>
            <img src="../images/next.png" class="next"/>
            <img src="../images/last.png" class="last"/>
            <select class="pagesize">
                <option selected="selected"  value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option  value="40">40</option>
            </select>
        </form>
       </div>
        
        
            
            
       	  <div class="cleaner_h20"></div>
            
            
		</div>
        
        <div class="col_260 col_last">
        
            <h2>Opciones</h2>
            
        	<div class="sb_news_box">
            	<ul class="tmo_list col_260">
                     <li><span>&raquo;</span><a href="lista_facturas.php">Exportar a Excel</a></li>
               </ul>
               
            </div>
            
            
            
        </div>
        
        <div class="cleaner"></div>
    </div>
    </div>

</div> <!-- end of templatemo_wrapper -->

<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">

       	<a href="#">C&eacute;nit Consultores</a>
    
    </div> <!-- end of templatemo_footer -->
</div> <!-- end of templatemo_footer_wrapper -->

</body>
</html>
<?php
}
?>