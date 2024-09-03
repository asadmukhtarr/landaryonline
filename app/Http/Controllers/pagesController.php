<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\department;
use App\Models\order;
use App\Models\orderdetail;
use App\Models\User;
use App\Models\role;
use App\Models\permission;
use App\Models\grantpermission;

class pagesController extends Controller
{
    // dashboard ..
    public function dashboard(){
        $orders = order::all();
        $customers = customer::all();
        $departments = department::all();
        $users = User::all();
        return view('admin.dashboard',compact('orders','customers','departments','users'));
    }
    // customer ..
    public function customer(){
        $customers = customer::orderby('id','desc')->get();
        return view('admin.customers.customers',compact('customers'));
    }
    // for save customer ..
    public function save_customer(Request $request){
        // validation ..
        $validated = $request->validate([
            'name' => 'required|max:255',
            'whatsapp' => 'required',
            'email' => 'required|unique:customers',
            'address' => 'required',

        ]);

        // new customer creation ..
        $customer = new customer;
        $customer->name = $request->name;
        $customer->whatsapp = $request->whatsapp;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->save();
        return redirect()->back()->with('success','Customer Addedd Succesfully');
    }
    // customer delete ..
    public function delete_customer($id){
        $customer = customer::find($id);
        $customer->delete();
        return redirect()->back()->with('error','Customer Deleted Succesfully');
    }
    // customer update
    public function update_customer($id, Request $request){
        $validated = $request->validate([
            'name' => 'required|max:255',
            'whatsapp' => 'required',
            'email' => 'required',
            'address' => 'required',

        ]);
        // customer create ..
        $customer = customer::find($id);
        $customer->name = $request->name;
        $customer->whatsapp = $request->whatsapp;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->save();
        return redirect()->back()->with('message','Customer Update Succesfully');
        
    }
    // department
    public function department(){
        $departments = department::orderby('id','desc')->get();
        return view('admin.departments.department',compact('departments'));
    }
    public function department_save(Request $request){
        $validated = $request->validate([
            'name' => 'required|max:255',

        ]);
        $department = new department;
        $department->name = $request->name;
        $department->save();
        return redirect()->back()->with('success','Department Created Successfully');
    }
    public function department_status($id){
        $department = department::find($id);
        if($department->status == 0){
            $department->status = 1;
            $department->save();
            return redirect()->back()->with('error','Department Disable Succesfully');
        } else {
            $department->status = 0;
            $department->save();
            return redirect()->back()->with('success','Department Enable Succesfully');

        }
    }
    // admin.staff
    public function staff(){
        return view('admin.staff.staff');
    }
    // new orders 
    public function new_order(){
        $customers = customer::all();
        $departments = department::where('status',0)->get();
        return view('admin.orders.new',compact('customers','departments'));
    }
    // save order ..
    public function save_order(Request $request){   
        $validated = $request->validate([
            'customer' => 'required',
            'type' => 'required',
            'department' => 'required',
            'ddate' => 'required',

        ]);
        $order = new order;
        $order->customer_id = $request->customer;
        $order->order_type = $request->type;
        $order->delivery_type = $request->delivery_type;
        $order->department_id = $request->department;
        $order->edd = $request->ddate;
        $order->save();
        return redirect(route('order.details',$order->id))->with('success','Order is placed succesfully, please add order details also');

    }
    // order details ..
    public function order_detail($id){
        $order = order::find($id);
        return view('admin.orders.order_details',compact('order'));
    }
    // all orders ..
    public function orders(){
        $orders = order::orderby('id','desc')->get();
        return view('admin.orders.orders',compact('orders'));
    }
    // order details working ..
    public function order_detail_save($id, Request $request){
        $validated = $request->validate([
            'title' => 'required',
            'qty' => 'required',
            'ppp' => 'required',
        ]);   
        // order table for update sum ..
        $order = order::find($id);
        // order details 
        $orderdetail = new orderdetail;
        $orderdetail->order_id = $order->id;
        $orderdetail->name = $request->title;
        $orderdetail->qty = $request->qty;
        $orderdetail->price = $request->ppp;
        $total = $request->qty * $request->ppp;
        $discount = ($total/100) * $request->discount;
        $total = $total - $discount;
        $orderdetail->discount = $request->discount;
        $orderdetail->total = $total;
        $orderdetail->save();
        // end order details ..
        $orderdetail_sum = orderdetail::where('order_id',$order->id)->sum('total');
        $order->total = $orderdetail_sum;
        $order->save();
        // end order table for update sum ..
        return redirect()->back()->with('message','Item Added Into Order #'.$order->id.' Succesfully');

    }
    public function orderdetail($id){
        $orderdetails = orderdetail::find($id);
        // updating order ..
        $order = order::find($orderdetails->order_id);
        $order->total = $order->total - $orderdetails->total;
        $order->save();
        // item delete ..
        $orderdetails->delete();
        return redirect()->back()->with('warning','Item Deleted Successfully');
    }
    // place order ..
    public function place_order($id , Request $request){
        $validated = $request->validate([
            'advance' => 'required',
        ]);   
        $order = order::find($id);
        $remaining = $order->total - $request->advance;
        $order->advance = $request->advance;
        $order->pending = $remaining;
        $order->status = 1;
        $order->save();
        return redirect(route('all.orders'))->with('success','Order Is Placed Succesfully');
    }
    public function delete_order($id){
        $order = order::find($id);
        foreach($order->orderdetails as $item){
            $item->delete();
        }
        $order->delete();
        return redirect()->back()->with('warning','Order Deleted Succesfully');
    }
    // update order 
    public function update_order($id, Request $request){
        $order = order::find($id);
        $order->status = $request->status;
        $order->save();
        return redirect()->back()->with('message','Order Status Updated Succesfully');
    }
    // order department ..
    public function order_department($id){
        $orders = order::where('department_id',$id)->get();
        return view('admin.orders.orders',compact('orders'));
    }
    // all users ..
    public function users(){
        return view('admin.users.users');
    }
    // permissions ...
    public function permissions(){
        $permissions = permission::all();
        return view('admin.users.permissions',compact('permissions'));
    }
    public function permission_save(Request $request){
        $validated = $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'routename' => 'required',
        ]); 
        $permission = new permission;
        $permission->title = $request->title;
        $permission->slug = $request->slug;
        $permission->route_name = $request->routename;
        $permission->save();
        return redirect()->back()->with('success','Route Added Succesfully');
    }
    public function permission_delete($id){ 
        $permission = permission::find($id);
        $permission->delete();
        return redirect()->back()->with('warning','Route Deleted Succesfully');
    }
    public function grantpermission($id){
        $grantedpermission = grantpermission::all();
        $permissions = permission::all();
        $role = role::find($id);
        return view('admin.users.grantpermissions',compact('permissions','role','grantedpermission'));
    }
    public function grantedpermission($id,Request $request){
        $gp = $request->permission_granted;
        $grant_permissoin_table = grantpermission::where('role_id',$id)->get();
        if($grant_permissoin_table->count() > 0){
            foreach($grant_permissoin_table as $gpt){
                $gpt->delete();
            }
        }
        foreach($gp as $granted_permission){
            $grant = new grantpermission;
            $grant->role_id = $id;
            $grant->permission_id = $granted_permission;
            $grant->save();
        }
        return redirect()->back()->with('success','Permission Granted Succesfully');
    }
    // role s..
    public function roles(){
        $roles = role::orderby('id','desc')->get();
        return view('admin.users.roles',compact('roles'));
    }
    // roles ..
    public function role_save(Request $request){
        $validated = $request->validate([
            'title' => 'required|max:255',
        ]);

        $role = new role;
        $role->title = $request->title;
        $role->save();
        return redirect()->back()->with('success','New Role Created Succesfully');
    }
    public function del_role($id){
        $role = role::find($id);
        $role->delete();
        return redirect()->back()->with('warning','Role Deleted Succesfully');
    }
}
