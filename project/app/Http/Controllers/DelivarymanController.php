<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order_list;
use App\Models\All_user;

class DelivarymanController extends Controller
{
    //
    public function delivarymanHomepage(){
        return view('Users.Delivaryman.homepage');
    }

    public function acceptedOrderList(Request $req){
        $newList = Order_list::where('delivary_username', $req->username)->get();
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
        //return $data;
        return response()->json($data);            
    }

    public function delivarySuccess(Request $req){
        $order = Order_list::where('order_id', $req->id)->first();
        $order->exists = true;
        $order->status = 7;
        $order->delivary_completed_at = date('Y-m-d H:i:s');
        $order->save();
        return response()->json(["successMsg" => 'Delivary completed successsfully']);
    }

    public function delivaryPaid(Request $req){
        $order = Order_list::where('order_id', $req->id)->first();
        $order->exists = true;
        $order->paid = 'Yes';
        $order->delivary_completed_at = date('Y-m-d H:i:s');
        $order->save();
        return response()->json(["successMsg" => 'Delivary paid successsfully']);
    }
}
