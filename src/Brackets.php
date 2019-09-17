<?php

namespace phpCoder88;

use InvalidArgumentException;

class Brackets
{
    protected $brackets;

    protected $allowed = [
        '(' => ')',
    ];

    public function __construct($brackets)
    {
        $this->brackets = $brackets;
    }

    public function check()
    {
        if (!$this->validate()) {
            throw new InvalidArgumentException('There are symbols that are not allowed');
        }

        $this->clear();

        return $this->checkBrackets();
    }

    protected function validate()
    {
        return preg_match('/^[()\s\n\r\t]*$/', $this->brackets);
    }

    protected function clear()
    {
        $this->brackets = str_replace([" ", "\n", "\r", "\t"], '', $this->brackets);
    }

    protected function checkBrackets()
    {
        $stack = [];
        $flipped = array_flip($this->allowed);

        for ($i = 0, $length = strlen($this->brackets); $i < $length; $i++) {
            if (array_key_exists($this->brackets[$i], $this->allowed)) {
                array_unshift($stack, $this->brackets[$i]);
                continue;
            }

            $last = array_pop($stack);
            if ($last !== $flipped[$this->brackets[$i]]) {
                return false;
            }
        }

        return count($stack) == 0;
    }
}