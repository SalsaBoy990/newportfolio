<?php

final class Basestats extends Trongate
{
    private string $csv_path;

    public function __construct($module_name = null)
    {
        parent::__construct($module_name);

        $this->csv_path = dirname(__FILE__, 2)."/assets/data/nexum.csv";
    }

    function index(): void
    {
        $data['view_file'] = 'index';
        $data['test'] = $this->_getData();

        $this->template('clean', $data);

    }


    /** Show sample data */
    function sample(): void
    {
        json($this->_getData());
    }


    /** Return data as json */
    function stats() {
        echo json_encode($this->_getData());
        die;
    }


    /** Get array data from CSV */
    private function _getData(): array
    {
        $response = [
            'data' => []
        ];

        $row = 1;
        if (($handle = fopen($this->csv_path, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $num = count($data);
                $row++;
                for ($c = 0; $c < $num; $c++) {
                   $response['data'][] = (int) $data[$c];
                }
            }
            fclose($handle);
        }

        return $response;
    }

}
