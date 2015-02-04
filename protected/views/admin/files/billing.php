<?php
    putenv("TMPDIR=/assets/tmp");

    $excel = new PHPExcel();
    $excelWriter = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
    
    
    $excel->getActiveSheet()->setCellValueByColumnAndRow( 1, 1, 'Город');
    $excel->getActiveSheet()->setCellValueByColumnAndRow( 2, 1, 'Контактное лицо');
    $excel->getActiveSheet()->setCellValueByColumnAndRow( 3, 1, 'Телефон');
    $excel->getActiveSheet()->setCellValueByColumnAndRow( 4, 1, 'Email');
    $excel->getActiveSheet()->setCellValueByColumnAndRow( 5, 1, 'Дата регистрации');
    $excel->getActiveSheet()->setCellValueByColumnAndRow( 6, 1, 'Дата последнего визита');
    $excel->getActiveSheet()->setCellValueByColumnAndRow( 7, 1, 'Количество объявлений');
    $excel->getActiveSheet()->setCellValueByColumnAndRow( 8, 1, 'Статус');
    $excel->getActiveSheet()->setCellValueByColumnAndRow( 9, 1, 'Коментарий администратора');
    
    
    foreach ( $arguments['result'] as $rowNum => $data ){
        
        $i = 0;
        foreach ( $data as $name => $value ){
                $excel->getActiveSheet()->setCellValueByColumnAndRow( $i, $rowNum + 2, '' . $value );
                ++ $i;
        }
    }
    header("Content-Type: application/vnd.ms-excel\r\n");
    header("Content-Disposition: attachment; filename=\"billing_".date('Y-m-d_h:i:s').".xls\"\r\n");
    header("Cache-Control: max-age=0\r\n");
    $excelWriter->save('php://output');
    

?>