<?php
header('Content-type: application/json');
	switch($_REQUEST['action']){
		case 'compra':
		case 'venta':
				echo json_encode(
				array(
						array(
							'idCategoria' => 1,
							'categoria' => 'Lapicero'
						),
						array(
							'idCategoria' => 2,
							'categoria' => 'Cuaderno'
						)
					)
				);
	
			break;
		case 'servicio':
				echo json_encode(
				array(
						array(
							'idCategoria' => 3,
							'categoria' => 'Impresion'
						)
					)
				);
	
			break;
	}
	
	switch($_REQUEST['idCategoria']){
		case '1':
				echo json_encode(
				array(
						array(
							'idDetalle' => 1,
							'detalle' => 'Pilot',
							'precio' => 1.00
						),
						array(
							'idDetalle' => 2,
							'detalle' => 'Faber',
							'precio' => 0.50
						)
					)
				);
	
			break;
			case '2':
				echo json_encode(
				array(
						array(
							'idDetalle' => 3,
							'detalle' => 'Loro',
							'precio' => 2.50
						),
						array(
							'idDetalle' => 4,
							'detalle' => 'Minerva',
							'precio' => 2.00
						)
					)
				);
	
			break;
			case '3':
				echo json_encode(
				array(
						array(
							'idDetalle' => 5,
							'detalle' => 'Blanco/Negro',
							'precio' => 0.10
						),
						array(
							'idDetalle' => 6,
							'detalle' => 'Color',
							'precio' => 0.20
						)
					)
				);
	
			break;
	}
	
?>