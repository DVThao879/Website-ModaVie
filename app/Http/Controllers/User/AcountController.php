<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AcountController extends Controller
{
    function myAucount(){
        if (Auth::check()) {
            $user = Auth::user();

        $bills = Bill::query()->where('user_id',$user->id)->get();
        // dd($bills);
        // $billIds = $bills->pluck('id');
        // $billDetails = DB::table('bill_details')->whereIn('bill_id', $billIds)->get();
            //  dd($billDetails);
        }else{
            return view('client.show.cart');
        }
        return view('client.show.my_acount',compact('bills'));
    }
    function orderBillDetail($id){
        if (Auth::check()) {
            $user = Auth::user();
            // dd($user);
        }

        $bills = Bill::query()->where('user_id',$user->id)->get();
        
      
           $billIds = $bills->pluck('id');
           $billDetails = BillDetail::whereIn('bill_id', $billIds)->with(['product','productVariant'])->get();
       
   
    //   dd($billDetails);
        return view('client.show.bill_detail',compact('bills','billDetails'));

    }
    public function updateMyAcount(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        if (Auth::check()) {
            $image = Auth::user()->image;
        }
    
        if ($request->hasFile('image')) {
            $url = Storage::put('users', $request->file('image'));
            Storage::delete($image); // Delete old image if exists
        } else {
            $url = $image;
        }
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->image = $url;
   
        if ($request->filled('current_password') || $request->filled('new_password')) {
            $request->validate([
                'current_password' => 'required_with:new_password',
                'new_password' => 'nullable|min:8|confirmed',
            ], [
                'current_password.required_with' => 'Vui lòng nhập mật khẩu hiện tại nếu muốn thay đổi mật khẩu.',
                'new_password.min' => 'Mật khẩu mới phải ít nhất 8 ký tự.',
                'new_password.confirmed' => 'Mật khẩu mới không trùng khớp.',
            ]);
    
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
            }
    
            $user->password = Hash::make($request->new_password);
        }
    
        $user->save();
    
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }
    
}
