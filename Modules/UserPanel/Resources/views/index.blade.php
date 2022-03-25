<link rel="stylesheet" href="{{ url('css/userTran.css') }}">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Panel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="transaction-wrap">
                    <div class="transaction-html">
                        <input id="tab-1" type="radio" name="tab" class="transferMoney" checked><label for="tab-1" class="tab">Transfer</label>
                        <input id="tab-2" type="radio" name="tab" class="AccStatement"><label for="tab-2" class="tab">Statement</label>
                        <div class="transaction-form">
                        {!! Form::open(['url' => route("user.tran"), 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'my_profile', 'files' => true, 'enctype' => "multipart/form-data", 'novalidate']) !!} 
                            <div class="transferMoney-htm">
                                <div class="group">
                                <label for="user" class="label">Username</label>
                                <input id="user" name="username" type="text" class="input">
                                </div>
                                <div class="group">
                                    <label for="accNo" class="label">Account No.</label>
                                    <input id="accNo" name="accNo" type="number" class="input" >
                                </div>
                                <div class="group">
                                    <label for="amount" class="label">Amount</label>
                                    <input id="amount" name="amount" type="number" class="input" >
                                </div>
                                <br>
                                <div class="group">
                                    <input type="submit" class="button" value="Transfer">
                                </div>
                                @if (\Session::has('success'))
                                     
                                    <p style="color:#12CE3D" >{!! \Session::get('success') !!}</p>
                                @elseif(\Session::has('failure'))  
                                
                                    <p style="color:#EC1932">{!! \Session::get('failure') !!}</p> 
                                @endif
                                @if($errors->any())
                                <h4 style="color:#EC1932">{{$errors->first()}}</h4>
                                @endif
                                <div class="hr"></div>
                                
                            </div>
                            {!! Form::close() !!}
                            <div class="AccStatement-htm">
                                <div class="group">
                                <label for="user" class="label">Account Statement</label>
                                <p>Your Account Balance is: {{ $currUser->amount }} {{ $currUser->currency > 0 ? $currUser->currency: 0}} </p>
                                <br>
                                <label for="user" class="label">Transaction History</label>
                                @foreach($tranHistory as $tran)
                                @if($tran->fromAccount == $currUser->account)
                                <p style="color:#EC1932">You have sent {{$currUser->currency}}{{$tran->sentAmount}} to account {{$tran->toAccount}}. </p>
                                @else
                                <p style="color:#12CE3D" >You have received {{$currUser->currency}}{{$tran->receivedAmount}} from {{$tran->fromAccount}} </p>

                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>