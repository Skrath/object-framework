<?php

class Datum {
    protected $type;
    protected $value;

    public function __construct($value = null) {
        return $this($value);
    }

    public function __invoke($value = null) {
        if (!is_null($value)) {
            $this->storeValue($value);
        }

        return $this->value;
    }

    protected function storeValue($value) {
        if (is_array($value)) {
            
            $this->value = new DataContainer($value);
            
        } else {
            $this->value = $value;
        }
    }

    public function setType(String $type) {
        $this->type = $type;

        return $this->type;
    }
}

class DataContainer {
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

                if (!is_null($arguments[0])) {   
                    $this->{$variable} = $arguments[0];
                }
            }
        }

        return $this->{$variable};
    }

    public function __set(string $name, $value) {
        if ($this->datumExists($name)) {
            return $this->dataContainer[$name]($value);
        } else {
            $this->dataContainer[$name] = new Datum($value);
        }
    }

    public function __get(string $name) {
        if ($this->datumExists($name)) {
            return $this->dataContainer[$name]();
        }
    }

    protected function datumExists(string $name): bool {
        return (
            array_key_exists($name, $this->dataContainer)
            && $this->dataContainer[$name] instanceOf Datum
        );
    }
}