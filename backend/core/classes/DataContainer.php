<?php
namespace Core;

use Core\Datum;

class DataContainer implements \Iterator, \ArrayAccess {
    protected $dataContainer = [];
    protected $schemaData = null;

    public function __construct(Array $data = null) {
        if (!is_null($data)) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    public function __call(string $name , array $arguments) {
        if ($this->datumExists($name)) {
            return $this->dataContainer[$name];
        }

        foreach (['get', 'set', 'save', 'load'] as $action) {
            if (stripos($name, $action) === 0) {
                $variable = substr($name, strlen($action));

                if (isset($arguments[0]) && !is_null($arguments[0])) {   
                    $this->{$variable} = $arguments[0];
                }
            }
        }
        
        return $this->{$variable};
    }

    public function __set(string $name, $value) {
        $datumSchema = $this->schemaData['datums'] ?? null;
        $typeMap = $this->schemaData['typemap'] ?? null;
        
        if ($this->datumExists($name)) {
            $this->dataContainer[$name]($value, $datumSchema, $typeMap);
        } else {
            $this->dataContainer[$name] = new Datum($value, $datumSchema, $typeMap);
        }
    }

    public function __get(string $name) {
        if ($this->datumExists($name)) {
            if (array_search($name, $this->dataContainer) !== false) {
                return $this->dataContainer[array_search($name, $this->dataContainer)]();
            } else {
            return $this->dataContainer[$name]();
        }
        }

        return null;
    }

    protected function datumExists(string $name): bool {
        return (
            (array_key_exists($name, $this->dataContainer)
            && $this->dataContainer[$name] instanceOf Datum)
            || 
            ( (array_search($name, $this->dataContainer) !== false)
            && $this->dataContainer[array_search($name, $this->dataContainer)] instanceOf Datum)
        );
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
        return $this->datumExists($offset);
    }

    public function offsetUnset($offset): Void {
        unset($this->dataContainer[$offset]);
    }

    public function offsetGet($offset) {
        return $this->$offset;
    }
}