<?php

namespace App\Http\Controllers\Member;


use App\Http\Controllers\AuthController;
use App\Libraries\Jdf;
use App\Libraries\ResponseClass;
use App\Models\Member;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Ostan;
use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\Shahrestan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Laravel\Lumen\Routing\Controller as Controller;

class MemberController extends AuthController
{
//    public $user;
//
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct(Request $request)
//    {
//        $this->user = $request['memberData5668'];
//        unset($request['memberData5668']);
//    }

    public function getProfile(Request $request)
    {
//        print_r($this->user);exit;
//        return response()->json($this->user, 200);

        if ($this->user['ostancode'] != null && $this->user['ostancode'] != '') {
            $this->user['ostan'] = Ostan::where('code', $this->user['ostancode'])->get();

        } else {
            $this->user['ostan'] = null;
        }

        if ($this->user['shahrestancode'] != null && $this->user['shahrestancode'] != '') {
            $this->user['shahrestan'] = Shahrestan::where('code', $this->user['shahrestancode'])->get();
        } else {
            $this->user['shahrestan'] = null;
        }

        $countId = Message::where([
            "is_read" => 0,
            "receiver_user_id" => $this->user['id'],
            "receiver_type" => 1
        ])->count();
        $this->user['message_count'] = $countId;
        $notificationCount = Notification::where(
            [
                "is_read" => 0,
                "receiver" => $this->user['id'],
                "receiver_type" => 1,
                "status" => 1
            ]
        )->count();

        $this->user['notification_count'] = $notificationCount;
        $id_moaref = $this->user['moaref'];
        if (isset($id_moaref) && $id_moaref != '') {
            $moaref = Member::find($id_moaref);

            $this->user['moaref_name'] = $moaref['fname'] . ' ' . $moaref['lname'];
        }
//        print_r((array)$this->user->notification_count);
//        exit;
//        response()->json();
        ResponseClass::send($this->user);

    }
    public function getAppointmentList(Request $request)
    {




        if (isset($request['sp_id']) && $request['sp_id'] != '') {
            $sp_id = $request['sp_id'];
        } else {
            if ($this->user['user_type'] == 1) {
                $sp_id = $this->user['sp_id'];
            } else if ($this->user['user_type'] == 2) {

                $subsInfo = ServiceProvider::where('parent_id', $this->user['id'])->get();
//var_dump($subsInfo);exit;
//                $subsIDs = array_column($subsInfo, 'id');
//                array_push($subsIDs, $this->user['id']);
                $sp_id = $this->user['id'];
            }
        }






//       $alais= 'reserve.id', 'reserve.req_date', 'zarfiyat.date as reserve_date', 'reserve.selected_service_id as service_name', 'reserve.selected_service_id', 'reserve.status', 'reserve.type', 'reserve.description', 'reserve.attendance_status', 'reserve.attendance_date', 'zarfiyat.sp_id', 'reserve.user_id', 'reserve.user_type', 'reserve.time', 'service_providers.address', 'service_providers.mobile ' ;
        $query = DB::table('reserve')
            ->leftJoin("zarfiyat", "reserve.zarfiyat_id", "=", "zarfiyat.id")
            ->join("service_providers", "service_providers.id", "=", "zarfiyat.sp_id")
//            ->orderBy('id', 'DESC')
            ->select('reserve.id', 'reserve.req_date', 'zarfiyat.date as reserve_date', 'reserve.selected_service_id as service_id', 'reserve.status', 'reserve.type', 'reserve.description', 'reserve.attendance_status', 'reserve.attendance_date', 'zarfiyat.sp_id', 'reserve.user_id as user_id', 'reserve.user_type', 'reserve.time', 'service_providers.address', 'service_providers.mobile ');








        if ($request['history'] === true) {

            $HistoryStatuses = [0, 2, 3, 4, 5];
            if ($this->user['user_type'] == 1) {
                array_push($HistoryStatuses, 6);
            }


            $CurrentDate = (new Jdf)->jdate('Y/m/d');
            $CurrentTime = (new Jdf)->jdate('H:i');
            $query->where(function ($q) use ($CurrentTime, $CurrentDate) {
                $q->where('reserve.status', 1)
                    ->andWhere('zarfiyat.date', '<=', $CurrentDate)
                    ->andWhere(DB::raw("CONCAT(zarfiyat.date,' ',reserve.time)"), '<', $CurrentDate . ' ' . $CurrentTime);
            })
                ->orWhereIn('reserve.status', ($HistoryStatuses));
        }

        if ($request['sp']) {
            $myArray = explode(',', $request['sp']);
            $query->whereIn('zarfiyat.sp_id', $myArray);
        }
        if ($request['shift']) {
            $myArray = explode(',', $request['shift']);
            $query->whereIn('zarfiyat.shift', $myArray);
        }
        if ($request['mindate']) {
            $val_mindate = $request['mindate'];
            $query->where('zarfiyat.date', ">=", $request['mindate']);
        }
        if ($request['mintime']) {
            $MinDate = $request['mindate'] ?? (new Jdf)->jdate("Y/m/d");
//            echo $MinDate . " " . $request['mintime'];exit;
            $query->where(DB::raw('CONCAT(zarfiyat.date, " ", reserve.time)'), '>=', $MinDate . " " . $request['mintime']);
        }
        if ($request['maxdate']) {
            $query->where('zarfiyat.date',"<=", $request['maxdate']);

        }
        if ($request['maxtime']) {
            $query->where('reserve.time', "<", $request['maxtime']);

            $maxDate = $request['maxdate'] ?? '1500/01/01';
//            echo $MinDate . " " . $request['mintime'];exit;
            $query->where(DB::raw('CONCAT(zarfiyat.date, " ", reserve.time)'), '>=', $maxDate . " " . $request['maxdate']);

        }
        if ($request['status']) {
            $myArray = explode(',', $request['status']);
//            print_r($myArray) ;exit;
            $query->whereIn('reserve.status', $myArray);
//                $status = ' and reserve.status IN (' . implode(',', $Data['status']) . ')';

        }
        if ($request['limit']) {
            $query->limit($request['limit']);
//                $status = ' and reserve.status IN (' . implode(',', $Data['status']) . ')';

        }
        if ($request['order']) {
            $query->orderBy($request['order'], $request['ordertype'] === 'ASC' ? 'ASC' : 'DESC');
        }
        $query->where("zarfiyat.status", "!=", "99");

        if ($this->user['user_type'] == 1) {
            $query->where("reserve.user_id", $this->user['id']);
        }
        $Results = $query->get()->all();
//        $Count = $query->count();

        foreach ($Results as $i => $value) {

//            print($Results[0]->user_id);exit;

//            $members=Member::find( $Results[$i]->user_id);


//            $Results[$i]->user_fname = $members->fname;
//            $Results[$i]->user_lname = $members->lname;
//            $Results[$i]->user_mobile = $members->mobile;
//            //      $Results[ $i ][ 'user_image' ] = '1620461439_79883.png';
//            $Results[$i]->user_image = $members->image;
//


            if ($value->user_type == 1) {
                $user_type = 'user(member)';
            } else if ($value->user_type == 2) {
                $user_type = 'service_provider';
            }
            $value->user_type = $user_type;

            $sp = ServiceProvider::where("id", $value->sp_id)->select("name as sp_name  ", "image as sp_image ")->first();

            $value->sp_name = $sp['sp_name'];
            $value->sp_image = $sp['sp_image'];

            //  attendance_status
            $attendance_status = $value->attendance_status;
            if ($attendance_status == 1) {
                $sttrndance_name = 'حضور';
            } else if ($attendance_status == 2) {
                $sttrndance_name = 'عدم حضور';
            } else if ($attendance_status == 0) {
                $sttrndance_name = 'نامشخص';
            }
            $value->attendance_status_name = $sttrndance_name;

            //  status
            $status = $value->status;
            if ($status == 0) {
                $status_name = 'آزاد';
            } else if ($status == 1) {
                $status_name = 'رزرو شده ';
            } else if ($status == 2) {
                $status_name = 'غیرفعال';
            } else if ($status == 3) {
                $status_name = 'رد شده';
            } else if ($status == 4) {
                $status_name = 'لغو توسط خدمت دهنده';
            } else if ($status == 5) {
                $status_name = 'لغو توسط خدمت گیرنده';
            } else if ($status == 6) {
                $status_name = 'در انتظار تایید';
            }
            $value->status_name = $status_name;
            //		type
            $type = $value->type;
            if ($type == 1) {
                $type_name = 'mamoli';
            }

            $value->type = $type_name;

//            $service_id = explode(',', $Results[$i]->service_id);
//            var_dump($service_id);exit;
            $services = Service::where('id', $value->service_id)->first();
            $serv_array = array();
//            foreach ($service_id as $key => $value2) {
//
//                $resultarray = $service_id[$key];
//                var_dump($service_id);
//                $services=  Service::where('id', $resultarray)->first();
//
//
//                $service_name = $services->name;
//                $serv_array[] = $service_name;
//            }
//            $service_name_array = implode(', ', $serv_array);
            $value->service_name = $services;
//            $Results[$i]->reserve_date = $Results[$i]->reserve_date;
        }
//        response()->json();
        ResponseClass::send($Results);

    }
    public function getNotificationList(Request $request)
    {

        $limit = $request['limit'] ?? 5;

       $noti= Notification::where('receiver_type', $this->user['user_type'])
           ->where('receiver', $this->user['id'])
           ->filter()
           ->simplePaginate($limit);
         ResponseClass::send($noti);

    }

}
