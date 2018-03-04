<?php

function findTags($xmlObject, $schema = null)
{
    if (!$schema) {
        $schema = array();
    }

    foreach ((array)$xmlObject as $index => $node) {
        $index = is_numeric($index) ? 0 : $index;
        if ((is_object($node) || is_array($node))) {
            if (!isset($schema[$index])) {
                $schema[$index] = findTags($node);
            } else {
                $schema[$index] = findTags($node, $schema[$index]);
            }
        }
        
        if (!is_numeric($index) && !isset($schema[$index])) {
            $schema[$index] = null;
        }

    }

    return $schema;
}

libxml_use_internal_errors(true);
$path = '/tmp/dialogo-data/transition/rmisa';

$directory = new RecursiveDirectoryIterator($path,RecursiveDirectoryIterator::SKIP_DOTS);
$iterator = new RecursiveIteratorIterator($directory,RecursiveIteratorIterator::LEAVES_ONLY);

$extensions = array("xml");
$articleSchema = $photoSchema = $othersSchema = array();
foreach ($iterator as $fileinfo) {
    if (in_array(strtolower($fileinfo->getExtension()), $extensions)) {
        $xml = simplexml_load_file($fileinfo->getPathname());
        if (isset($xml->article)) {
            $articleSchema = findTags($xml, $articleSchema);
        } elseif (isset($xml->photo)) {
            $photoSchema = findTags($xml, $photoSchema);
        } else {
            $othersSchema = findTags($xml, $othersSchema);
        }
    }
}

$end = 1;