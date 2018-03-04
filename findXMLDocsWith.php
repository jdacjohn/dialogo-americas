<?php
require 'pubic_html/concrete/vendor/autoload.php';

use League\Csv\Reader;

$path = '/tmp/dialogo-data/transition/rmisa';

$directory = new RecursiveDirectoryIterator($path,RecursiveDirectoryIterator::SKIP_DOTS);
$iterator = new RecursiveIteratorIterator($directory,RecursiveIteratorIterator::LEAVES_ONLY);

$extensions = array("xml");
$docs = array();
$total = 0;
$documentsWithoutTopic = 0;
foreach ($iterator as $fileinfo) {
    if (in_array(strtolower($fileinfo->getExtension()), $extensions)) {
//        <keyword>(.*)<\/keyword>
//        preg_match_all('#(cex:link)#', file_get_contents($fileinfo->getPathname()), $matches);
//        preg_match_all('#<keyword(\s.*?|)>(.*?)<\/keyword>#s', file_get_contents($fileinfo->getPathname()), $matches);
        preg_match_all('#<collection>(.*?)<\/collection>#s', file_get_contents($fileinfo->getPathname()), $matches);
        if (!empty($matches[1])) {
//            foreach ($matches[1] as $match) {
//                if (empty($docs[$match])) {
//                    $total = 0;
//                } else {
//                    $total = $docs[$match];
//                }
//
//                $docs[$match] = ++$total;
//            }

//            foreach ($matches[2] as $match) {
//                if (empty($docs[$match])) {
//                    $docs[$match] = array($match, 1);
//                } else {
//                    $docs[$match] = array($match, ++$docs[$match][1]);
//                }
//            }
//        } else {
//            ++$documentsWithoutTopic;
//        }

            foreach ($matches[1] as $match) {
                if (!isset($docs[$match])) {
                    $total = 0;
                } else {
                    $total = ++$docs[$match];
                }

                $docs[$match] = $total;
            }
        }
    }
}

//$topics = League\Csv\Writer::createFromPath("/tmp/topics.csv", "w");
//$topics->insertAll($docs);

$end = 1;
