<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\ShipmentItemSell;

use Illuminate\Http\Request;

class NoteController extends Controller
{
    
    public function notes() {

        $notes = Note::orderBy('date','ASC')->get()->groupBy('date');

        $dates = $notes;

        $all_notes = Note::all();

        $products = Product::where('is_active', 0)->get();

        $shipments = Shipment::all();

        return view('notes',compact('notes', 'dates', 'products','shipments','all_notes'));
    }


    public function searchNoteValue (Request $request){

        $date_from = $request->date_from;
        $date_to = $request->date_to;

        return redirect()->route('searchNote', [$date_from,$date_to]);

    }


    public function searchNote($date_from , $date_to) {


        $notes = Note::where('date','>=' , $date_from)
        ->where('date','<=' , $date_to)
        ->get()
        ->groupBy('date');

        $dates = $notes;

        $all_notes = Note::where('date','>=' , $date_from)
        ->where('date','<=' , $date_to)
        ->get();

        $products = Product::where('is_active', 0)->get();

        $shipments = Shipment::all();

        return view('search-note',compact('notes', 'dates', 'products','shipments','all_notes'));

    }


    public function addNote(Request $request){

        for ($i=0; $i < count($request->b_name) ; $i++) { 
            $note = new Note();

            $note->date = $request->date;
            $note->product_id = $request->b_name[$i];
            $note->quantity = $request->b_quantity[$i];
            $note->remaining_quantity = $request->b_quantity[$i];

            $note->desc = $request->b_desc[$i];

            $note->user_created = session()->get('name');


            $note->save();
        }

        return redirect()->back()->with('success','تم اضافة ملاحظة بنجاح');


    }

    public function updateNote(Request $request){

        if ($request->quantity < $request->remaining_quantity ) {
            
            return redirect()->back()->with('warning','عذرا الكمية المتبقية اقل من الكمية الاصلية');

        }
        $note =  Note::find($request->id);

        $note->date = $request->date;
        $note->product_id = $request->name;
        $note->quantity = $request->quantity;
        $note->remaining_quantity = $request->remaining_quantity;

        $note->desc = $request->desc;

        $note->save();

        return redirect()->back()->with('success','تم تعديل الملاحظة بنجاح');


    }

    public function sellingFromNote(Request $request){

        $note = Note::find($request->id);


        if ($request->selling_quantity + $request->damaged > $note->remaining_quantity) {
           
            return redirect()->back()->with('warning',' عذراالكمية المباعة ( ' . ($request->selling_quantity + $request->damaged)  .' ) اكثر من الكمية المتبقية في الملاحظة ( ' . $note->remaining_quantity . ' ) '  );

        }


        $shipment = Shipment::find($request->ship_id);


        $item = ShipmentItem::where('shipment_id',$shipment->id)->where('product_id', $note->product_id)->first();

        if (empty($item)) {
           
            return redirect()->back()->with('warning',' عذرا الشحنة رقم ( ' . $shipment->number .' ) لا تحتوي على  البيان ( ' . $note->product->name .' ) ' )  ;

        }

        if ($shipment->date > $request->date) {
           
            return redirect()->back()->with('warning',' عذرا تاريخ إضافة عملية المبيعات قبل تاريخ إنشاء الإرسالية'  );

        }


        $selling = new ShipmentItemSell;

        $selling->user_created = session()->get('name');

        $selling->shipment_item_id = $item->id;
        $selling->client = $request->client;
        $selling->bill_number = $request->bill;
        $selling->date = $request->date;

        $selling->quantity = $request->selling_quantity;

        $selling->damaged = $request->damaged;
        $selling->price = $request->price;
        $selling->date = $request->date;

        $selling->selling = $request->price * $request->selling_quantity;

        
        $selling->remaining_quantity = $item->remaining_quantity - ($request->selling_quantity + $request->damaged) ;

        if ($selling->remaining_quantity < 0 ) {
        
            return redirect()->back()->with('warning','عذرا الكمية المباعة اكثر من الموجودة المتبقي لديك في الشحنة ( ' . $item->remaining_quantity .' )'  );
           
        }

        $selling->save();

        $item->remaining_quantity -= $request->selling_quantity + $request->damaged;
        $item->save();

        $note->remaining_quantity -= $request->selling_quantity + $request->damaged;

        $note->save();


        return redirect()->back()->with('success','تم اضافة عملية بيع بنجاح');


    }

}
