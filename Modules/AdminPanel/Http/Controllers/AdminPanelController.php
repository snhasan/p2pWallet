<?php

namespace Modules\AdminPanel\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class AdminPanelController extends Controller
{
    
    public function index()
    {
        $allUser = User::where('role',2)->get();

        $tCount = 0;

        $userWithMostConv = collect();;

        foreach( $allUser as $user){
            $tranHistory = transaction::leftjoin('users','users.account','transactionhistory.fromAccount')
                                    ->where('fromAccount',$user->account)
                                    ->orWhere('toAccount',$user->account)
                                    ->where('isActive',1)
                                    ->select(
                                        DB::raw("users.*,transactionhistory.* ,COUNT(*) as NoOfTran"))
                                    ->orderBy('NoOfTran','desc')
                                    ->get()->first();
            
                if($tranHistory->NoOfTran > $tCount)
                {
                    $tCount = $tranHistory->NoOfTran;
                    $userWithMostConv = $tranHistory;
                }
        }
                        
        return view('adminpanel::index',compact('allUser','userWithMostConv','userWithMostConv'));
    }

    public function userDetails($id)
    {

        $user = User::where('id',$id)->get()->first();

        $tranHistory = transaction::where('fromAccount',$user->account)
                                    ->orWhere('toAccount',$user->account)
                                    ->where('isActive',1)
                                    ->latest()->get();

        $totalAmountSent = transaction::where('fromAccount',$user->account)
                                    ->where('isActive',1)
                                    ->sum('sentAmount');

        $thirdHighest =   transaction::addSelect(['tran' => transaction::select('sentAmount')
                                        ->where('fromAccount',$user->account)
                                        ->orderBy('sentAmount','desc')
                                        ->skip(2)
                                        ->limit(1)
                                        ])->get();
                                        
        return view('adminpanel::userDetails',compact('user','tranHistory','totalAmountSent','thirdHighest'));
    }

    
    public function create()
    {
        return view('adminpanel::create');
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
        return view('adminpanel::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('adminpanel::edit');
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
