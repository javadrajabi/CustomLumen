<?php
namespace App\Jobs;

use App\Jobs\Job;
use App\Libraries\DornicaSms;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SMSQueue extends Job
{
    public $code;
    public $mobile;
    public $sp_id;
    public $id;
    public $num;
//[$code], $user->mobile, $user->sp_id, $user->id, 2
    public function __construct($code, $mobile,$sp_id,$id,$num)
    {
        $this->code = $code;
        $this->mobile = $mobile;
        $this->sp_id = $sp_id;
        $this->id = $id;
        $this->num = $num;
    }
    /**
     * Execute the job.
     *
     * @param
     * @return void
     */

    public function handle() {
        sleep(6);
        file_put_contents("ahdujwd.txt",'4e6d57f46re5f6474 f5674r85 74f857r4 85f');
//        for($i=0; $i<=1000; $i++) {
//            Log::info(' ---'.$i.'SMS TO  ' . $this->mobile . ' is run at start time - ' . microtime(true));
//        }
//        DornicaSms::send($this->code,$this->mobile,$this->sp_id,$this->id,$this->num );
    }
}
