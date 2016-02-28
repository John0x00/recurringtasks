<?php

namespace recurringtasks;


class Task
{

    /** @var  string */
    private $title;

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

}