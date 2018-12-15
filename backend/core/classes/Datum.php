<?php
namespace Core;

use Core\DataContainer;
use Core\MetaDataContainer;

class Datum {
    protected $type = 'unknown';
    protected $value;
    protected $defaultValue = null;
    protected $typeMap = [
        'boolean' => 'bool'
    ];
    protected $metaContainer;
    protected $schema = Array();

    public function __construct($value = null, Array $schema = null, Array $typemap = null) {
        $this->metaContainer = new MetaDataContainer();

        $this->schema = $schema;
        if (isset($typemap)) {
            $this->typeMap = array_merge($this->typeMap, $typemap);
        }

        return $this($value);
    }

    public function __invoke($value = null) {
        if (!is_null($value)) {
            $this->storeValue($value);
        }

        return $this->value;
    }

    public function __call(string $name , array $arguments) {
        if (isset($arguments[0]) && !is_null($arguments[0])) {
            return $this->value->$name($arguments[0]);    
        } else {
            return $this->value->$name();
        }
    }

    public function __toString(): String
    {
        if (is_object($this->value)) {
            return 'Object';
        }

        if (is_bool($this->value)) {
            return ($this->value) ? 'True' : 'False';
        }

        return (String) $this->value;
    }

    public function meta() {
        return $this->metaContainer;
    }

    protected function storeValue($value) {
        if (is_array($value)) {
            $this->value = new DataContainer($value);
        } else {
            if ($this->type == 'unknown') {
                $this->type = $this->schema['type'] ?? gettype($value) ?? 'unknown';
            }

            $this->value = $this->autoCast($value);
        }
    }

    protected function autoCast($value) {
        $validTypes = ['bool', 'integer', 'string', 'double'];

        if (isset($this->type)) {
            $type = $this->typeMap[$this->type] ?? $this->type;

            if (in_array($type, $validTypes)) {
                settype($value, $type);
            }
        }

        return $value;
    }

    public function setType(String $type): String {
        $this->type = $type;

        return $this->type;
    }

    public function getType(): String {
        return $this->type;
    }
}