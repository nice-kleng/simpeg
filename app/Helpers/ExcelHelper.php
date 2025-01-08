<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

if (!function_exists('processExcel')) {
    function processExcel($templatePath, $data, $outputName = 'tepmplate.xlsx')
    {
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Fill cells
        foreach ($data as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Generate output
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $outputName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
