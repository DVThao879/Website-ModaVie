<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class AcountController extends Controller
{
    function myAucount(){
        return view('client.show.my_acount');
    }
    public function updateMyAcount(Request $request,$id){
        if($request->hasFile('image')){
            $url=Storage::put('user',$request->file('image'));
        }else{
            $url='';
        }
            DB::table('users')->where('id',$id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'address'=>$request->address,
                'phone'=>$request->phone,
                'image'=>$url,
            ]);
            return redirect()->back()->with('success','Cập nhật thành công');
    }
}
