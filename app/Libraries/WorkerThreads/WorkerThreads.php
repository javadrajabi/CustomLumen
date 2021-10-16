<?php

namespace App\Libraries\WorkerThreads;
use App\Libraries\DornicaSms;
use Parallel;


class WorkerThreads
{

// create your own class from Thread

    private $code;
    private $mobile;
    private $sp_id;
    private $id;
    private $num;
//[$code], $user->mobile, $user->sp_id, $user->id, 2
    public function __construct($code, $mobile,$sp_id,$id,$num)
    {
        $this->code = $code;
        $this->mobile = $mobile;
        $this->sp_id = $sp_id;
        $this->id = $id;
        $this->num = $num;
    }

    // main function
    public function run()
    {

        # this is my code
        $runtime = new \Parallel\Runtime();

        $future = $runtime->run(function(){
            for ($i = 0; $i < 50; $i++)
                echo "$i";

            return "easy";
        });

        for ($i = 0; $i < 50; $i++) {
            echo ".";
        }
//        echo "Worker #{$this->workerId} ran" . PHP_EOL;
        DornicaSms::send($this->code,$this->mobile,$this->sp_id,$this->id,$this->num );
        // make some long run tasks
        $html = file_get_contents('http://google.com?q=testing');
    }

}
