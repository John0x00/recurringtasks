<?php
namespace recurringtasks;


class SimpleTaskListRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private static $dataDirectory;

    /**
     * @var SimpleTaskListRepository
     */
    private $repository;

    public static function setUpBeforeClass()
    {
        self::$dataDirectory = sys_get_temp_dir() . '/' . uniqid(__CLASS__);
        mkdir(self::$dataDirectory);
    }

    public static function tearDownAfterClass()
    {
        #exec('rm -rf ' . self::$dataDirectory);
    }

    protected function setUp()
    {
        $this->repository = new SimpleTaskListRepository(
            self::$dataDirectory,
            new InMemoryTaskListRepository()
        );
    }

    public function testScheduleCanBeCreated()
    {
        $taskList = $this->repository->createTaskList();

        $this->assertInstanceOf(TaskList::class, $taskList);
    }

    public function testScheduleCanBeFoundInMemory()
    {
        $taskList = $this->repository->createTaskList();

        $this->assertSame(
            $taskList,
            $this->repository->findById($taskList->getId())
        );
    }

    public function testScheduleCanBeFoundOnDisk()
    {
        $schedule = $this->repository->createTaskList();
        $this->repository->commit();

        $repository = new SimpleTaskListRepository(
            self::$dataDirectory,
            new InMemoryTaskListRepository
        );

        $this->assertEquals(
            $schedule,
            $repository->findById($schedule->getId())
        );
    }

    public function testCannotFindScheduleThatDoesNotExist()
    {
        $this->expectException(TaskListNotFoundException::class);

        $this->repository->findById(new TaskListId(new Uuid));
    }
}
