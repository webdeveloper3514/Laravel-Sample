<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use Auth;
use Config;
use Session;

class Event extends Model
{
    use HasFactory;
     protected $fillable = [

        'in_id', 'st_name' ,'st_description' ,'st_image' ,'dt_date', 'dt_end_date' ,'in_category_id' , 'in_user_id', 'in_status'

    ];
    protected $table = 'tbl_events';

    function insert_data(Request $request,$fileName)
    {
        $event = new Event();
        $event->st_name = $request->name;
        $event->st_description = $request->description;
        $event->st_image = $fileName;
        $event->dt_date = $request->date;
        $event->dt_end_date = $request->date_end;
        $event->in_category_id = $request->category_id;
        $event->st_url = $request->video;
        $event->in_user_id = Auth::User()->id;
        $event->in_status = $request->status;
        $event->save();
        $id = $event->id;
        return true;
    }

    function get_all_event()
    {
        $id = Auth::User()->id;
        $check_user = DB::select('select * from '.Config::get("constants.table_user").' where id = '.$id);
        if($check_user[0]->menuroles == "admin"){
            $data = DB::table(Config::get('constants.table_event'))->where('in_status', '=', 1)->get();
        }else{
            $data = DB::table(Config::get('constants.table_event'))->where('in_status', '=', 1)->where('in_user_id', '=', $id)->get();
        }
        return $data;
    }

    function get_all_event_users()
    {
        $data = DB::select('select * from '.Config::get("constants.table_event_users"));
        return $data;
    }

    function get_selected_event($id)
    {
        $data = DB::select("SELECT * FROM ".Config::get('constants.table_event')." where in_ev_id =".$id);
        return $data;
    }

    function deactive_event($id)
    {
        $result = DB::table(Config::get('constants.table_event'))->where('in_ev_id', $id)->update(['in_status' => 0]);
        return $result;
    }

    function delete_event($id)
    {
        $result = DB::table(Config::get('constants.table_event'))->where('in_ev_id', $id)->update(['in_status' => 0]);
        return $result;
    }

    function get_selected_event_new( $id ){
        $data = DB::select("SELECT * FROM ".Config::get('constants.table_event')." where in_ev_id =".$id);
        return $data;
    }

    function edit_event_new( Request $request, $id, $fileName='' ) {
        $name = $request->name;
        $description = $request->description;
        $date_temp = $request->date;
        $date_end = $request->date_end;
        $category_id = $request->category_id;
        $status = $request->status;
        $url = $request->video;

        if( $fileName!='' ){

            $result = DB::table('tbl_events')->where('in_ev_id', $id)
                ->update([
                    'st_name' => $name,
                    'st_description' =>$description,
                    'st_image' => $fileName,
                    'dt_date' => $date_temp,
                    'dt_end_date' => $date_end,
                    'st_url' => $url,
                    'in_category_id' => $category_id,
                    'in_status' =>$status
                ]);
        }else{
            $result = DB::table('tbl_events')->where('in_ev_id', $id)
                ->update([
                    'st_name' => $name,
                    'st_description' =>$description,
                    'dt_date' => $date_temp,
                    'dt_end_date' => $date_end,
                    'st_url' => $url,
                    'in_category_id' => $category_id,
                    'in_status' =>$status
                ]);
        }
        // dd('result');
        return true;
    }
}

