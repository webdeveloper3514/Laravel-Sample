<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user\UserData;
use App\Models\user\Options;
use App\Models\user\EventUserData;
use Session;

class UserDataController extends Controller
{
    
    function emp_opportunity()
    {
        return view('user/contact-us');
    }

    function general_comments()
    {
        return view('user/contact-us');
    }
    
    function leasing_info()
    {
        return view('user/contact-us');
    }


    function signup()
    {
        return view('user/registration');
    }

    function user_signup( Request $request )
    {
        $input = $request->all();
        $input['st_role_option'] = (implode(",",$request->input('role_option')));
        $user_data = new UserData();
        $result = $user_data->insert_data( $input );
        if( $result ){
            return redirect('user-list')->with('success','User Successfully Sign up');
        }else{
            return redirect('user/sign-up')->with('error','Something went wrong!');
        }
    }

    function add_event_data(){

        $Options = new Options();
        $data = $Options->get_data( ['key' => 'event_signup_description'] );

        return view('user/addeventdata')->with('data', ['description' => $data[0]->st_value]);
    }

    function setsignupdata( Request $request ) {
        if(isset($request->file)){
            $fileName = time().'.'.$request->file->extension();
            $request->file->move(public_path('uploads/event_signup'), $fileName);
        }else{
            $fileName = '0';
        }

        $Options = new Options();
        $result = $Options->insert_data( ['key' => 'event_signup_image', 'value' => $fileName] );
        $result2 = $Options->insert_data( ['key' => 'event_signup_description', 'value' => $request->description] );

        $data = $Options->get_data( ['key' => 'event_signup_description'] );

        return redirect('add_event_data')->with('success', 'Data updated');
    }

    function signin()
    {
        return view('user/login');
    }

    function user_signin( Request $request )
    {
        $user_data = new UserData();
        $result = $user_data->login_data( $request );
        if($result){
            return redirect('user/home')->with('success','User Successfully Sign in');
        }else{
            return redirect('user/sign-in')->with('error','Something went wrong!');
        }
    }

    function event_signup()
    {
        $Options = new Options();
        $data = array();
        $data['image'] = $Options->get_data( ['key' => 'event_signup_image'] );
        $data['description'] = $Options->get_data( ['key' => 'event_signup_description'] );

        $result = array(
            'image' => '/uploads/event_signup/' . $data['image'][0]->st_value,
            'description' => $data['description'][0]->st_value
        );

        return view('user/eventregistration')->with( $result );
    }

    function event_register( Request $request )
    {
        $event_user_data = new EventUserData();
        $result = $event_user_data->insert_data( $request );

        $response = array(
            'error' => '',
            'message' => ''
        );

        if( isset( $result['error'] ) && $result['error'] == 'USER_EXISTS' ){
            $response['error'] = 'USER_EXISTS';
            $response['message'] = 'You are already registered';
        } else if( $result->id ){
            $response['message'] = 'Thank you for registering';
        }else{
            $response['error'] = 'ERROR';
            $response['message'] = 'Something went wrong';
        }
        return redirect('/usersignup')->with( $response );
    }

    function logout()
    {
        Session::put('login', NULL);
        return redirect('user/home')->with('success','User Successfully Sign Out');
    }

    function get_all_user()
    {
        $user_data = new UserData();
        $result = $user_data->get_user();
        return view('all_user',['user'=>$result]);
    }

    function edit_user( $id )
    {
        $user_data = new UserData();
        $result = $user_data->edit_user($id);
        return view('edit_user',['user'=>$result[0]]);
    }

    function edit_user_data( Request $request ){
        $id = $request->input('id_user');
        $request['st_role_option'] = (implode(",",$request->input('role_option')));
        $user_data = new UserData();
        $result = $user_data->edit_user_data( $request, $id );
        if( $result ){
            return redirect('user-list')->with('success', 'User Updated Successfully');
        } else {
            return redirect('user-list');
        }
    }

    function deleteUser($id)
    {
        $user_data = new UserData();
        $result = $user_data->delete_user($id);
        if( $result ){
            return redirect('user-list')->with('success', 'User Deleted Successfully');
        } else {
            return redirect('user-list');
        }
    }
}
