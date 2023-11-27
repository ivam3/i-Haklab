<?php
namespace ZipMerge\Zip\Core;

abstract class AbstractZipWriter {

    /**
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @param string $data
     */
    abstract public function zipWrite($data);
}