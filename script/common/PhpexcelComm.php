<?php
require_once "./common/PHPExcel/PHPExcel.php";
class PhpExcelComm {

    private $instance;
    private $resolveClass;
    private $sheetName;
    private $fileName;
    private $header;


    public function __construct(){
        /*
         * 效果不明显，弃用
         * $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
         * PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
         */
        ini_set('memory_limit', '512M');
        $this->instance = new PHPExcel();
        $this->instance->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->instance->getDefaultStyle()->getFont()->setName('微软雅黑')->setSize(12);
        $this->setResolveClass();
        $this->sheetName = 'Worksheet';
        $this->fileName = date('YmdHis');
    }

    public function setOptions($properties){
        $sheet = $this->instance->getActiveSheet();
        $this->sheetName = ($properties['sheetName']) ? $properties['sheetName'] : 'Worksheet';
        $this->fileName = ($properties['fileName']) ? $properties['fileName'] : date('YmdHis', time());
        if (is_array($properties['header']) && count($properties['header']) > 0) {
            $this->header = $properties['header'];
            foreach ($properties['header'] as $k => $v) {
                $colString = PHPExcel_Cell::stringFromColumnIndex($k) . strval(1);
                $sheet->setCellValue($colString, $v);
            }
        }
    }

    public function setResolveClass($name = ''){
        $defaultResolveArr = [
            'Excel5' => '.xls',
            'Excel2007' => '.xlsx',
            'CSV' => '.csv'
        ];
        if (!empty($name) && in_array($name, array_keys($defaultResolveArr))) {
            $this->resolveClass = $name;
            $this->suffix = $defaultResolveArr[$name];
        } else {
            $this->resolveClass = 'Excel2007';
            $this->suffix = '.xlsx';
        }
    }

    public function download($data){
        $fileName = $this->fileName . $this->suffix;
        $writer = $this->generateWriter($data);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"{$fileName}\"");
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function save($data, $path){
        $fileName = $this->fileName . $this->suffix;
        $writer = $this->generateWriter($data);
        $des = rtrim($path, '/') . '/' . $fileName;
        $writer->save($des);
    }

    private function generateWriter($data){
        $sheet = $this->instance->getActiveSheet();
        if ($this->sheetName) {
            $sheet->setTitle($this->sheetName);
        }
        $sheet->getStyle('A1:Z1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:Z1')->getFont()->setSize(13)->setBold(true);
        $sheet->getDefaultRowDimension()->setRowHeight(20);    //设置默认行高
        $sheet->getDefaultColumnDimension()->setWidth(18);    //设置默认列宽
    
        // $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setWidth(20);
        if (count($this->header) > 0) {
            $sheet->fromArray($data, null, 'A2');
        } else {
            $sheet->fromArray($data);
        }
        $writer = PHPExcel_IOFactory::createWriter($this->instance, $this->resolveClass);
        return $writer;
    }

}

