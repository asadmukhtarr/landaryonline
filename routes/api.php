<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\order;
use App\Models\orderdetail;
use App\Models\customer;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/customers',function(){
    $customers = App\Models\customer::orderby('id','desc')->get();
    return response()->json($customers);
});
// fetch customer ..
Route::get('customer/{id}',function($id){
    $customer = App\Models\customer::find($id);
    return response()->json($customer);
});
Route::get('departments',function(){
    $departments = App\Models\department::all();
    return response()->json($departments);
});
Route::delete('/customer/{id}',function($id){
    $customer = customer::find($id);
    $customer->delete();
    $data = [
        'message' => 'customer has been deleted succesfully',
        'status' => 200
    ];
    return response()->json($data);
});

Route::post('/save/customer',function(Request $request){
    $customer = new customer;
    $customer->name = $request->name;
    $customer->email = $request->email;
    $customer->whatsapp = $request->whatsapp;
    $customer->address = $request->city;
    $customer->save();
    $data = [
        'status' => 200,
        'message' => 'Customer Created Succesfully'
    ];
    return response()->json($data);
});
Route::post('/place/order',function(Request $request){
    // return $request;
    $order = new order;
    $order->customer_id = $request->scustomer;
    $order->order_type = $request->ordertpye;
    $order->delivery_type = $request->deliverytpye;
    $order->department_id = $request->sdepartment;
    $order->edd = $request->selecteddate;
    $order->save();
    $placeroder = order::find($order->id);
    $data = [
        'status' => 200,
        'message' => 'Order placed Succesfully',
        'data' => $placeroder
    ];
    return response()->json($data);
});
Route::post('place/order/details/{id}',function($id, Request $request){
    $order = order::find($id);
   // return $order;
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
    $orderdetails = orderdetail::where('order_id',$order->id)->get();
    $order->total = $orderdetail_sum;
    $order->save();
    // end order table for update sum ..
   $data = [
        'status' => 200,
        'message' => 'Item is saved against order #'.$order->id,
        'orderdetail' => $orderdetails,
        'order' => $order
   ];
   return response()->json($data);

});
Route::post('/place/order/item/{id}',function(Request $request){
    return $request; 
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

});
// order place ..
Route::post("/place/final/{id}",function($id,Request $request){
    $order = order::find($id);
    $remaining = $order->total - $request->advancemoney;
    $order->advance = $request->advancemoney;
    $order->pending = $remaining;
    $order->status = 1;
    $order->save();
    $data = [
        'status' => 200,
        'message' => "Your Order Is Placed Succesfully Aginst #".$order->id 
    ];
    return response()->json($data);
});
// place order ..
Route::get('/orders',function(){
    $orders = App\Models\order::orderby('id','desc')->get();
    return response()->json($orders);
});