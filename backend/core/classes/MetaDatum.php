<?php
namespace Core;

use Core\DataContainer;
use Core\MetaDataContainer;

class MetaDatum extends Datum {
    public function __construct($value = null, Array $schema = null, Array $typemap = null) {
        $this->schema = $schema;
        if (isset($typemap)) {
            $this->typeMap = array_merge($this->typeMap, $typemap);
        }

        return $this($value);
    }
}