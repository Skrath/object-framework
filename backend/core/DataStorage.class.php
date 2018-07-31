<?php

class Datum {
    protected $type = null;
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
            if ($this->validateByType($value)) {
                $this->type = gettype($value);
                $this->value = $value;
            } // Throw stuff here?
        }
    }

    protected function validateByType($value) {
        $validTypes = ['bool', 'integer', 'string', 'double'];

        $map = [
            'boolean' => 'bool'
        ];

        $type = $map[$this->type] ?? $this->type;

        if (in_array($type, $validTypes)) {
            return ('is_'.$type)($value);
        }

        return true;
    }

    public function setType(String $type): String {
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