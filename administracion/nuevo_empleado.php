<?php
ob_start();
?>
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
<link rel="stylesheet" href="../styles/ui-lightness/jquery.ui.all.css">
<script language="javascript" src="../js/jquery.js"></script> 
<script type="text/javascript" src="../js/jquery-latest.js"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.pager.js"></script>
<script type="text/javascript" src="../js/chili/chili-1.8b.js"></script>
<script type="text/javascript" src="../js/docs.js"></script>

<script type="text/javascript" src="../js/jquery.alerts.js"></script>
<script src="../js/jquery.ui.draggable2.js"></script>

<script src="../js/jquery-1.4.2.js"></script>
<script src="../js/jquery.ui.core.js"></script>
<script src="../js/jquery.ui.widget.js"></script>
<script src="../js/jquery.ui.datepicker.js"></script>
<script src="../js/valida/jquery.validate.js"></script>
<script src="../js/localization/messages_es.js"></script>

<script>
$(function() {
	$( "#alta" ).datepicker({
		changeMonth: true,
		changeYear: true,
		showOn: 'both',
		buttonImage: "../images/calendar.gif",
		buttonImageOnly: true,
		dateFormat: 'yy-mm-dd',
		showWeek: true,
		showOtherMonths: false,
		selectOtherMonths: false

  
	});
	
	$( "#baja" ).datepicker({
		changeMonth: true,
		changeYear: true,
		showOn: 'both',
		buttonImage: "../images/calendar.gif",
		buttonImageOnly: true,
		dateFormat: 'yy-mm-dd',
		showWeek: true,
		showOtherMonths: false,
		selectOtherMonths: false

  
	});
});
</script>
<script type="text/javascript">
<!-- muestra y oculta campos en el formulario segun el select
function mostrar(){
//Si la opcion con id Conocido_1 (dentro del documento > formulario con name fcontacto >     y a la vez dentro del array de Conocido) esta activada
if (document.registro.status.value == "2") {
	//muestra la fecha de baja cuando el status es suspendido
	document.getElementById('dbaja').style.display='block';
	document.getElementById('baja').focus();
} else {
	if(document.registro.status.value == "3"){
		//muestra la fecha de baja cuando el status es vetado
		document.getElementById('dbaja').style.display='block';
		document.getElementById('baja').focus();
	}else{
		if(document.registro.status.value == "1" || document.registro.status.value == "-1"){
			//oculta y limina la fecha de baja cuando el status es activo
			document.getElementById('dbaja').style.display='none';
			document.registro.baja.value = "";
		}
		}
	}
	//oculta el div con id 'desdeotro'
}


-->
</script>



<SCRIPT LANGUAGE="JavaScript">

	function validar() {
		if (document.registro.cve.value == "") {
			alert ('Debe escribir una clave para identificar al empleado');
			document.getElementById('cve').focus();
			return false;
		}
		if (document.registro.nombre.value == "") {
			alert ('Debe escribir el nombre del empleado');
			document.getElementById('nombre').focus();
			return false;
		}
		if (document.registro.puesto.value == "-1") {
			alert ('Debe seleccionar el puesto para en nuevo empleado');
			document.getElementById('puesto').focus();
			return false;
		}
		if (document.registro.direccion.value == "") {
			alert ('Debe escribir la direccion del empleado');
			document.getElementById('direccion').focus();
			return false;
		}
		if (document.registro.tel.value == "") {
			alert ('Debe escribir un telefono del empleado');
			document.getElementById('tel').focus();
			return false;
		}
		if (document.registro.sal.value == "") {
			alert ('Debe escribir el salario para el empleado');
			document.getElementById('sal').focus();
			return false;
		}
		if (isNaN(document.registro.sal.value)) {
			alert ('El salario debe ser un numero valido');
			document.getElementById('sal').focus();
			return false;
		}
		
		if (document.registro.entrada.value == "") {
			alert ('Debe escribir la hora de entrada');
			document.getElementById('entrada').focus();
			return false;
		}
		
		//guardo la hora de entrada en una variable
		entrada=document.registro.entrada.value;
		if (entrada.length>8) {
			alert('La hora debe contener 8 caracteres, en formato HH:MM:SS');
			document.getElementById('entrada').focus();
			return false;
		}
		if (entrada.length!=8){
			alert('Debe introducir HH:MM:SS, sus valores estan incompletos');
			document.getElementById('entrada').focus();
			return false;
		}
		a=entrada.charAt(0); //<=2
		b=entrada.charAt(1);//<4
		c=entrada.charAt(2); //:
		d=entrada.charAt(3); //<=5
		e=entrada.charAt(5); //:
		f=entrada.charAt(6); //<=5
		if ((a==2 && b>3) || (a>2)) {
			alert('El valor que introdujo en la Hora de entrada no corresponde, introduzca un digito entre 00 y 23');
			document.getElementById('entrada').focus();
			return false;
		}
		if (d>5) {
			alert('El valor que introdujo en los minutos no corresponde, introduzca un digito entre 00 y 59');
			document.getElementById('entrada').focus();
			return false;
		}
		if (f>5) {
			alert("El valor que introdujo en los segundos no corresponde");
			document.getElementById('entrada').focus();
			return false;
		}
		if (c!=':' || e!=':') {
			alert("Introduzca el caracter ':' para separar la hora, los minutos y los segundos");
			document.getElementById('entrada').focus();
			return false;
		}
		
		if (document.registro.alta.value == "") {
			alert ('Debe escribir la fecha de contratacion del empleado');
			document.getElementById('alta').focus();
			return false;
		}
		if (document.registro.status.value == "-1") {
			alert ('Debe seleccionar el status del empleado');
			document.getElementById('status').focus();
			return false;
		}
		if (document.registro.status.value == "2") {
			if(document.registro.baja.value == ""){
				alert ('Debe seleccionar la fecha de baja del empleado');
				document.getElementById('baja').focus();
				return false;
			}
		}
		if (document.registro.status.value == "3") {
			if(document.registro.baja.value == ""){
				alert ('Debe seleccionar la fecha de baja del empleado');
				document.getElementById('baja').focus();
				return false;
			}
		}
		 
		return true;
	}
	
</SCRIPT> 
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
            <li><a href="admin.php">Administraci&oacute;n</a></li>
            <li><a href="empleados.php" class="current">Empleados</a></li>
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
                
            <img src="../images/iconos/onebit_18.png" alt="image 3" />
            <a href="nuevo_empleado.php">Nuevo Empleado</a>
            
        </div>

         <div class="sb_box">
                
            <img src="../images/iconos/onebit_02.png" alt="image 1" />
            <a href="buscar_empleado.php">Buscar</a>
            
        </div>

    
    </div> <!-- end of templatemo_service_bar -->
    
    </div> <!-- end of templatemo_service_bar_wrapper -->
    
    <div id="templatemo_content_wrapper">
    <div id="templatemo_content">
    
    	<div class="col_w565_interior">
    
            <h2>Nuevo Empleado</h2>
            <div id="data_form">
            
				<?php
                    // HACEMOS UAN REVISION, SI SE ENVIARON DATOS DE UN EMPLEADO LOS REGISTRAMOS EN LA MISMA PAGINA
                    if (isset($_POST['registrar'])) {
                    
                            
                    $nombre = $_POST['nombre'];
					$cve = $_POST['cve'];
					$rfc = $_POST['rfc'];
                    $direccion = $_POST['direccion'];
                    $tel = $_POST['tel'];
                    $cel = $_POST['cel'];
					$comi = $_POST['comi'];
                    $sal = $_POST['sal'];
                    $alta = $_POST['alta'];
                    $imss = $_POST['imss'];
                    $status = $_POST['status'];
                    $puesto = $_POST['puesto'];
                    $entrada = $_POST['entrada'];
                    $baja = $_POST['baja'];
                    $observaciones = $_POST['observaciones'];
					if($comi!=""){
						$comi = $comi/100;
					}else{
						$comi = 0;
					}
                    
					
					$sql_verifica = "SELECT * FROM empleado WHERE clave ='$cve'";
					$consulta_verifica = $db->consulta($sql_verifica);
						if($db->num_rows($consulta_verifica)>0){
							echo"No es posible registrar al empleado con la clave <b>".$cve."</b> por que actualmente hay un empleado con esa clave, favor de verificar sus datos<br><br>";
							echo"<p align=\"right\"><a href=\"empleados.php\"><input class=\"boton\" type=\"button\" value=\"Regresar\"/></a></p>";
						}else{
							$consulta = $db->consulta("insert into empleado(nombre, clave, rfc, direccion, telefono, celular, salario_diario, comision, fecha_contratacion, imss, id_status, id_puesto, hora_entrada, fecha_baja, observaciones) values('".$nombre."','".$cve."','".$rfc."','".$direccion."','".$tel."','".$cel."','".$sal."','".$comi."','".$alta."','".$imss."','".$status."','".$puesto."','".$entrada."','".$baja."','".$observaciones."');");
							$_POST= array();
							$cerrar = $db->cerrar();
							$link = "Location: empleados.php";
							header($link);
							
						}
                    
                     
                    }
                ?>
                 <form method="post" enctype="multipart/form-data" action="nuevo_empleado.php" id="registro" name="registro" onSubmit="return validar()">
                 
                    <table align="center" border="0">
                        <tr><td>
                          <BR>
                          <fieldset>								  
                            <legend> <B>Datos de Registro </B></legend>
                            <table border="0">	
                            
                            <br /></td></tr>
                            <tr><td align="right"><span>*</span>Clave:</td>
                            <td> <input class="texto" type="text" id="cve" name="cve" size="10" /><br /></td></tr>
                            <tr><td align="right"><span>*</span>Nombre:</td>
                            <td> <input class="texto" type="text" id="nombre" name="nombre" size="40" /><br /></td></tr>
                            <tr><td align="right">R.F.C.:</td>
                            <td> <input class="texto" type="text" id="rfc" name="rfc" size="15" /><br /></td></tr>
                            <tr><td align="right"><span>*</span>Puesto:</td>
                            <td><select id="puesto" name="puesto">
                                <option value="-1">Seleccione</option>
                                <?php 
                                    $puestos = $db->consulta("select * from puesto;");
                                    while($rowp=$db->fetch_array($puestos)){
                                        $puesto = utf8_decode($rowp['puesto']);
                                        $id_puesto = $rowp['id_puesto'];
                                        echo "<option value='".$id_puesto."'>".$puesto."</option>";
                                    }
                                
                                ?>
                                </select>
                            </td></tr>
                            
                            <tr><td align="right"><span>*</span>Direcci&oacute;n:</td>
                            <td> <input class="texto" type="text" id="direccion" name="direccion" size="40" /><br /></td></tr>  
                            <tr><td align="right"><span>*</span>Tel&eacute;fono:</td>
                            <td> <input class="texto" type="text" id="tel" name="tel" size="30" /><br /></td></tr>	    
                            <tr><td align="right">Celular:</td>
                            <td> <input class="texto" type="text" id="cel" name="cel" size="30" /><br /></td></tr>
                            <tr><td align="right"><span>*</span>Salario Diario: $</td>
                            <td> <input class="texto" type="text" id="sal" name="sal" size="15" /><br /></td></tr>
                            <tr><td align="right">Comisi&oacute;n: </td>
                            <td> <input class="texto" type="text" id="comi" name="comi" size="10" />%<br /></td></tr>
                            <tr><td align="right"><span>*</span>Hora de Entrada:</td>
                            <td> <input class="texto" type="text" id="entrada" name="entrada" size="8" maxlength="8" /><br /></td></tr>
                            <tr><td align="right"><span>*</span>Fecha Contrataci&oacute;n:</td>
                            <td> <input class="texto" type="text" id="alta" name="alta" size="10" /><br /></td></tr>
                            <tr><td align="right">Clave IMSS:</td>
                            <td> <input class="texto" type="text" id="imss" name="imss" size="30" /><br /></td></tr>
                            <tr><td align="right"><span>*</span>Status:</td>
                            <td><select id="status" name="status" onchange="mostrar();">
                                <option value="-1">Seleccione</option>
                                <?php 
                                    $status_e = $db->consulta("select * from status_empleado;");
                                    while($rows=$db->fetch_array($status_e)){
                                        $status = $rows['status'];
                                        $id_status = $rows['id_status'];
                                        echo "<option value='".$id_status."'>".$status."</option>";
                                    }
                                
                                ?>
                                </select>
                            </td></tr>
                            <tr><td align="left" colspan="2"><div id="dbaja" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>*</span>Fecha de Baja: <input class="texto" type="text" id="baja" name="baja" size="10" /></div></td></tr>
                            <tr><td align="right" valign="top">Observaciones:</td>
                            <td><textarea cols="40" rows="2" class="texto" name="observaciones" id="observaciones"></textarea><br /></td></tr>
                            
                            
                            </table>
                          </fieldset>
                        </td></tr>
            
                        
                        <tr><td colspan = "2"><small><span>*</span>Campos obligatorios</small></td></tr>
            
                        <tr><td colspan="2"align="right"> 	   
                         <BR> <input class="submit_btn reset" type="submit" value="Registrar" name="registrar"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <input class="submit_btn reset" type="reset" value="Cancelar"/>
                        </td></tr>
                        
                        </table>  
                    </form>

        
        
            </div>
            
       	  <div class="cleaner_h20"></div>
            
            
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
ob_end_flush();
?>