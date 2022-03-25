<?php

namespace Modules\UserPanel\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Validator;
use App\Models\User;
use App\Models\transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Notifications\Notifiable;
use App\Notifications\TransactionEmailNotify;


class UserPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $currUser = Auth::user();

        $tranHistory = transaction::where('fromAccount',$currUser->account)
                                    ->orWhere('toAccount',$currUser->account)
                                    ->where('isActive',1)
                                    ->latest()->get()->take(5);

        return view('userpanel::index', compact('currUser','tranHistory'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function savetran(Request $request)
    {
        $rules = array(
            'username'                  => 'required|max:50',
            'accNo'                     => 'required|max:20',
            'amount'                    => 'required|numeric|gt:0',
        );

        $validation = Validator::make(\Request::all(),$rules);

        if ($validation->fails())
        {
            return redirect()->back()->withInput()->withErrors($validation);
        }
        
        $response = Http::get('http://data.fixer.io/api/latest?access_key=ae157a475ae4da74664a0a304ff27c00');

        $res = $response->json();

        
        $data       = $request->all();
        
        DB::beginTransaction();

        try
        {
            $senderId = Auth::id();

            $sender                        = User::find($senderId); 
            $sender->amount                = floatval($sender['amount']) - floatval($data['amount']);

            if($sender->amount < 0 || $sender->account == $data['accNo'])
            {

                throw ValidationException::withMessages(['failure' => 'Data is not correct']);
            }
            
            DB::table('users')->where('id',$senderId)->update(array(
                'amount'=>$sender->amount,
            ));

            $rate = $res['rates']['USD'];; //euro to USD rate
            $conversedAmount = 0.00;

            $receiver                       = User::where('account',$data['accNo'])->first();
            
            if($receiver  == null)
            {
                throw ValidationException::withMessages(['failure' => 'Data is not correct']);
            }

            if($sender->currency == $receiver->currency){

                $conversedAmount = floatval($data['amount']);

            }
            elseif($sender->currency == 'usd' && $receiver->currency == 'euro'){
                
                $conversedAmount = floatval($data['amount']) / $rate;

            }
            elseif($sender->currency == 'euro' && $receiver->currency == 'usd'){
                
                $conversedAmount = floatval($data['amount']) * $rate;

            }


            $receiver->amount = floatval($receiver['amount']) + $conversedAmount;

            DB::table('users')->where('id',$receiver->id)->update(array(
                'amount'=>$receiver->amount,
            ));

            $tranData[] = array(
                'toAccount' => $receiver['account'],
                'sentAmount' => $data['amount'],
                'fromAccount' => $sender['account'],
                'senderCurr' => $sender['currency'],
                'receivedAmount' => $conversedAmount,
                'receiverCurr' => $receiver['currency'],
                'conversionRate' => $rate,
                'created_at' => date('Y-m-d H:i:s'),
                'isActive' => 1,
            );

            DB::table('transactionHistory')->insert($tranData); 

            DB::commit();

            $receiver->notify(new TransactionEmailNotify());

            return redirect()->back()->with('success', 'Transaction is Successful!');  

        }catch (\Exception $exception)
        {
            
            DB::rollback();
            
            return redirect()->back()->with('failure', $exception->getMessage());  
        }
        
        //return redirect()->back()->with('success', 'Successful');  
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('userpanel::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('userpanel::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
