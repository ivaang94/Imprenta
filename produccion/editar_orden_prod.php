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
	.ui-producto {
		position: relative;
		display: inline-block;
	}
	.ui-producto-toggle {
		position: absolute;
		top: 0;
		bottom: 0;
		margin-left: -1px;
		padding: 0;
		/* adjust styles for IE 6/7 */
		*height: 1.7em;
		*top: 0.1em;
	}
	.ui-producto-input {
		margin: 0;
		padding: 0.3em;
		width:500px;
	}
	</style>
	<script>
	(function( $ ) {
		$.widget( "ui.producto", {
			_create: function() {
				var input,
					self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "",
					wrapper = this.wrapper = $( "<span>" )
						.addClass( "ui-producto" )
						.insertAfter( select );

				input = $( "<input>" )
					.appendTo( wrapper )
					.val( value )
					.addClass( "ui-state-default ui-producto-input" )
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
					.addClass( "ui-corner-right ui-producto-toggle" )
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
		$( "#producto" ).producto();
		$( "#toggle" ).click(function() {
			$( "#producto" ).toggle();
		});
	});
	</script>


 <SCRIPT LANGUAGE="JavaScript">
	<!-- Funcion que valida que se hayan escrito los campos obligatorios-->
	function validarProd() {
			if (document.regProd.producto.value == "-1") {
				alert ('Debe seleccionar un producto');
				document.getElementById('producto').focus();
				return false;
			}
			if (document.regProd.cant.value == "") {
				alert ('Debe escribir la cantidad');
				document.getElementById('cant').focus();
				return false;
			}
			return true;
	}
</SCRIPT> 

<!-- SI ENVIARON LOS DATOS DEL FORMULARIO DE PRODUCTO LOS VOY A GUARDAR  -->
 <?php
if (isset($_POST['editar'])) {
	$cve_orden = $_POST['numero'];
	$cve_det = $_POST['key'];
	$cant = $_POST['cant'];
	$cve_prod = $_POST['producto'];
	$cant = $_POST['cant'];
	$stock = $_POST['stock'];
	$block = $_POST['block'];
	$cortado = $_POST['cortado'];
	$fini = $_POST['fini'];
	$ffin = $_POST['ffin'];
	
	//recibi las variables y ahora hare la consulta con el update
	$query = "UPDATE detalle_orden_produccion SET id_producto='$cve_prod', cantidad='$cant', stock='$stock', block='$block', cortado='$cortado', folio_inicio='$fini', folio_final='$ffin' WHERE id_detalle ='$cve_det';";
	echo "la consulta es ".$query."<br>";
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
            <li><a href="produccion.php">Producci&oacute;n</a></li>
            <li><a href="ordenes_produccion.php" class="current">Ordenes</a></li>
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
                
            <img src="../images/iconos/onebit_59.png" alt="image 3" />
            <a href="nueva_orden_produccion.php">Nueva Orden</a>
            
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
    
            <h2>Editar Orden - Producto</h2>
            <?php
				$db = new MySQL();
				$orden = $_GET['numero'];
				$detalle = $_GET['key'];
				
				//voy a consultar los datos del registro
				$consulta_reg = $db->consulta("SELECT *  FROM `detalle_orden_produccion` WHERE `id_detalle` = '".$detalle."';");
				while ($row2 = $db->fetch_array($consulta_reg)){
					$id_producto = $row2['id_producto'];
					$cantidad = $row2['cantidad'];
					$stock = $row2['stock'];
					$block = $row2['block'];
					$cortado = $row2['cortado'];
					$inicial = $row2['folio_inicio'];
					$final = $row2['folio_final'];
					
				}
				
				?>
				<form method="post" action="editar_orden_prod.php" name="regProd" onsubmit="return validarProd()">
                            <input type="hidden" name="numero" id="numero" value="<?php echo $orden;?>">
                            <input type="hidden" name="key" id="key" value="<?php echo $detalle;?>">	
                            	<table border="0" width="700px" align="center">	
                                    <tr>
                                    	<td align="right"><b>Producto: </b></td>
                                    	<td align="left" valign="middle" colspan="9">
                                        <select id="producto" name="producto">
                                            <option value="-1">Selecciona Uno...</option>
                                            <?php 
												$lista_prod = $db->consulta("SELECT * FROM `producto` ORDER BY id_producto ASC;");
													while ($row3 = $db->fetch_array($lista_prod))
													{
													  $id_prod = $row3['id_producto'];
													  $nombre = $row3['nombre'];
													  $nombre = utf8_decode($nombre);
													  $cve_prod = $row3['clave'];
													  $dato = $cve_prod." - ".$nombre;
													  
													  	if($id_prod==$id_producto){
															  echo "<option value=\"".$id_prod."\"selected>".$dato."</option>";
														}else{
															 echo "<option value=\"".$id_prod."\">".$dato."</option>";
														}
													
													
													}
											?>
                                        </select></td>
                                        </tr>
                                        
                                        <tr>
                                        <td align="right"><b>Cantidad: </b></td>
                                        <td><input type="text" class="texto" id="cant" name="cant" size="10" value="<?php echo $cantidad;?>"</td>
                                        <td width="25%">&nbsp;</td>
                                        <td align="right"><b>Stock: </b></td>
                                        <td><input type="text" class="texto" id="stock" name="stock" size="10" value="<?php echo $stock;?>" /></td>
                                        </tr>
                                        
                                        <tr>
                                        <td align="right"><b>Cantidad por rollo, paquete o block: </b></td>
                                        <td><input type="text" class="texto" id="block" name="block" size="10" value="<?php echo $block;?>"/></td>
                                        <td width="25%">&nbsp;</td>
                                        <td align="right"><b>Cortado: </b></td>
                                        <td><input type="text" class="texto" id="cortado" name="cortado" size="10" value="<?php echo $cortado;?>" /></td>
                                        </tr>
                                        
                                        <tr>
                                        <td align="right"><b>Folio inicial: </b></td>
                                        <td><input type="text" class="texto" id="fini" name="fini" size="10" value="<?php echo $inicial;?>" /></td>
                                        <td width="25%">&nbsp;</td>
                                        <td align="right"><b>Folio final: </b></td>
                                        <td><input type="text" class="texto" id="ffin" name="ffin" size="10" value="<?php echo $final;?>"/></td>
                                        </tr>
                                        
                                        
                                        <tr>
                                        <td colspan="5" align="right"><input class="submit_btn" type="submit" name="editar" id="editar" value="Actualizar"/></td>
                                    </tr>
                                </table>
                            </form>
				
	
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