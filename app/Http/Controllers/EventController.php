<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use DB;
use Session;

class EventController extends Controller
{
    function createEvent(){
        $category = new Category();
        $category_data = $category->all_data();
        return view('events/add_event',['category'=>$category_data]);
    }

    function storeEvent( Request $request ){
        $files = [];
        if($request->hasfile('filenames')){
            foreach($request->file('filenames') as $file){
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('uploads/event'), $name);
                $files[] = $name;
            }
        }
        $event = new Event();
        $fileName = json_encode($files);
        if($event->insert_data( $request, $fileName )){
            return redirect('all_event')->with('success', 'Event Added Successfully');
        }else{
            return redirect('all_event');
        }
    }

    function all_event(){
        $event = new Event();
        $data = $event->get_all_event();
        return view('events/all_event',['event'=>$data]);
    }

    function event_users(){
        $event = new Event();
        $data = $event->get_all_event_users();
        return view('events/all_event_users',['event_users'=>$data]);
    }

    function edit_event( $id ){
        $event = new Event();
        $data = $event->get_selected_event( $id );
        $category = new Category();
        $category_data = $category->all_data();
        return view('events/edit_event',['data'=>$data[0],'category'=>$category_data]);
    }

    function edit_event_data( Request $request ){
        $event = new Event();
        $id = $request->input('id');

        $files = [];
        if($request->hasfile('filenames')){
            foreach($request->file('filenames') as $file){
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('uploads/event'), $name);
                $files[] = $name;
            }
            $fileName = implode(",",$files);
            $result = $event->edit_event( $request, $id, $fileName );
        }else{
            $result = $event->edit_event( $request, $id, '' );
        }
        
        if( $result ){
            return redirect('all_event')->with('success', 'Event Updated Successfully');
        }else{
            return redirect('all_event');
        }
    }

    function deactive_event( $id ){
        $event = new Event();
        $result = $event->deactive_event( $id );
        if( $result ){
            return redirect('all_event');
        }else{
            return redirect('all_event');
        }
    }

    function delete_event( $id ){
        $event = new Event();
        $result = $event->delete_event( $id );
        if( $result ){
            return redirect('all_event')->with('success', 'Event Delete Successfully');
        }else{
            return redirect('all_event');
        }
    }

    function edit_event_new( $id ){
        $event = new Event();
        $data = $event->get_selected_event_new( $id );
        $category = new Category();
        $category_data = $category->all_data();
        $data_date_time = DB::table('tbl_date_time')->where('in_event_id', '=', $id)->get();
        return view('events/edit_event_new',['data'=>$data[0],'category'=>$category_data,'date_time'=>$data_date_time]);
    }

    function edit_event_data_new( Request $request )
    {
        $event = new Event();
        $id = $request->input('id');

        $files = [];
        $files_new = $request->input('filenames_new');
        if($request->hasfile('filenames')){
            foreach($request->file('filenames') as $file){
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('uploads/event'), $name);
                $files[] = $name;
            }
            foreach($files as $value){
                if($files_new != null){
                    array_push($files_new, $value);
                }else{
                    $files_new[] = $value;
                }
            }
            $fileName = json_encode($files_new);
            $result = $event->edit_event_new( $request, $id, $fileName );
        }else{
            $fileName = json_encode($files_new);
            $result = $event->edit_event_new( $request, $id, $fileName );
        }
        if( $result ){
            return redirect('all_event')->with('success', 'Event Updated Successfully');
        }else{
            return redirect('all_event');
        }
    }

    function delete_image( $name, $id ) {
        // dd('ws');
        $image_name = [];
        array_push($image_name, $name);
        Session::push('delete_image',$image_name);
        $data = Session::get('delete_image');

    }
}
