<?php
namespace Core;

use Core\DataContainer;

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
            } else {
                // attempt casting
                if (settype($value, $this->type)) {
                    $this->value = $value;
                }
            }
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