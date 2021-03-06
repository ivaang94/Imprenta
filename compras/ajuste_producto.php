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
<link rel="shortcut icon" href="../images/favicon.ico">
<title>Sistema de ERP</title>
<link href="../styles/templatemo_style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../styles/ui-lightness/jquery.ui.all.css">


<script src="../js/jquery-1.8.0.js"></script>
<script src="../js/ui/jquery.ui.core.js"></script>
<script src="../js/ui/jquery.ui.widget.js"></script>
<script src="../js/ui/jquery.ui.button.js"></script>
<script src="../js/ui/jquery.ui.position.js"></script>
<script src="../js/ui/jquery.ui.autocomplete.js"></script>
<script src="../js/ui/jquery.ui.datepicker.js"></script>

	<style>
	.ui-insumo {
		position: relative;
		display: inline-block;
	}
	.ui-insumo-toggle {
		position: absolute;
		top: 0;
		bottom: 0;
		margin-left: -1px;
		padding: 0;
		/* adjust styles for IE 6/7 */
		*height: 1.7em;
		*top: 0.1em;
	}
	.ui-insumo-input {
		margin: 0;
		padding: 0.3em;
		width:500px;
	}
	</style>
	<script>
	(function( $ ) {
		$.widget( "ui.insumo", {
			_create: function() {
				var input,
					self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "",
					wrapper = this.wrapper = $( "<span>" )
						.addClass( "ui-insumo" )
						.insertAfter( select );

				input = $( "<input>" )
					.appendTo( wrapper )
					.val( value )
					.addClass( "ui-state-default ui-insumo-input" )
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
					.addClass( "ui-corner-right ui-insumo-toggle" )
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
		$( "#insumo" ).insumo();
		$( "#toggle" ).click(function() {
			$( "#insumo" ).toggle();
		});
	});
	</script>



<!--VALIDAR EL FORMULARIO DE PRODUCTO -->
 <SCRIPT LANGUAGE="JavaScript">
	<!-- Funcion que valida que se hayan escrito los campos obligatorios-->
	function validarIns() {
			if (document.regIns.insumo.value == "-1") {
				alert ('Debe seleccionar un insumo');
				document.getElementById('insumo').focus();
				return false;
			}
			if (document.regIns.cant.value == "") {
				alert ('Debe escribir la cantidad');
				document.getElementById('cant').focus();
				return false;
			}
			if (document.regIns.unitario.value == "") {
				alert ('Debe escribir el precio unitario del insumo');
				document.getElementById('unitario').focus();
				return false;
			}
			if (document.regIns.tiva.value == "-1") {
				alert ('Debe seleccionar la clase de iva que se va a calcular');
				document.getElementById('tiva').focus();
				return false;
			}
			return true;
	}
</SCRIPT> 

<!-- SI ENVIARON LOS DATOS DEL FORMULARIO DE INSUMO LOS VOY A GUARDAR  -->
 <?php
if (isset($_GET['guardar'])) {
	$cve_orden = $_GET['numero'];
	$cve_det = $_GET['key'];
	$cant = $_GET['cant'];
	$causa = $_GET['causa'];
	
	//recibi las variables y ahora hare la consulta con el update
	$query = "UPDATE `imprenta`.`detalle_orden_produccion` SET `ajuste` = '$cant', `causa_ajuste` = '$causa' WHERE `id_detalle` =$cve_det;";
	


	$consulta = $db->consulta($query);
	$link = "Location: ficha_orden_prod.php?numero=$cve_orden";
	header($link);
	 
}
?>

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
            <li><a href="compras.php">Compras</a></li>
            <li><a href="ordenes_compra.php" class="current">Ordenes</a></li>
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
                
            <img src="../images/iconos/onebit_77.png" alt="image 3" />
            <a href="nueva_orden.php">Nueva Orden</a>
            
        </div>

         <div class="sb_box">
                
            <img src="../images/iconos/onebit_02.png" alt="image 1" />
            <a href="#">Buscar</a>
            
        </div>
        
        
        
    
    </div> <!-- end of templatemo_service_bar -->
    
    </div> <!-- end of templatemo_service_bar_wrapper -->
    
    <div id="templatemo_content_wrapper">
    <div id="templatemo_content">
    
    	<div class="col_w565_interior">
    
            <h2>Editar Orden - Insumo</h2>
            <?php
				$db = new MySQL();
				$orden = $_GET['numero'];
				$detalle = $_GET['key'];
				
				//voy a consultar los datos del registro
				$consulta_reg = $db->consulta("SELECT *  FROM `detalle_orden_produccion` WHERE `id_detalle` = '".$detalle."';");
				while ($row2 = $db->fetch_array($consulta_reg)){
					$id_insumo = $row2['id_insumo'];
					$cantidad = $row2['cantidad'];
					//consultare el nombre del insumo
				  	$consulta_ins = $db->consulta("SELECT *  FROM `insumo` WHERE `id_insumo` = '".$id_insumo."';");
				   	while ($row2 = $db->fetch_array($consulta_ins)){
					   $nom_insumo = $row2['nombre'];
					}
					
				}
				
				//DATOS DEL ajuste al detalle de la orden
				$cons_ajuste = $db->consulta("SELECT `ajuste` FROM `detalle_orden_produccion` WHERE `id_detalle` =$detalle");
				while ($row2 = $db->fetch_array($cons_ajuste))
				{
					$ajuste = $row2['ajuste'];
				}
				
				
				//consultare las entradas que hay en inventario del insumo y la orden
				//$texto_rec = "SELECT sum( `unidades` ) as suma FROM `insumo_inventario` WHERE `id_orden` =$orden AND `id_insumo` =$id_insumo";
				//$consulta_rec = $db->consulta($texto_rec);
				//while ($row3 = $db->fetch_array($consulta_rec)){
				//	 $suma_recibido = $row3['suma'];
				//}
				//$suma_cantidades = $suma_recibido+$ajuste;
				//$pendiente = $cantidad - $suma_cantidades;

				 $query="SELECT * from producto_almacen where id_orden_produccion=".$_GET['numero'].";";
			$query=$db->consulta($query);
			$suma_cantidades=0;
			while($row3=$db->fetch_array($query)){
				$aux=$row3['cantidad'];
				$suma_cantidades=$suma_cantidades+$aux;
			}
		//echo $suma_cantidades;
		//$suma_cantidades = $suma_recibido+$ajuste;
		$pendiente = $cantidad - $suma_cantidades;
				
				?>
                <div id="data_form">
                  <fieldset>								  
                    <legend> <B>Datos</B></legend>
				<form method="get" action="ajuste_producto.php" name="regIns" onsubmit="return validarIns()">
                            <input type="hidden" name="numero" id="numero" value="<?php echo $orden;?>">
                            <input type="hidden" name="key" id="key" value="<?php echo $detalle;?>">	
                            <input type="hidden" name="guardar">
                            	
                                
                                <table border="0" width="100%">	
                                    <tr>
                                    	<td align="right"><b>Insumo: </b></td>
                                    	<td align="left	" valign="middle" colspan="2">
                                        <?php echo $nom_insumo; ?>
                                        </td>
                                        </tr>
                                        
                                        <tr>
                                        <td align="right"><b>Cantidad a ajustar: </b></td>
                                    	<td colspan="2"><input class="texto" type="text" id="cant" name="cant" size="5" value="<?php echo $pendiente;?>" /><br /></td>
                                        </tr>
                                        
                                         <tr>
                                        <td align="right"><b>Causa ajuste: </b></td>
                                    	<td colspan="2"><input class="texto" type="text" id="causa" name="causa" size="35"/><br /></td>
                                        </tr>
                                        
                                        <tr>
                                        <td>&nbsp;</td>
                                        <td align="right"><input class="submit_btn reset" type="submit" name="guardar" id="guardar" value="Guardar"/></td>
                                        <td align="right"><a href="ficha_orden.php?numero=<?php echo $orden;?>"><input class="submit_btn reset" type="button" name="regresar" id="editar" value="Regresar"/></a></td>
                                        </tr>
                                        
                                </table>
                                
                                
                            </form>
                            </fieldset>
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