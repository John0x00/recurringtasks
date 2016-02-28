<?php

namespace recurringtasks;


class TaskIdTest extends \PHPUnit_Framework_TestCase
{
    public function testEquals() {

        $id = new TaskListId(new Uuid());
        $id2 = new TaskListId(new Uuid());
        $this->assertFalse($id->equals($id2));
        $this->assertTrue($id->equals($id));

    }
}