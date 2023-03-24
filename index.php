<?php
// Incluir la biblioteca PHPOffice
require_once 'vendor/autoload.php';
require_once 'conexion.php';
require_once 'consultas.php';

// Llamar a la clase Spreadsheet
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

// Eliminar la hoja vacía que se genera por defecto
$spreadsheet->removeSheetByIndex(0);


// Agregar hoja principal
$worksheet1 = $spreadsheet->createSheet();
$worksheet1->setTitle('Consulta principal');

/***************************************************************/
// Llamamos a la consulta principal
$stmt = consultaPrincipal($pdo);

// Agregar encabezados de columna
$num_columnas = $stmt->columnCount();
for ($i = 0; $i < $num_columnas; $i++) :
    $columna = chr(65 + $i); // Convertir número de columna a letra
    $nombre_columna = $stmt->getColumnMeta($i)['name']; // Recogemos el nombre de la columna
    $worksheet1->setCellValue($columna . '1', $nombre_columna);
endfor;

// Agregar los datos de la consulta a las celdas correspondientes
$i = 2; // Fila inicial de datos
while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) :
    for ($j = 0; $j < $num_columnas; $j++) :
        $columna = chr(65 + $j); // Convertir número de columna a letra
        $valor = $fila[$stmt->getColumnMeta($j)['name']]; // Obtener el valor de la columna actual
        $worksheet1->setCellValue($columna . $i, $valor);
    endfor;
    $i++;
endwhile;
/***************************************************************/

/***************************************************************/
// Llamamos a la consulta secundaria
$stmt = consultaSecundaria($pdo, 20000000);;

// Agregar hoja sencundaria
$worksheet2 = $spreadsheet->createSheet();
$worksheet2->setTitle('Consulta secundaria');

// Agregar encabezados de columna
$worksheet2->setCellValue('A1', 'País');
$worksheet2->setCellValue('B1', 'Población');

// Agregar los datos de la consulta a las celdas correspondientes
$i = 2; // Fila inicial de datos
while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) :
    $worksheet2->setCellValue('A' . $i, $fila['Name']);
    $worksheet2->setCellValue('B' . $i, $fila['Population']);
    $i++;
endwhile;
/***************************************************************/

/***************************************************************/
// Llamamos a la consulta terciaria
$stmt = consultaterciaria($pdo, "Republic");

// Agregar hoja sencundaria
$worksheet3 = $spreadsheet->createSheet();
$worksheet3->setTitle('Consulta terciaria');

// Agregar encabezados de columna
$worksheet3->setCellValue('A1', 'País');
$worksheet3->setCellValue('B1', 'Tipo de gobierno');

// Agregar los datos de la consulta a las celdas correspondientes
$i = 2; // Fila inicial de datos
while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) :
    $worksheet3->setCellValue('A' . $i, $fila['Name']);
    $worksheet3->setCellValue('B' . $i, $fila['GovernmentForm']);
    $i++;
endwhile;
/***************************************************************/

// Configurar excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="datos.xlsx"');
header('Cache-Control: max-age=0');

// Crear el fichero
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save('php://output');

// Cerrar la conexión 
mysqli_close($conexion);
?>
