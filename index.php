
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title>Inventario</title>
	<style>
		h1 { text-align: left; margin-top:5px; border-bottom: 1px solid black; display: block; font-size: 18px; }
		body { background: #EEEEEE; font-family: verdana; font-size: 12px; }
		input,select { width: 95%; }
		table { padding: 3px; background: white; margin: auto; }
		table th { text-align: center; padding-left: 20px; }
		table table td { border-bottom: 1px solid #D3D3D3;}
		input,select,textarea { border: 1px solid #D3D3D3; }
		input:hover { background: #F9F7ED; }
		select:hover { background: #F9F7ED; }
		textarea:hover { background: #F9F7ED; }
		input.disabled { background: #EEEEEE; text-align: right; }
		#tdDetalle { border: 1px solid #D3D3D3; }
	</style>
	<script type="text/javascript" src="jquery.js"></script>
	<script>

		$(document).ready(function(){
		
			$("#btnCompra").click(function(){	
					
				$.post('ajax.php',{
					action: 'compra',
				},function(r){
					$("#cboCategoria option").remove();
					$("#cboCategoria").append('<option value="0">--------------</option>');
					$.each(r,function(i,v){
						$("#cboCategoria").append('<option value="' + v.idCategoria + '">' + v.categoria + '</option>');
					})
				},'json')
			})
			
			$("#btnVenta").click(function(){	
					
				$.post('ajax.php',{
					action: 'venta',
				},function(r){
					$("#cboCategoria option").remove();
					$("#cboCategoria").append('<option value="0">--------------</option>');
					$.each(r,function(i,v){
						$("#cboCategoria").append('<option value="' + v.idCategoria + '">' + v.categoria + '</option>');
					})
				},'json')
			})
			
			$("#btnServicio").click(function(){	
					
				$.post('ajax.php',{
					action: 'servicio',
				},function(r){
					$("#cboCategoria option").remove();
					$("#cboCategoria").append('<option value="0">--------------</option>');
					$.each(r,function(i,v){
						$("#cboCategoria").append('<option value="' + v.idCategoria + '">' + v.categoria + '</option>');
					})
				},'json')
			})
			
			$("#cboCategoria").change(function(){	
				$.post('ajax.php',{
					idCategoria: $(this).val()
				},function(r){
					$("#cboDetalle option").remove();
					$("#cboDetalle").append('<option value="0">--------------</option>');
					$.each(r,function(i,v){
						$("#cboDetalle").append('<option value="' + v.idDetalle + '-' + v.precio + '">' + v.detalle + '</option>');
					})
				},'json')
			})
			
			$("#cboDetalle").change(function(){
				var value = $(this).val().split('-');
				$("#txtPUnitario").val(parseFloat(value[1]).toFixed(2));
			})
			
								
			$("#frmInventario").submit(function(){
				
				if(!parseInt($("#txtCantidad").val())){
					alert('La cantidad debe ser del tipo numérico');
					$("#txtCantidad").focus();
					return false;
				}
				
				if($("#tdDetalle input").size()==0){
					alert('No hay ningun registro');
					return false;
				}
					
			})

			$("#btnAgregar").click(function(){
				var value = "";
				var cantidad = 0;
				
				if(!parseInt($("#txtCantidad").val())){
					alert('La cantidad debe ser del tipo numérico');
					$("#txtCantidad").focus();
					return false;
				}
				
				var cantidad = $("#txtCantidad").val();
				var precio = $("#txtPUnitario").val();
				var sub = precio*cantidad;
				var producto = 	'<tr><td class="prodAgregado">[<a href="#">X</a>] ' + $("#cboProducto option:selected").text() + '</td><td align="center">' + cantidad + '<input type="hidden" name="detalle[]" value="' + $("#cboProducto").val() + '-' + cantidad + '-' + precio + '" /></td><td align="right">' + precio + '</td><td class="tdSubTotal" align="right">' + sub.toFixed(2) + '</td></tr>';
				$("#tdDetalle table").append(producto);
				sumarTot();
			})
			
			$("#tdDetalle td a").live('click',function(){
				if(confirm('¿Esta seguro de quitar este registro?')){
					$(this).parent().parent().fadeOut('fast',function(){
						$(this).remove();
					});
				}
				sumarTot();
				return false;
			})
			
			
		});
		
		function sumarTot(){
			var total = 0;		
			$(".tdSubTotal").each(function(){
				total += parseFloat($(this).text());
			})
			$("#txtTotal").val(parseFloat(total).toFixed(2));
		}	
	</script>
</head>
<body>
	<form id="frmInventario" action="ajax.php" method="post">
	<table style="width: 30%">
		<tr>
			<td>
				<input type="button" id="btnCompra" class="bntAccion" name="btnCompra" value="COMPRAS"/>
			</td>
			<td>
				<input type="button" id="btnVenta" class="bntAccion" name="btnVenta" value="VENTAS"/>
			</td>
			<td>
				<input type="button" id="btnServicio" class="bntAccion" name="btnServicio" value="SERVICIOS"/>
			</td>
		</tr>
	</table><br/>
	<table style="width: 50%">
		<tr>
			<th width="150">
				Categoria
			</th>
			<th width="200">
				Detalle
			</th>
			<th width="100">
				Precio Unitario
			</th>
			<th width="100">
				Cantidad 
			</th>
			<th width="150"></th>
		</tr>
		<tr>
			<td>
				<select id="cboCategoria" name="cboCategoria">
					
				</select>
			</td>
			<td>
				<select id="cboDetalle" name="cboDetalle">
				</select>
			</td>
			<td>
				<input id="txtPUnitario" type="text" name="txtPUnitario" disabled="disabled" />
			</td>
			<td>
				<input id="txtCantidad" type="text" name="txtCantidad" />
			</td>
			<td>
				<button id="btnAgregar" type="button">+</button>
			</td>
		</tr>
		<tr>
			<td id="tdDetalle" colspan="5">
				<div style="height: 145px; overflow: auto;">
				<table style="width: 100%;">
					<tr>
						<th>Detalle</th>
						<th>Cantidad</th>
						<th>Precio Unitario</th>
						<th>Sub Total</th>
					</tr>
					
				</table>
				</div>
			</td>
		</tr>
	
		<tr>
			<td colspan="4" align="right">
				<i>TOTAL</i>
			</td>
			<td colspan="1">
				<input id="txtTotal" type="text" name="txtTotal" class="disabled" readonly="readonly" />
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<input type="hidden" name="action" value="facturar" />
				<button id="btnFactura" type="submit">Registrar</button>
			</td>
		</tr>
	</table>
	</form>
</body>
</html>