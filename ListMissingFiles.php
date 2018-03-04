<?php

// There are 18671 rmisa articles

require 'public_html/concrete/vendor/autoload.php';

use League\Csv\Reader;
use PortlandLabs\Concrete5\MigrationTool\Importer\Dialogo\DialogoParser;

$file = '/Users/tas/dev/dialogo-americas/data/MetaData.csv';
$csvData = Reader::createFromPath($file);
$notFoundPages = array();
$notFoundImages = array();
foreach ($csvData as $item) {
    if ($item[0] == 'ID') continue;
    if ($item[6] != 'rmisa') continue;

    $path = $item[0];
    $language = $item[2];
    $filePath = sprintf("%s/%s-%s.xml", '/tmp/dialogo-data/transition', $path, $language);

    if (!file_exists($filePath)) {
        $notFoundPages[] = sprintf("%s-%s.xml", $path, $language);;
        continue;
    }

    preg_match_all('#img-ref src="(.*?)"#', file_get_contents($filePath), $matches);
    if ($matches[1]) {
        foreach ($matches[1] as $image) {
            if (!file_exists('/Users/tas/dev/dialogo-americas/data/' . $image)) {
                $notFoundImages[] = $image;
            }
        }
    }
}

$notFoundPages = array_unique($notFoundPages);
rsort($notFoundPages);
$pagesCSV = League\Csv\Writer::createFromPath("/tmp/missingPages.csv", "w");
$pagesCSV->insertAll($notFoundPages);

$notFoundImages = array_unique($notFoundImages);
rsort($notFoundImages);
$imagesCSV = League\Csv\Writer::createFromPath("/tmp/missingImages.csv", "w");
$imagesCSV->insertAll($notFoundImages);

$end = 1;
