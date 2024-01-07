<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\ShipmentItemSell;
use App\Models\OtherTransaction;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Note;
use App\Models\ClientTransaction;
use App\Models\DailySellItem;







use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    //


    public function dashboard() {
        
        $shipments = Shipment::all();
        $daily_sells = DailySellItem::all();

        $income = ClientTransaction::where('type','له')->sum('price');
        $outcome = ClientTransaction::where('type','عليه')->sum('price');

        $notes = Note::all();


        return view('dashboard', compact('shipments', 'daily_sells', 'income' , 'outcome'));
    }



    public function products() {

        $products = Product::all();

        return view('products',compact('products'));
    }

    public function addProduct(Request $request) {

        $check_product = Product::where('name', $request->name)->first();

        if (empty($check_product)) {
            
            $product = new Product ();

            $product->name = $request->name;
    
            $product->user_created = session()->get('name');
    
            $product->save();
    
            return redirect()->back()->with('success','تم اضافة بيان بنجاح');

        }else{

            return redirect()->back()->with('warning','عذرا هذا البيان موجود');

        }
       

    }

    public function updateProduct(Request $request) {

        $product =  Product::find($request->id);

        $product->name = $request->name;

        $product->save();

        return redirect()->back()->with('success','تم تعديل بيان بنجاح');

    }

    public function hideProduct($id){

        $product =  Product::find($id);

        $product->is_active = !($product->is_active);

        $product->save();

        return redirect()->back()->with('success','تم إخفاء بيان بنجاح');

    }


    public function deleteProduct($id){

        $check_product =  ShipmentItem::where('product_id',$id)->get();


        if($check_product->count() > 0 ){

            return redirect()->back()->with('warning','عذرا هذا البيان مستخدم ضمن إرسالية');

        }

        $product =  Product::find($id);

        $product->delete();

       
        return redirect()->back()->with('success','تم حذف البيان بنجاح');

    }



    
    


    public function shipments() {

        $shipments = Shipment::Paginate(15);

        $items = ShipmentItem::all();

        $sells = ShipmentItemSell::all();


        $products = Product::where('is_active', 0)->get();

        return view('shipments',compact('shipments', 'products','items', 'sells'));
    }

    public function searchShipmentValue (Request $request){

        $number = $request->number;

        return redirect()->route('searchShipment', $number);

    }


    public function searchShipment($number) {


        $shipments = Shipment::where('number',$number)->get();

        $shipment = Shipment::where('number',$number)->first();

        if (empty($shipment)) {

            return redirect()->back()->with('warning','لا توجد إرسالية بهذا الرقم');
            
        }


        $items_ids = [];
        $sells_ids = [];


        foreach ($shipment->shipmentItmes as $item) {
           $items_ids [] = $item->id;

           foreach ($item->itemSells as $sell) {
            $sells_ids [] = $sell->id;
         }

        }

        $items = ShipmentItem::whereIn('id' ,$items_ids )->get();

        $sells = ShipmentItemSell::whereIn('id' ,$sells_ids )->get();

        $products = Product::where('is_active', 0)->get();

        return view('search-shipment',compact('shipments', 'products','items', 'sells'));
    }

    public function addShipment(Request $request)
    {
        $dub_items = '';
        $check_shipments = Shipment::where('number', $request->number)->first();

        if (!empty($check_shipments)) {

            return redirect()->back()->with('warning','عذرا رقم الإرسالية ( ' . $request->number .' ) مستخدم من قبل');

        }

        $shipment = new Shipment();
        $shipment->number = $request->number;
        $shipment->supplier = $request->supplier;
        $shipment->date = $request->date;

        $shipment->user_created = session()->get('name');

        $shipment->save();

        $get_sa = Currency::where('name', 'sar')->first();

        $sa = $get_sa->price;

        for ($i=0; $i < count($request->b_name) ; $i++) { 


            if ( $request->b_price[$i] > 0 && $request->sar_price[$i] > 0) {
            
           
                return redirect()->back()->with('warning','عذرا اختر قيمة واحدة و الأخرى بصفر');
    
            }



        $check_item = ShipmentItem::where('shipment_id',$shipment->id)
        ->where('product_id',$request->b_name[$i])
        ->first();

        if (empty($check_item)) {

            $item = new ShipmentItem();
            
            $item->shipment_id = $shipment->id;
            $item->product_id = $request->b_name[$i];
            $item->quantity = $request->b_quantity[$i];
            $item->remaining_quantity = $request->b_quantity[$i];

        


            if ($request->b_price[$i] > 0 ) {
                
                $item->invoice_price = $request->b_price[$i];
                $item->invoice_total = $request->b_quantity[$i] * $request->b_price[$i];
                

                $item->invoice_price_sa = $request->b_price[$i] * $sa;

            }else{

                $item->invoice_price = $request->sar_price[$i];
                $item->invoice_total = $request->b_quantity[$i] * $request->sar_price[$i];
                

                $item->invoice_price_sa = $request->sar_price[$i];

            }
        
            $item->invoice_total_sa = $request->b_quantity[$i] * $item->invoice_price_sa;


            $item->total = $item->invoice_total_sa;

            $item->save();

         }else{
            $dub_items = '( لا يمكن تكرار البيان لنفس الإرسالية )';
        }


        }

        return redirect()->back()->with('success',' تم اضافة إرسالية بنجاح '  . $dub_items );

    }


    public function addProductShipment (Request $request){


        $dub_items = '';
        $get_sa = Currency::where('name', 'sar')->first();

        $sa = $get_sa->price;

        for ($i=0; $i < count($request->b_name) ; $i++) { 


            if ( $request->b_price[$i] > 0 && $request->sar_price[$i] > 0) {
            
           
                return redirect()->back()->with('warning','عذرا اختر قيمة واحدة و الأخرى بصفر');
    
            }



        $check_item = ShipmentItem::where('shipment_id',$request->id)
        ->where('product_id',$request->b_name[$i])
        ->first();

        if (empty($check_item)) {

            $item = new ShipmentItem();
            
            $item->shipment_id = $request->id;
            $item->product_id = $request->b_name[$i];
            $item->quantity = $request->b_quantity[$i];
            $item->remaining_quantity = $request->b_quantity[$i];

        


            if ($request->b_price[$i] > 0 ) {
                
                $item->invoice_price = $request->b_price[$i];
                $item->invoice_total = $request->b_quantity[$i] * $request->b_price[$i];
                

                $item->invoice_price_sa = $request->b_price[$i] * $sa;

            }else{

                $item->invoice_price = $request->sar_price[$i];
                $item->invoice_total = $request->b_quantity[$i] * $request->sar_price[$i];
                

                $item->invoice_price_sa = $request->sar_price[$i];

            }
        
            $item->invoice_total_sa = $request->b_quantity[$i] * $item->invoice_price_sa;


            $item->total = $item->invoice_total_sa;

            $item->save();

         }else{
             $dub_items = '( لا يمكن تكرار البيان لنفس الإرسالية )';
         }


        }


        return redirect()->back()->with('success',' تم اضافة بيان جديد للإرسالية بنجاح ' . $dub_items);


    }


    public function deleteShipmentProduct(Request $request){

        $item = ShipmentItem::find($request->id);

        $daily_sells = [];

        foreach ($item->itemSells as $sell) {
           
            if ($sell->daily_sell_item_id != null) {
                
                $daily_sells [] = $sell->daily_sell_item_id;

            }
        }

        if (count($daily_sells) > 0 ) {
            
           foreach ($daily_sells as $id) {
               $daily = DailySellItem::find($id);

               $daily->delete();
           }
        }

        $item->delete();

        return redirect()->back()->with('success','تم حذف البيان بنجاح');


    }

    public function updateShipment(Request $request)
    {
        $shipment =  Shipment::find($request->id);
        $shipment->number = $request->number;
        $shipment->supplier = $request->supplier;
        $shipment->date = $request->date;

        $shipment->save();

      

        return redirect()->back()->with('success','تم اضافة إرسالية بنجاح');

    }


    public function updateItem(Request $request)
    {

        
        if ( $request->quantity < $request->remaining_quantity) {
            
           
            return redirect()->back()->with('warning','عذرا الكمية المتبقية اكثر من الكمية الكلية');

        }


        $item =  ShipmentItem::find($request->id);

        $get_sa = Currency::where('name', 'sar')->first();

        $sa = $get_sa->price;

        $item->product_id = $request->name;
        $item->quantity = $request->quantity;
        $item->remaining_quantity = $request->remaining_quantity;

        if ( $item->invoice_price !=  $item->invoice_price_sa) {
    
            $item->invoice_price_sa = $request->price * $sa;

        }else{

            $item->invoice_price_sa = $request->price ;

        }


        $item->invoice_price = $request->price;
        $item->invoice_total = $request->price * $request->quantity;       
       
        $item->invoice_total_sa = $request->quantity * $item->invoice_price_sa;

        $item->total = $item->invoice_total_sa;

        $item->save();
      

        return redirect()->back()->with('success','تم تعديل البيان بنجاح');

    }

    public function deleteShipment(Request $request){

        $shipment = Shipment::find($request->id);

        $shipment->delete();

        return redirect()->back()->with('success','تم حذف الإرسالية بنجاح');

    }

    public function sellShipment(Request $request){

        $item = ShipmentItem::find($request->id);

       
        if ($item->shipment->date > $request->date) {
           
            return redirect()->back()->with('warning',' عذرا تاريخ إضافة عملية المبيعات قبل تاريخ إنشاء الإرسالية'  );

        }


        $selling = new ShipmentItemSell;

        $selling->user_created = session()->get('name');

        $selling->shipment_item_id = $request->id;
        $selling->client = $request->client;
        $selling->bill_number = $request->bill;
        $selling->date = $request->date;

        $selling->quantity = $request->selling_quantity;

        $selling->damaged = $request->damaged;
        $selling->price = $request->price;

        $selling->selling = $request->price * $request->selling_quantity;


        $selling->remaining_quantity = $item->remaining_quantity - ($request->selling_quantity + $request->damaged) ;

        if ($selling->remaining_quantity < 0 ) {
        
            return redirect()->back()->with('warning','عذرا الكمية المباعة اكثر من الكمية المتبيقة في الشحنة  ( ' . $item->remaining_quantity .' )'  );
           
        }

         $selling->save();

        $item->remaining_quantity -= $request->selling_quantity + $request->damaged;
        $item->save();

        return redirect()->back()->with('success','تم اضافة عملية بيع بنجاح');


    }


    public function UpdateSell(Request $request){

        $selling =  ShipmentItemSell::find($request->id);

        $item = ShipmentItem::find($selling->shipment_item_id);

       
        if ($item->shipment->date > $request->date) {
           
            return redirect()->back()->with('warning',' عذرا تاريخ إضافة عملية المبيعات قبل تاريخ إنشاء الإرسالية'  );

        }

        $selling->client = $request->client;
        $selling->bill_number = $request->bill;
        $selling->date = $request->date;

        $selling->quantity = $request->selling_quantity;

        $selling->damaged = $request->damaged;
        $selling->price = $request->price;
        $selling->date = $request->date;

        $selling->selling = $request->price * $request->selling_quantity;


        $all_selling = ShipmentItemSell::where('shipment_item_id', $item->id)->where('id', '!=', $request->id)->sum('quantity');
        $all_damaged = ShipmentItemSell::where('shipment_item_id', $item->id)->where('id', '!=', $request->id)->sum('damaged');


        $selling->remaining_quantity = $item->quantity - ($all_selling + $all_damaged + $request->selling_quantity + $request->damaged);

        if ($selling->remaining_quantity < 0 ) {
        
            return redirect()->back()->with('warning','عذرا الكمية المباعة اكثر من المتبقية في الشحنة  ( ' . $item->remaining_quantity .' )'  );
           
        }

        $selling->save();

        $item->remaining_quantity =  $item->quantity - ($all_selling + $all_damaged + $request->selling_quantity + $request->damaged);

        $item->save();

        return redirect()->back()->with('success','تم تعديل عملية البيع بنجاح');


    }

    public function deleteSell(Request $request){

        $sell = ShipmentItemSell::find($request->id);

        if ($sell->daily_sell_item_id != null) {
           
            $daily_sell_item = DailySellItem::find($sell->daily_sell_item_id);
            $daily_sell_item->delete();
        }

        $item = ShipmentItem::find($sell->shipment_item_id);

        $item->remaining_quantity += $sell->quantity + $sell->damaged;

        $item->save();

        $sell->delete();

        return redirect()->back()->with('success','تم حذف عملية البيع بنجاح');


        
    }



    public function addExpenses(Request $request){

        $expenses = new OtherTransaction;

        $expenses->shipment_id = $request->id;

        $customs_price = $request->customs; 

        $others_price = $request->others; 

        $delivery_price = $request->delivery; 
        
        $jordan_price = $request->jordan; 

        $expenses->customs_price = $customs_price;
        $expenses->others_price = $others_price;

        $expenses->delivery_price = $delivery_price;
        $expenses->jordan_price = $jordan_price;

        $expenses->desc = $request->desc;

        $expenses->user_created = session()->get('name');


        $expenses->save();

        return redirect()->back()->with('success','تم اضافة منمصرفات بنجاح');


    }


    public function expReport(){

        return view('exp-report');
       
    }



    public function expensesReport(Request $request){


        if ($request->type == 'by_date') {
            
            $shipments = Shipment::where('date', '>=' , $request->date_from)
            ->where('date', '<=' , $request->date_to)
            ->get();

            $filter = 'من تاريخ ( ' . $request->date_from  . ' )  الى تاريخ  ( ' . $request->date_to   .' )  ';

        }else{

            $shipments = Shipment::where('number', '>=' , $request->number_from)
            ->where('number', '<=' , $request->number_to)
            ->get();

            $filter = 'من الشحنة رقم ( ' . $request->number_from  . ' )  الى الشحنة رقم  ( ' . $request->number_to   .' )  ';

        }
        

        return view('expenses-report', compact ('shipments' , 'filter') );


    }

   




    public function currency (){

        $currency = Currency::find(1);

        $price = $currency->price;

        return view('currency', compact('price'));
    }

    public function updateCurrency(Request $request){

        $currency = Currency::find(1);

        $currency->price = $request->price;

        $currency->save();

        return redirect()->back()->with('success','تم تعديل سعر الريال مقابل الدينار بنجاح');

    }
}
