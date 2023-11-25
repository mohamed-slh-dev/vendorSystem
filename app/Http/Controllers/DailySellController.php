<?php

namespace App\Http\Controllers;

use App\Models\Product;

use App\Models\DailySell;
use App\Models\DailySellItem;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\ShipmentItemSell;

use Illuminate\Http\Request;

class DailySellController extends Controller
{
    //

    public function dailySells(){
       
        $daily_sells = DailySell::orderBy('date','ASC')->Paginate(15);

        $products = Product::where('is_active', 0)->get();

        $shipments = Shipment::all();

        foreach ($daily_sells as $value) {
            
            if (count($value->dailySellItmes) == 0 ) {
  
                $daily = DailySell::find($value->id);
                
                $daily->delete();

            }
           
        }

        return view('daily-sells',compact('daily_sells', 'products','shipments'));

    }


    public function searchDailyValue (Request $request){

        $date_from = $request->date_from;
        $date_to = $request->date_to;

        return redirect()->route('searchDaily', [$date_from,$date_to]);

    }


    public function searchDaily($date_from , $date_to) {


        $daily_sells = DailySell::where('date','>=' , $date_from)
        ->where('date','<=' , $date_to)
        ->orderBy('date','ASC')
        ->get();

        $products = Product::where('is_active', 0)->get();

        $shipments = Shipment::all();

        return view('search-daily-sells',compact('daily_sells', 'shipments', 'products'));

    }


    public function addDailySell (Request $request){

        $flag = false;
        $err_msg = "";


        if ($request->type == 'new') {
           
            $daily_sell = new DailySell();

            $daily_sell->date = $request->date;
            $daily_sell->client = $request->client;
            $daily_sell->bill_number = $request->bill_number;
            $daily_sell->desc = $request->desc;
    
            $daily_sell->user_created = session()->get('name');
    
            $daily_sell->save();

            $selling_date = $request->date;


        } else {
            
            $daily_sell = DailySell::find($request->id);
            $selling_date = $daily_sell->date;

        }
        
       


        for ($i=0; $i < count($request->b_name) ; $i++) { 

            $ship = Shipment::find($request->ship_id[$i]);

            $item = ShipmentItem::where('shipment_id', $ship->id)
            ->where('product_id', $request->b_name[$i])
            ->first();

            $product = Product::find($request->b_name[$i]);

            if (empty($item)) {
                
                $flag = true;

                $err_msg .= 'عذرا البيان ( ' . $product->name  . ' ) لا يوجد في الشحنة رقم  ( ' . $ship->number  . ' )  | ' ;

            }//end of empty($item)
             else {

                if ($request->selling_quantity[$i] + $request->damaged[$i] >  $item->remaining_quantity ) {
                    
                    $flag = true;

                    $err_msg .= 'عذرا الكمية المباعة في الشحنة  ( ' . $ship->number  .' ) من  ( ' . $item->product->name  .' ) اكثر من المتبقية في الشحنة لديك ( ' . $item->remaining_quantity .' )  |  ';

                }//end of check remaining_quantity
                 else {
                   
                    if ($item->shipment->date > $selling_date) {
                        
                        $flag = true;

                        $err_msg .= ' عذرا تاريخ إضافة عملية المبيعات' . $selling_date  .' قبل تاريخ إنشاء الإرسالية ' . $item->shipment->date  .' ';

                    } else {
                        


                        $daily_sell_item = new DailySellItem ();
    
                        $daily_sell_item->daily_sell_id =  $daily_sell->id;
                        $daily_sell_item->shipment_id =  $ship->id;
                        $daily_sell_item->product_id =  $request->b_name[$i];
                        $daily_sell_item->quantity = $request->selling_quantity[$i];
                        $daily_sell_item->damaged =  $request->damaged[$i];
                        $daily_sell_item->price =  $request->price[$i];
    
                        $daily_sell_item->save();


                        $selling = new ShipmentItemSell;

                        $selling->user_created = session()->get('name');
                
                        $selling->shipment_item_id =$item->id;
                        $selling->client = $request->client;
                        $selling->bill_number = $request->bill_number;
                        $selling->date = $selling_date;
                
                        $selling->quantity = $request->selling_quantity[$i];
                
                        $selling->damaged = $request->damaged[$i];
                        $selling->price = $request->price[$i];
                
                        $selling->daily_sell_item_id = $daily_sell_item->id;

                        $selling->selling = $request->price[$i] * $request->selling_quantity[$i];
                
                
                        $selling->remaining_quantity = $item->remaining_quantity - ($request->selling_quantity[$i] + $request->damaged[$i]) ;
    
                        $selling->save();
    
                        $item->remaining_quantity -= $request->selling_quantity[$i] + $request->damaged[$i];
                        $item->save();
    
                       


                    }//end of else date check
  
                }
                
            }//end of else remaining check
            
        }//end of for loop

        if ($flag == true) {
           
            return redirect()->back()->with('warning', $err_msg );

        } else {
            
            return redirect()->back()->with('success','تم اضافة عملية بيع بنجاح');

        }
        
    }


    public function editDailySell(Request $request){

        $flag = false;
        $err_msg = "";

        $daily_sell = DailySell::find($request->daily_sell_id);
        $selling_date = $daily_sell->date;


        //begin of for loop
        for ($i=0; $i < count($request->b_name) ; $i++) { 

            $ship = Shipment::find($request->ship_id[$i]);

            $item = ShipmentItem::where('shipment_id', $ship->id)
            ->where('product_id', $request->b_name[$i])
            ->first();

            $daily_sell_item = DailySellItem::find($request->id[$i]);

            $item->remaining_quantity += $daily_sell_item->quantity + $daily_sell_item->damaged;


            $product = Product::find($request->b_name[$i]);

            if (empty($item)) {
                
                $flag = true;

                $err_msg .= 'عذرا البيان ( ' . $product->name  . ' ) لا يوجد في الشحنة رقم  ( ' . $ship->number  . ' )  | ' ;

            }//end of empty($item)
             else {

                //dd($request->id[$i]);

                if ($request->selling_quantity[$i] + $request->damaged[$i] >  $item->remaining_quantity ) {
                    


                    $flag = true;

                    $err_msg .= 'عذرا الكمية المباعة في الشحنة  ( ' . $ship->number  .' ) من  ( ' . $item->product->name  .' ) اكثر من المتبقية في الشحنة لديك ( ' . $item->remaining_quantity .' )  |  ';

                }//end of check remaining_quantity
                 else {
                   
                    if ($item->shipment->date > $selling_date) {
                        
                        $flag = true;

                        $err_msg .= ' عذرا تاريخ إضافة عملية المبيعات' . $selling_date  .' قبل تاريخ إنشاء الإرسالية ' . $item->shipment->date  .' ';

                    } else {
                        
    
                        $selling = ShipmentItemSell::where('daily_sell_item_id', '=' , $daily_sell_item->id)->first();
                       

                        if (!empty($selling)) {
                            

                            $daily_sell_item->shipment_id =  $ship->id;
                            $daily_sell_item->product_id =  $request->b_name[$i];
                            $daily_sell_item->quantity = $request->selling_quantity[$i];
                            $daily_sell_item->damaged =  $request->damaged[$i];
                            $daily_sell_item->price =  $request->price[$i];
        
                            $daily_sell_item->save();
                            
                            $selling->user_created = session()->get('name');
                
                            $selling->shipment_item_id =$item->id;
                            $selling->client = $request->client;
                            $selling->bill_number = $request->bill_number;
                            $selling->date = $selling_date;
                    
                            $selling->quantity = $request->selling_quantity[$i];
                    
                            $selling->damaged = $request->damaged[$i];
                            $selling->price = $request->price[$i];
                    
                            $selling->selling = $request->price[$i] * $request->selling_quantity[$i];
                    
                    
                            $selling->remaining_quantity = $item->remaining_quantity - ($request->selling_quantity[$i] + $request->damaged[$i]) ;
        
                            $selling->save();
        
                            $item->remaining_quantity -= $request->selling_quantity[$i] + $request->damaged[$i];
                            $item->save();

                        }
                       

                    }//end of else date check
  
                }
                
            }//end of else remaining check
            
        }//end of for loop


        if ($flag == true) {
           
            return redirect()->back()->with('warning', $err_msg );

        } else {
            
            return redirect()->back()->with('success','تم تعديل عملية المبيعات بنجاح');

        }



    }//end of edit dailySell function


    public function deleteDailySell($id){

        $daily_item = DailySellItem::find($id);

        
        $sell_item = ShipmentItemSell::where('daily_sell_item_id', $id)->first();

        $shipment_item = ShipmentItem::find($sell_item->shipment_item_id);

        $shipment_item->remaining_quantity += $daily_item->quantity;
        $shipment_item->remaining_quantity += $daily_item->damaged;

        $shipment_item->save();


        $sell_item->delete();

        $daily_item->delete();


        return redirect()->back()->with('success','تم حذف المبيعات اليومية بنجاح');


    }//end of deleteDailySell function
}
