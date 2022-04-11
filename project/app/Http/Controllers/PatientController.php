<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\All_user;
use App\Models\Chat;
use App\Models\Cart;
use App\Models\Medicine;
use App\Models\Order_list;


class PatientController extends Controller
{
    public function patientHomepage(){
        return view('Users.Patient.homepage');
    }

    public function doctorList(Request $req){
        $unreadChatUname = Chat::where('receiver', $req->username)->where('is_read', 0)->distinct('sender')->pluck('sender');
        $readChatUname = Chat::where('sender', $req->username)->distinct('receiver')->pluck('receiver');
        $allChat = All_user::where('user_types_id', 2)->where('is_verified', 1)->get();
        $unreadChat = array();
        $readChat = array();
        foreach ($unreadChatUname as $uc){
            //return response()->json($uc);
            $doctorUnread = All_user::where('username', $uc)->first();
            //return response()->json($doctorUnread);
            $unreadChat[] = $doctorUnread;
        }

        foreach ($readChatUname as $rc){
            //return response()->json($uc);
            $doctorRead = All_user::where('username', $rc)->first();
            //return response()->json($doctorUnread);
            $readChat[] = $doctorRead;
        }

        //return response()->json($readChat);

        $doctors = [
            'unreadChat' => $unreadChat,
            'readChat' => $readChat,
            'allChat' => $allChat,
        ];
        return response()->json($doctors);
    }

    public function medicineAddToCart(Request $req){
        if($req->quantity != 0){
            $checkCart = Cart::where('username', $req->username)->where('medicines_id', $req->id)->where('ordered', 0)->first();
            $medicine = Medicine::where('id', $req->id)->first();
            if($checkCart){
                $checkCart->exists = true;
                $checkCart->quantity = $checkCart->quantity + $req->quantity;
                $checkCart->price = $checkCart->price + ($req->quantity * $medicine->price_per_piece);
                $checkCart->save();
                return response()->json(["successMsg" => 'In your cart medicine id = '.$checkCart->id.' updated successfully']);
            }
            else{
                $cartAdd = new Cart();
                $cartAdd->username = $req->username;
                $cartAdd->medicines_id = $req->id;
                $cartAdd->quantity = $req->quantity;
                $cartAdd->price = $req->quantity * $medicine->price_per_piece;
                $cartAdd->save(); 
                return response()->json(["successMsg" => 'In your cart medicine id = '.$req->id.' addded successfully']);
            }
        }
        return response()->json(["errorMsg" => "Quantity can not be 0"]);
    }

    public function myCart(Request $req){
        $cart = Cart::where('username', $req->username)->where('ordered', 0)->get();
        return response()->json($cart);
    }

    public function myCartDelete(Request $req){
        $cart = Cart::where('id', $req->id)->delete();
        if($cart)
            return response()->json(["successMsg" => 'Cart deleted successfully']);

        return response()->json(["errorMsg" => "Cart not found"]);
    }

    public function myCartConfirmOrder(Request $req){
        $carts = Cart::where('username', $req->username)->where('ordered', 0)->get();
        $totalPrice = 0;
        $delivaryCost = 15;
        if(count($carts) != 0){
            foreach($carts as $cart){
                $medicine = Medicine::where('id', $cart->medicines->id)->first();
                if($medicine->quantity < $cart->quantity)
                    return response()->json(["errorMsg" => 'Medicine id ='.$medicine->id.' is out of stock.']);
                $totalPrice = $totalPrice + $cart->price;
            }
            $patient = All_user::where('username', $req->username)->first();
            $order = new Order_List();
            $order->order_id = time() . $req->username;
            $order->price = $totalPrice + $delivaryCost;
            $order->status = 1;
            $order->username = $req->username;
            $order->address = $patient->address;
            $order->ordered_at = date('Y-m-d H:i:s');
            if($order->save()){
                $cartUpdate = Cart::where('username', $req->username)->where('ordered', 0)->update(['ordered' => 1, 'order_id' => $order->order_id]);
                return response()->json(["successMsg" => 'Your order is pending.']);
            }
        }
        return response()->json(["errorMsg" => 'There is nothing in your cart to order.']);
    }

    public function myOrderList(Request $req){
        $newList = Order_list::where('username', $req->username)->get();
        $patient = All_user::where('username', $req->username)->first();
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

    public function productReceived(Request $req){
        $order = Order_list::where('order_id', $req->id)->first();
        $order->exists = true;
        $order->status = 9;
        $order->product_received_at = date('Y-m-d H:i:s');
        $order->save();
        return response()->json(["successMsg" => 'Delivary order received successsfully']);
    }

   
}
