<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\PhotoFolder;

class PhotoController extends Controller
{
    function createPhoto(){
        $photofolder = new PhotoFolder();
        $data = $photofolder->get_all_photo();
        return view('photo_gallary/add_photo' , ['photo'=>$data]);
    }

    function createPhotoFolder(){
        return view('photo_gallary/add_photo_folder');
    }

    function storePhoto( Request $request ) {
      
        if ($request->hasfile('photofile')) {
            $i = 0 ;
            foreach ($request->file('photofile') as $all_files) {
                $photo = new Photo();

                $flag = 0;
                $fileName = time().$i.'.'.$all_files->extension();

                echo $fileName;
                $all_files->move(public_path('uploads/photo_gallery'), $fileName);
            
                if($photo->insert_data( $request,$fileName )){
                    $flag = 1;
                    
                }else{
                    $flag = 0;
                    
                }
                $i++;
            }
        }
        if( $flag == 1){
            return redirect('all_photo')->with('success', 'Photo Gallery Item Added Successfully');
        }
        else{
            return redirect('all_photo');
        }
        
        
    }

    function storePhotoFolder( Request $request ) {
        $photofolder = new PhotoFolder();
        if($photofolder->insert_data( $request ) ){
            return redirect('all_photo')->with('success', 'Photo Gallery Folder Added Successfully');
        }
        
    }

    function all_photo() {
        $photo = new Photo();
        $photofolder = new PhotoFolder();
        $data = $photo->get_all_photo();
        $data2 = $photofolder->get_all_photo();
        return view('photo_gallary/all_photo',['photo'=>$data,'photofolder'=>$data2]);
    }

    function deletePhoto( $id )
    {
        $photo = new Photo();
        $result = $photo->delete_photo( $id );
        if($result){
            return redirect('all_photo')->with('success', 'Photo Gallery Item Deleted Successfully');
        }else{
            return redirect('all_photo');
        }        
    }

    function deletePhotoFolder( $id )
    {
        $photo = new PhotoFolder();
        $result = $photo->delete_photo_folder( $id );
        if($result){
            return redirect('all_photo')->with('success', 'Photo Gallery Folder Deleted Successfully');
        }else{
            return redirect('all_photo');
        }        
    }

    function edit_photo( $id )
    {   
        $photo = new Photo();
        $data = $photo->get_selected_photo( $id );

        $photofolder = new PhotoFolder();
        $data2 = $photofolder->get_all_photo();
        return view('photo_gallary/edit_photo',['data'=>$data[0] , 'photo'=>$data2]);
    }

    function edit_photo_folder( $id )
    {   
        $photofolder = new PhotoFolder();
        $data = $photofolder->get_selected_photo( $id );
        return view('photo_gallary/edit_photo_folder',['data'=>$data[0]]);
    }

    function edit_photo_data( Request $request )
    {
        $photo = new Photo();
        $id = $request->input('id_photo');
        if((null != $request->file)){
            $fileName = time().'.'.$request->file->extension();
            $request->file->move(public_path('uploads/photo_gallery'), $fileName );
            $result = $photo->edit_photo_data( $request, $id, $fileName );
        }else{
            $result = $photo->edit_photo_data( $request, $id );
        }
        if($result){
            return redirect('all_photo')->with('success', 'Photo Gallery Item Updated Successfully');
        }else{
            return redirect('all_photo');
        }
    }

    function edit_photo_folder_data( Request $request )
    {
        $photo = new PhotoFolder();
        $id = $request->input('id_photo');
        $result = $photo->edit_photo_folder_data( $request, $id );
        if($result){
            return redirect('all_photo')->with('success', 'Photo Gallery Item Updated Successfully');
        }else{
            return redirect('all_photo');
        }
    }
}