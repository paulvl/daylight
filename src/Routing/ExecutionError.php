<?php

namespace Daylight\Routing;

class ExecutionError
{
    public $message;
    public $data;

    public function __construct($message, $data)
    {
        $this->message = $message;
        $this->data = $data;
    }

}
