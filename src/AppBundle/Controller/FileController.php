<?php

namespace AppBundle\Controller;

use Symfony\Component\Filesystem\Filesystem;
use AppBundle\Controller\CalcActionController;

/**
 * Description of FileController
 *
 * @author tomasz_lada
 */
class FileController {

    public function saveFile($fileName, CalcActionController $calc) {
        $file = new Filesystem();

        if ($file->exists($fileName)) {
            $file = fopen($fileName, 'a+');
            fwrite($file, date('Y/m/d H:i:s') . ';' . $calc->getVar1() . ';' .
                    $calc->getFunc() . ';' . $calc->getVar2() . ';' . $calc->getResult() . ';' . PHP_EOL);
            fclose($file);
        } else {
            try {
                $file->touch($fileName);
                $file = fopen($fileName, 'a+');
                fwrite($file, date('Y/m/d H:i:s') . ';' . $calc->getVar1() . ';' .
                        $calc->getFunc() . ';' . $calc->getVar2() . ';' . $calc->getResult() . ';' . PHP_EOL);
                fclose($file);
            } catch (IOExceptionInterface $e) {
                echo "Błąd podczas tworzenia pliku " . $e->getPath();
            }
        }
    }

    public function readFile($fileName) {
        $file = new Filesystem();
        $line = array();
        if ($file->exists($fileName)) {
            $file = fopen($fileName, 'r');
            $i = 0;

            while (!feof($file)) {
                $csv[$i] = fgetcsv($file, 0, ';');
                if ($csv[$i] == null) break;
                $calc = new \AppBundle\Entity\CalcEntity();
                $calc->setVar1($csv[$i][1]);
                $calc->setFunc($csv[$i][2]);
                $calc->setVar2($csv[$i][3]);
                $calc->setResult($csv[$i][4]);
                $line[$i][0] = $csv[$i][0];
                $line[$i][1] = $calc;
                $i++;
            }

            fclose($file);
        }
        return $line;
    }

    public function showHistory($history) {
        $historyString = '';
        foreach ($history as $line) {
            $historyString .= $line[1] . ' - Dodano: ' . $line[0];
        }
        return $historyString;
    }

}
