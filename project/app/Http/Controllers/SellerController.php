<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine_type;
use App\Models\Medicine;
use App\Models\Order_list;
use App\Models\All_user;
use App\Models\Delivary_man_info;


class SellerController extends Controller
{
    public function sellerHomepage(){
        return view('Users.Seller.homepage');
    }

    public function addMedicineType(){
        return view('Users.Seller.addMedicineType');
    }

    public function addMedicineTypeSubmit(Request $req){
        $req->validate(
            [
                'type'=>'required|regex:/^[a-z]+$/',
            ],
            [
                'type.regex'=>'Type can only contain lower case alphabets ',
            ]
        );
        $existing = Medicine_type::where('type', $req->type)->first();
        if ($existing)
            return response()->json(["errorMsg" => "This type already exists"]);
        $type = new Medicine_type();
        $type->type = $req->type;
        if ($type->save())
            return response()->json(["successMsg" => " Type added successfully"]);
        return response()->json(["errorMsg" => "Something went wrong"]);
        
    }

    public function medicineTypeList(){
        $list = Medicine_type::all();
        return response()->json($list);
    }
    public function medicineType(Request $req){
        $type = Medicine_type::where('id', $req->id)->first();
        return response()->json($type);
    }

    public function medicineTypeEdit(Request $req){
        $type = Medicine_type::where('id',$req->id)->first();
        return view('Users.Seller.medicineTypeEdit')->with('types', $type);
    }

    public function medicineTypeEditSubmit(Request $req){
        $req->validate(
            [
                'type'=>'required|regex:/^[a-z]+$/',
            ],
            [
                'type.regex'=>'Type can only contain lower case alphabets ',
            ]
        );
        $existing = Medicine_type::where('type', $req->type)->first();
        if ($existing)
            return response()->json(["errorMsg" => "This type already exists"]);
        $type = new Medicine_type();
        $type->exists = true;
        $type->id = $req->id;
        $type->type = $req->type;
        if ($type->save())
            return response()->json(["successMsg" => " Type edited successfully"]);
        return response()->json(["errorMsg" => "Something went wrong"]);
    }

    public function addMedicine(){
        $type = Medicine_type::all();
        return view('Users.Seller.addMedicine')->with('types', $type);
    }

    public function addMedicineSubmit(Request $req){
        $req->validate(
            [
                'name'=>'required|regex:/^[A-Za-z]+$/',
                'medicineType'=>'required',
                'weight'=>'required|regex:/^[0-9]+$/',
                'unit'=>'required',
                'quantity'=>'required|regex:/^[0-9]+$/',
            ],
            [
                'name.regex'=>'Type can only contain lower case alphabets. ',
                'weight.regex'=>'Weight can only contain numbers. ',
                'quantity.regex'=>'Quantity can only contain numbers.',
            ]
        );
        //return response()->json($req);
        $req->weight = $req->weight.' '.$req->unit;
        $medCheck = Medicine::where('name', $req->name)->where('type', $req->medicineType)->where('weight', $req->weight)->first();
        if($medCheck){
            //return response()->json($req);
            $medCheck->exists = true;
            $medCheck->quantity = $medCheck->quantity + $req->quantity;
            $medCheck->save();
            return response()->json(["successMsg" => "Medicine id =".$medCheck->id." updated successfully"]);
        }
        $med = new Medicine();
        $med->name = $req->name;
        $med->type = $req->medicineType;
        $med->weight = $req->weight;
        $med->quantity = $req->quantity;
        $med->permission = 1;
        if($med->save())
            return response()->json(["successMsg" => "Medicine name =".$med->name." added successfully"]);
        return response()->json(["errorMsg" => "Something went wrong"]);
    }

    public function medicineList(){
        $list = Medicine::where('price_per_piece', '<>', null)->where('permission', 1)->orderByRaw("concat(name, type, weight)")->get();
        return response()->json($list);
    }

    public function pendingOrderList(){
        $newList = Order_list::where('status', 1)->get();
        $data =array();
        foreach($newList as $new){
            //return $new->carts;
            $medicines =array();
            foreach($new->carts as $ca){
                $medicine = [
                    'medicine_id' => $ca->medicines_id,
                    'name' => $ca->medicines->name,
                    'type' => $ca->medicines->medicine_types->type,
                    'weight' => $ca->medicines->weight,
                    'quantity' => $ca->quantity,
                    'price' => $ca->price,
                ];
                $medicines[] = $medicine;
            }
            //return $carts;
            
            $da = [
                'order_id' => $new->order_id,
                'totalPrice' => $new->price,
                'status' => $new->status,
                'username' => $new->username,
                'delivary_username' => $new->delivary_username,
                'medicines' => $medicines,
            ];
            $data[] = $da;
        }
        //return $data;
        return response()->json($data);      
    }

    public function pendingOrderAccept(Request $req){
        $order = Order_list::where('order_id', $req->id)->first();
        //return $order;
        $order->exists = true;
        $order->status = 3;
        $order->seller_username = $req->username;
        $order->accept_reject_at = date('Y-m-d H:i:s');
        if ($order->save())
            return response()->json(["successMsg" => 'Medicine order_id ='.$order->order_id.' accepted successfully']);
        return response()->json(["errorMsg" => "Something went wrong"]);
    }

    public function pendingOrderReject(Request $req){
        $order = Order_list::where('order_id', $req->id)->first();
        //return $order;
        $order->exists = true;
        $order->status = 0;
        $order->seller_username = $req->username;
        $order->accept_reject_at = date('Y-m-d H:i:s');
        if ($order->save())
            return response()->json(["successMsg" => 'Medicine order_id ='.$order->order_id.' rejected successfully']);
        return response()->json(["errorMsg" => "Something went wrong"]);
    }

    public function acceptedOrderList(Request $req){
        $newList = Order_list::where('seller_username', $req->username)->get();
        $data =array();
        foreach($newList as $new){
            $patient = All_user::where('username', $new->username)->first();
            $medicines =array();
            foreach($new->carts as $ca){
                $medicine = [
                    'medicine_id' => $ca->medicines_id,
                    'name' => $ca->medicines->name,
                    'type' => $ca->medicines->medicine_types->type,
                    'weight' => $ca->medicines->weight,
                    'quantity' => $ca->quantity,
                    'price' => $ca->price,
                ];
                $medicines[] = $medicine;
            }
            //return $carts;
            
            $da = [
                'order_id' => $new->order_id,
                'totalPrice' => $new->price,
                'status' => $new->status,
                'orderedAt' => $new->ordered_at,
                'address' => $new->address,
                'username' => $new->username,
                'phone' => $patient->phone,
                'sellerUsername' => $new->seller_username,
                'acceptedRejectedAt' => $new->accept_reject_at,
                'delivary_username' => $new->delivary_username,
                'delivaryAssignedAt' => $new->delivary_assigned_at,
                'delivaryCompletedAt' => $new->delivary_completed_at,
                'productReceivedAt' => $new->product_received_at,
                'paid' => $new->paid,
                'medicines' => $medicines,
            ];
            $data[] = $da;
        }
        return response()->json($data);          
    }

    public function assignDelivaryman(Request $req){
        $req->validate(
            [
                'delivary_username'=>'required',
            ],
            [
                'delivary_username.exists'=>'This delivary man does not exists',
            ]
        );
        $exists = Delivary_man_info::where('username', $req->delivary_username)->first();
        if (!$exists)
            return response()->json(["errorMsg" => 'This delivaryman does not exists.']);
        $order = Order_list::where('order_id', $req->id)->first();
        $order->exists = true;
        $order->status = 5;
        $order->delivary_username = $req->delivary_username;
        $order->delivary_assigned_at = date('Y-m-d H:i:s');
        $order->save();
        return response()->json(["successMsg" => 'Delivary man assigned successsfully']);
    }

    public function delivaryManStatus(Request $req){
        $delivary = Delivary_man_info::where('id', $req->id)->first();
        if($req->status == 'Assign'){
            $delivary->exists = true;
            $delivary->availability = 0;
            $delivary->save();
            return response()->json(["successMsg" => 'Delivary man assigned successfully.']);
        }
        else if($req->status == 'Free'){
            $delivary->exists = true;
            $delivary->availability = 1;
            $delivary->save();
            return response()->json(["successMsg" => 'Delivary man freed successfully.']);
        }
        return response()->json(["errorMsg" => 'Something went wrong.']);

    }

    public function delivarymanList(){
        $list = Delivary_man_info::all();
        return response()->json($list);
    }
}
