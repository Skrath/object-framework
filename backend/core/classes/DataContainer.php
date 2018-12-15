<?php
namespace Core;

use Core\Datum;

class DataContainer implements \Iterator, \ArrayAccess {
    protected $dataContainer = [];
    protected $schemaData = null;
    protected $DatumClassName = __NAMESPACE__ . "\Datum";

    public function __construct(Array $data = null) {
        if (!is_null($data)) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    public function __call(string $name , array $arguments) {
        foreach (['get', 'set', 'save', 'load'] as $action) {
            if (stripos($name, $action) === 0) {
                $name = substr($name, strlen($action));
            }

                if (isset($arguments[0]) && !is_null($arguments[0])) {   
                $this->{$name} = $arguments[0];
            }

            $return = $this->datumSearch($name);
        }
        
        return ( $return !== false ) ? $return : null;
    }

    public function __set(string $name, $value) {
        $datumSchema = $this->schemaData['datums'] ?? null;
        $typeMap = $this->schemaData['typemap'] ?? null;
        
        if ($this->datumSearch($name) !== false) {
            $this->dataContainer[$name]($value, $datumSchema, $typeMap);
        } else {
            $this->dataContainer[$name] = new $this->DatumClassName($value, $datumSchema, $typeMap);
        }
    }

    public function __get(string $name) {
        return ( ($return = $this->datumSearch($name)) !== false ) ? $return() : null;
        }

    protected function datumSearch(string $name) {
        $return = false;

        if (array_search($name, $this->dataContainer) !== false) {
            $return = $this->dataContainer[array_search($name, $this->dataContainer)];
        } elseif (array_key_exists($name, $this->dataContainer)) {
            $return = $this->dataContainer[$name];
    }

        return ($return instanceOf Datum) ? $return : false;
    }

    ///// Iterator functions
    function rewind() {
        reset($this->dataContainer);
    }

    function current() {
        return current($this->dataContainer);
    }

    function key() {
        return key($this->dataContainer);
    }

    function next() {
        next($this->dataContainer);
    }

    function valid(): bool {
        return (bool) current($this->dataContainer);
    }

    ///// ArrayAccess functions
    public function offsetSet($offset, $value): Void {
        $this->$offset = $value;
    }

    public function offsetExists($offset): bool {
        return ($this->datumSearch($offset) !== false);
    }

    public function offsetUnset($offset): Void {
        unset($this->dataContainer[$offset]);
    }

    public function offsetGet($offset) {
        return $this->$offset;
    }
}