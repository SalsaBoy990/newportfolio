<?php

class PollService
{
    /**
     * CSV file to store the votes
     */
    private const FILENAME = 'votes.csv';


    /**
     * Read data from the file, transform it to an associative array
     *
     * @param  string  $delimiter
     *
     * @return array
     */
    public function _read_data_from_csv(string $delimiter = ';'): array
    {
        // add extension
        $file_path = dirname(__FILE__, 2) . '/assets/data/' . self::FILENAME;

        try {
            if (($result = fopen($file_path, 'r')) === false) {
                throw new \Exception('Cannot read the file because the file is unaccessible.');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        // store first line (header)
        $header = fgets($result);

        // the next line is data
        $dataLine = stream_get_contents($result);

        if (!fclose($result)) {
            echo 'Error closing the file.';
        }
        //--------------------------- File closed

        // split votes
        $dataLineExploded = explode($delimiter, $dataLine);
        $votes = array();
        $languages = array('Laravel', 'Trongate', 'Symfony', 'CodeIgniter', 'Lumen', 'Laminas', 'Phalcon', 'CakePHP', 'Yii', 'Zend');

        for ($i = 0; $i < count($dataLineExploded); $i++) {
            // put votes data into array
            $votes[$languages[$i]] = intval($dataLineExploded[$i], 10);
        }

        // descending order by value
        arsort($votes);

        return $votes;
    }

}
