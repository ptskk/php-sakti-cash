<?php

class Sakticash_Callback
{

    private $response;

    public function __construct($input_source = "php://input")
    {
        $raw_callback = json_decode(file_get_contents($input_source), true);
        $this->response = $raw_callback;
    }
}
