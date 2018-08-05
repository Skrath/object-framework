<?php
namespace Core;

use Core\Datum;

class DataContainer implements \Iterator {
    protected $dataContainer = [];

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
        if ($this->datumExists($name)) {
            $this->dataContainer[$name]($value);
        } else {
            $this->dataContainer[$name] = new Datum($value);
        }
    }

    public function __get(string $name) {
        if ($this->datumExists($name)) {
            return $this->dataContainer[$name]();
        }

        return null;
    }

    protected function datumExists(string $name): bool {
        return (
            array_key_exists($name, $this->dataContainer)
            && $this->dataContainer[$name] instanceOf Datum
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
}