<?php

// There are 18671 rmisa documents to process

require 'web/concrete/vendor/autoload.php';

use League\Csv\Reader;
use PortlandLabs\Concrete5\MigrationTool\Importer\Dialogo\DialogoParser;

libxml_use_internal_errors(true);

$file = '/Users/tas/dev/dialogo-americas/data/MetaData.csv';
$csvData = Reader::createFromPath($file);
$notFoundPages = array();
$notFoundImages = array();
//$docsWithoutTopic = 0;
$docsWithoutTopic = array();
$folderTopics = array();
$foundPages = 0;
$types = array();
$docsWithoutType = array();
$topics = array();
foreach ($csvData as $item) {
    if ($item[0] == 'ID') continue;
    if ($item[6] != 'rmisa') continue;

    $path = $item[0];
    $language = $item[2];
    $filePath = sprintf("%s/%s-%s.xml", '/tmp/dialogo-data/transition', $path, $language);

    if (!file_exists($filePath)) {
        $notFoundPages[] = sprintf("%s-%s.xml", $path, $language);;
        continue;
    } else {
        ++$foundPages;
    }

    $type = null;
    $xml = simplexml_load_file($filePath);
    if ($xml->article) {
        if ($xml->article->meta->collection && !empty((string)$xml->article->meta->collection)) {
            $type = (string)$xml->article->meta->collection;
        } else {
            foreach ($xml->article->attributes() as $key => $value) {
                if ($key == 'type') {
                    $type = (string)$value;
                }
            }
        }
    } elseif ($xml->photo) {
        $type = 'photo';
    }

    if ($type) {
        if (!empty($types[$type])) {
            $types[$type] = ++$types[$type];
        } else {
            $types[$type] = 1;
        }
    } else {
        $docsWithoutType[] = $filePath;
    }

    $text = file_get_contents($filePath);
    preg_match_all('#<keyword(\s.*?|)>(.*?)<\/keyword>#s', $text, $matches);

    if (!empty($matches[1])) {
        foreach ($matches[2] as $match) {
            if (empty($topics[$match])) {
                $topics[$match] = array($match, 1);
            } else {
                $topics[$match] = array($match, ++$topics[$match][1]);
            }
        }
    } else {
        $docsWithoutTopic[] = $filePath;
        $folders = explode('/', $filePath);
        if ($folders[5] == 'features') {
            $folderTopic = $folders[6];
        } else {
            $folderTopic = $folders[5];
        }

        if (empty($folderTopics[$folderTopic])) {
            $folderTopics[$folderTopic] = 1;
        } else {
            $folderTopics[$folderTopic] = ++$folderTopics[$folderTopic];
        }
    }
}

foreach ($types as $type => $count) {
    $csvTypes[] = array($type, $count);
}

$typesCSV = League\Csv\Writer::createFromPath("/tmp/types.csv", "w");
$typesCSV->insertAll($csvTypes);

$topicsCSV = League\Csv\Writer::createFromPath("/tmp/topics.csv", "w");
$topicsCSV->insertAll($topics);

foreach ($folderTopics as $fTopicKey => $fTopicValue) {
    $fTopics[] = array($fTopicKey, $fTopicValue);
}
$folderTopicsCSV = League\Csv\Writer::createFromPath("/tmp/folderTopics.csv", "w");
$folderTopicsCSV->insertAll($fTopics);

sort($docsWithoutTopic);

$end = 1;