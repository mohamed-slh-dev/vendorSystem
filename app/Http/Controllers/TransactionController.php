<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientTransaction;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //

    public function transactions (){

        $clients = Client::all();

        $transactions = ClientTransaction::all();

        $income = ClientTransaction::where('type','له')->sum('price');
        $outcome = ClientTransaction::where('type','عليه')->sum('price');

        return view('transactions', compact('clients','transactions', 'income', 'outcome'));
    }

    public function addClient (Request $request){

        $client = new Client ();

        $client->name = $request->name;
        $client->phone = $request->phone;

        $client->type = $request->client_type;

        $client->total = 0;

        $client->save();

        $trans = new ClientTransaction();

        $trans->client_id = $client->id;

        $price = preg_replace('/[,]/', '', $request->price);
        $price = (int)$price;

        $trans->price = $price;



        $trans->desc = $request->desc;
        $trans->type = $request->trans_type;
        $trans->date = $request->date;

        if ($request->trans_type == 'عليه') {

            $client->total += $price;

        }else{

            $client->total -= $price;

        }


        $client->save();

        $trans->save();

        return redirect()->back()->with('success', 'تم إضافة عميل جديد بنجاح');



    }

    public function updateClient(Request $request){

        $client = Client::find($request->id);

        $client->name = $request->name;
        $client->phone = $request->phone;

        $client->type = $request->client_type;

        $client->save();

        return redirect()->back()->with('success', 'تم تعديل العميل بنجاح');

    }

    public function addTransaction(Request $request){


        $client = client::find($request->id);

        $trans = new ClientTransaction();

        $trans->client_id = $request->id;


        $price = preg_replace('/[,]/', '', $request->price);
        $price = (int)$price;

        $trans->price = $price;


        $trans->desc = $request->desc;
        $trans->type = $request->trans_type;
        $trans->date = $request->date;

        if ($request->trans_type == 'عليه') {

            $client->total += $price;

        }else{

            $client->total -= $price;

        }


        $trans->save();

        $client->save();



        return redirect()->back()->with('success', 'تم إضافة معاملة مالية جديدة بنجاح');



    }


    public function updateTransaction(Request $request){

        $trans = ClientTransaction::find($request->id);

        $client = client::find($trans->client_id);

        $trans->price = $request->price;
        $trans->desc = $request->desc;
        $trans->type = $request->trans_type;
        $trans->date = $request->date;

        $trans->save();

        $income = ClientTransaction::where('client_id', $client->id)->where('type','له')->sum('price');
        $outcome = ClientTransaction::where('client_id', $client->id)->where('type','عليه')->sum('price');

        $client->total = $outcome - $income;

        $trans->save();

        $client->save();

        return redirect()->back()->with('success', 'تم تحديث معاملة مالية بنجاح');



    }

    public function deleteTransaction(Request $request){

        ClientTransaction::find($request->id)->delete();

        return redirect()->back()->with('success', 'تم حذف المعاملة بنجاح');

    }


    public function printClient ($id){

        $client = client::find($id);

        return view('print-client',compact('client'));
    }

}
