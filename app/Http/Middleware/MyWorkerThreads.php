<?php
namespace App\Http\Middleware;
// create your own class from Thread
use Thread;

class MyWorkerThreads extends Thread
{
    private $workerId;
    private $authority;

    public function __construct($id, $authority)
    {
        $this->workerId = $id;
        $this->authority = $authority;
    }

    // main function
    public function run()
    {
        echo "Worker #{$this->workerId} ran" . PHP_EOL;

        $authority =$authority ?? '';
        echo $this->$authority;

        // make some long run tasks
        $html = file_get_contents('http://google.com?q=testing');
    }
}
