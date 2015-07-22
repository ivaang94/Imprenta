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

<script src="../js/jquery-1.8.0.js"></script>
<script src="../js/ui/jquery.ui.core.js"></script>
<script src="../js/ui/jquery.ui.widget.js"></script>
<script src="../js/ui/jquery.ui.button.js"></script>
<script src="../js/ui/jquery.ui.position.js"></script>
<script src="../js/ui/jquery.ui.autocomplete.js"></script>
<script src="../js/ui/jquery.ui.datepicker.js"></script>


	<style>
	.ui-proveedor {
		position: relative;
		display: inline-block;
	}
	.ui-proveedor-toggle {
		position: absolute;
		top: 0;
		bottom: 0;
		margin-left: -1px;
		padding: 0;
		/* adjust styles for IE 6/7 */
		*height: 1.7em;
		*top: 0.1em;
	}
	.ui-proveedor-input {
		margin: 0;
		padding: 0.3em;
		width:500px;
	}
	</style>
	<script>
	(function( $ ) {
		$.widget( "ui.proveedor", {
			_create: function() {
				var input,
					self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "",
					wrapper = this.wrapper = $( "<span>" )
						.addClass( "ui-proveedor" )
						.insertAfter( select );

				input = $( "<input>" )
					.appendTo( wrapper )
					.val( value )
					.addClass( "ui-state-default ui-proveedor-input" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									input.data( "autocomplete" ).term = "";
									return false;
								}
							}
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.appendTo( wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-proveedor-toggle" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return;
						}

						// work around a bug (likely same cause as #5265)
						$( this ).blur();

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});
			},

			destroy: function() {
				this.wrapper.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

	$(function() {
		$( "#proveedor" ).proveedor();
		$( "#toggle" ).click(function() {
			$( "#proveedor" ).toggle();
		});
	});
	</script>

<script type="text/javascript">
<!-- muestra y oculta campos en el formulario segun el select
function mostrar(){
//Si la opcion con id Conocido_1 (dentro del documento > formulario con name fcontacto >     y a la vez dentro del array de Conocido) esta activada
if (document.registro.tipo_pago.value == "6") {
	//muestra la lista del tipo de nota de credito
	document.getElementById('motivo').style.display='block';
	document.getElementById('motivo2').style.display='block';
	document.getElementById('motivo2').focus();
} else {
		document.getElementById('motivo').style.display='none';
		document.getElementById('motivo2').style.display='none';
		document.registro.motivo_nota.value = "-1";
	}
}
-->
</script>

<script>
//muestra el calendario
$(function() {
	$( "#fecha" ).datepicker({
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
            <li><a href="pagos.php" class="current">Pagos</a></li>
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
                
            <img src="../images/iconos/onebit_55.png" alt="image 3" />
            <a href="nuevo_pago.php">Registro de pago</a>
            
        </div>

         <div class="sb_box">
                
            <img src="../images/iconos/onebit_02.png" alt="image 1" />
            <a href="pagos.php">Buscar</a>
            
        </div>
        
        
    </div> <!-- end of templatemo_service_bar -->
    
    </div> <!-- end of templatemo_service_bar_wrapper -->
    
    <div id="templatemo_content_wrapper">
    <div id="templatemo_content">
    
    	<div class="col_w565_interior">
    
            <h2>Editar Pago a Proveedor</h2>
            <div id="data_form">
            
            <SCRIPT LANGUAGE="JavaScript">
			<!-- Funcion que valida que se hayan escrito los campos obligatorios-->

				function validar() {
					if (document.registro.proveedor.value == "-1") {
						alert ('Debe seleccionar un proveedor');
						document.getElementById('proveedor').focus();
						return false;
					}
					if (document.registro.fecha.value == "") {
						alert ('Debe eleccionar una fecha para el pago');
						document.getElementById('fecha').focus();
						return false;
					}
					if (document.registro.tipo_pago.value == "-1") {
						alert ('Debe seleccionar el tipo de pago que esta registrando');
						document.getElementById('tipo_pago').focus();
						return false;
					}
					if (document.registro.moneda.value == "-1") {
						alert ('Debe seleccionar una moneda');
						document.getElementById('moneda').focus();
						return false;
					}
					if (document.registro.monto.value == "") {
						alert ('Debe escribir el monto de la operacion a registrar');
						document.getElementById('monto').focus();
						return false;
					}
					return true;
					
				}
				
			</SCRIPT> 
              
            <?php
              $db = new MySQL();
              $clave = $_GET['numero'];
			  $pago = $db->consulta("SELECT * FROM `pago_proveedor` WHERE id_pago='".$clave."'");
              while ($row = $db->fetch_array($pago))
			  {
				  $id_proveedor = $row['id_proveedor'];
				  
				  $id_tipo_pago = $row['id_tipo_pago'];
				  
				  $referencia = $row['referencia'];
				  $id_moneda = $row['id_moneda'];
				  $tipo_cambio = $row['tipo_cambio'];
				  $monto = $row['monto'];
				  $observaciones = $row['observaciones'];
				  $fecha = $row['fecha'];
				  
				}
				
					
			?>
            
            <form method="post" enctype="multipart/form-data" action="registro_pago_proveedor.php" name="registro" onSubmit="return validar()">
							<input type="hidden" name="operacion" id="operacion" value="editar">
                            <input type="hidden" name="clave" id="clave" value="<?php echo $clave;?>">
                            
							<table align="center" width="550px" border="0px">
								
								<tr align="center"><td>
								  <BR>
                                  <fieldset>								  
								    <legend> <B>Datos de Registro </B></legend>
								    <table border="0" width="500px">	
                                    
                                    <tr>
                                    <td align="right"><span>*</span>Proveedor: </td>
                                    	<td align="left" valign="middle">
                                        <select id="proveedor" name="proveedor">
                                            <option value="-1">Selecciona Uno...</option>
                                            <?php 
												$lista_tam = $db->consulta("SELECT `id_proveedor`,`nombre` FROM `proveedor`;");
													while ($row6 = $db->fetch_array($lista_tam))
													{
													  $id_proveedor1 = $row6['id_proveedor'];
													  $cte = utf8_decode($row6['nombre']);
														 if($id_proveedor==$id_proveedor1){
																  echo "<option value=\"".$id_proveedor1."\"selected>".$cte."</option>";
															}else{
																   echo "<option value=\"".$id_proveedor1."\">".$cte."</option>";
															}
													  
													}
											?>
                                        </select>
                                    </td>
                                    </tr>

								    <tr><td align="right"><span>*</span>Fecha:</td>
								    <td> <input class="texto" type="text" id="fecha" name="fecha" size="20" value="<?php echo $fecha;?>" /><br /></td></tr>
                                    
                                    <tr>
                                    <td align="right"><span>*</span>Tipo de pago: </td>
                                    	<td align="left" valign="middle">
                                        <select id="tipo_pago" name="tipo_pago" onchange="mostrar();">
                                            <option value="-1">Selecciona Uno...</option>
                                            <?php 
												$lista_tipo = $db->consulta("SELECT * FROM `tipo_pago_cliente`;");
													while ($row6 = $db->fetch_array($lista_tipo))
													{
													  $id_tp = $row6['id_tipo_pago'];
													  $tipo = $row6['tipo_pago'];
													  
														if($id_tipo_pago==$id_tp){
															  echo "<option value=\"".$id_tp."\"selected>".$tipo."</option>";
														}else{
															if($id_tp!=6){
																 echo "<option value=\"".$id_tp."\">".$tipo."</option>";
															}
														}
													}
											?>
                                        </select>
                                    </td>
                                    </tr>
                                    
                                    <tr>
                                    <td align="right">Referencia: </td>
                                    <td align="left" valign="middle"><input class="texto" type="text" id="ref" name="ref" size="20" value="<?php echo $referencia;?>" /><br />
                                   </td>
                                    </tr>
                                    
                                     <tr>
                                    <td align="right"><span>*</span>Moneda: </td>
                                    	<td align="left" valign="middle">
                                        <select id="moneda" name="moneda">
                                            <option value="-1">Selecciona Uno...</option>
                                            <?php 
												$lista_mon = $db->consulta("SELECT * FROM `moneda`;");
													while ($row6 = $db->fetch_array($lista_mon))
													{
													  $id_mon = $row6['id_moneda'];
													  $mon = $row6['moneda'];
													  $tipo_cambio = number_format($row6['precio_compra'],2);
													  
													  if($id_mon==$id_moneda){
															  echo "<option value=\"".$id_mon."\"selected>".$mon." - $".$tipo_cambio."</option>";
														}else{
															   echo "<option value=\"".$id_mon."\">".$mon." - $".$tipo_cambio."</option>";
														}
													  
													  
													}
											?>
                                        </select>
                                    </td>
                                    </tr>
                                    
                                     <tr>
                                    <td align="right"><span>*</span> Monto: $</td>
                                    <td align="left" valign="middle"><input class="texto" type="text" id="monto" name="monto" size="20" value="<?php echo $monto;?>" /><br />
                                   </td>
                                    </tr>
                                    
                                    <tr>
                                    <td align="right" valign="top">Observaciones: </td>
                                    <td align="left" valign="middle"> <textarea id="observaciones" name="observaciones" rows="0" cols="0"><?php echo $observaciones;?></textarea><br />
                                   </td>
                                    </tr>
                                    
                                    
                                    </table>
								  </fieldset>
								</td></tr>

								
								<tr><td colspan = "2"><small><span>*</span>Campos obligatorios</small></td></tr>

								<tr><td colspan="2"align="right"> 	   
								 <BR> <input class="submit_btn reset" type="submit" value="Registrar"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
?>