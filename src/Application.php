<?php

class Application
{
    /**
     * @var string
     */
    private $type;

    public function __construct(string $type)
    {

        $this->type = $type;
    }

    public function execute()
    {
        return new React\Http\Response(
            200,
            array('Content-Type' => 'text/plain'),
            "Hello World from $this->type!\n"
        );
    }
}