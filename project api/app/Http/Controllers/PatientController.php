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

    public function doctorList(){
        $unreadChat = Chat::where('receiver',session()->get('username'))->where('is_read', 0)->distinct('sender')->pluck('sender');
        $readChat = Chat::where('sender',session()->get('username'))->distinct('receiver')->pluck('receiver');
        //return $readChat->count();
        $info = All_user::where('user_types_id', 2)->where('is_verified', 1)->get();
        //return $info;
        return view('Users.Patient.doctorList')->with('infoAll', $info)->with('unreadChat', $unreadChat)->with('readChat', $readChat);
    }

    public function medicineAddToCart(Request $req){
        if($req->quantity != 0){
            $checkCart = Cart::where('username', session()->get('username'))->where('medicines_id', $req->id)->where('ordered', 0)->first();
            $medicine = Medicine::where('id', $req->id)->first();
            if($checkCart){
                $checkCart->exists = true;
                $checkCart->quantity = $checkCart->quantity + $req->quantity;
                $checkCart->price = $checkCart->price + ($req->quantity * $medicine->price_per_piece);
                $checkCart->save();
                return redirect()->back()->with(session()->flash('alert-success', 'In your cart medicine id = '.$checkCart->id.' updated successfully'));
            }
            else{
                $cartAdd = new Cart();
                $cartAdd->username = session()->get('username');
                $cartAdd->medicines_id = $req->id;
                $cartAdd->quantity = $req->quantity;
                $cartAdd->price = $req->quantity * $medicine->price_per_piece;
                $cartAdd->save(); 
                return redirect()->back()->with(session()->flash('alert-success', 'In your cart medicine id = '.$req->id.' addded successfully'));
            }
        }
        return redirect()->back()->with(session()->flash('alert-danger', 'Quantity can not be 0'));
    }

    public function myCart(){
        $cart = Cart::where('username', session()->get('username'))->where('ordered', 0)->get();
        //return $cart;
        return view('Users.Patient.myCart')->with('cart', $cart);
    }

    public function myCartDelete(Request $req){
        $cart = Cart::where('id', $req->id)->delete();
        if($cart)
            return redirect()->back()->with(session()->flash('alert-danger', 'Cart deleted successfully'));

        return redirect()->back()->with(session()->flash('alert-danger', 'Cart not found'));
    }

    public function myCartConfirmOrder(){
        $carts = Cart::where('username', session()->get('username'))->where('ordered', 0)->get();
        $totalPrice = 0;
        $delivaryCost = 15;
        if($carts){
            foreach($carts as $cart){
                //return $cart->medicines->id;
                $medicine = Medicine::where('id', $cart->medicines->id)->first();
                if($medicine->quantity < $cart->quantity)
                    return redirect()->back()->with(session()->flash('alert-danger', 'Medicine id ='.$medicine->id.' is out of stock.'));
                $totalPrice = $totalPrice + $cart->price;
                //return $cart->quantity;
            }
            $patient = All_user::where('username', session()->get('username'))->first();
            $order = new Order_List();
            $order->order_id = time() . session()->get('username');
            $order->price = $totalPrice + $delivaryCost;
            $order->status = 1;
            $order->username = session()->get('username');
            $order->address = $patient->address;
            $order->ordered_at = date('Y-m-d H:i:s');
            if($order->save()){
                $cartUpdate = Cart::where('username', session()->get('username'))->where('ordered', 0)->update(['ordered' => 1, 'order_id' => $order->order_id]);
            }
            //return $totalPrice;
            return redirect()->back()->with(session()->flash('alert-danger', 'Order pending'));
        }
        return redirect()->back()->with(session()->flash('alert-danger', 'Order not successful'));
    }

    public function myOrderList(){
        $newList = Order_list::where('username', session()->get('username'))->get();
        $patient = All_user::where('username', session()->get('username'))->first();
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
        return view('Users.Patient.myOrderList')->with('data', $data);      
    }

    public function productReceived(Request $req){
        $order = Order_list::where('order_id', $req->id)->first();
        $order->exists = true;
        $order->status = 9;
        $order->product_received_at = date('Y-m-d H:i:s');
        $order->save();
        return redirect()->back()->with(session()->flash('alert-success', 'Delivary completed successsfully'));
    }

   
}
