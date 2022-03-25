<link rel="stylesheet" href="{{ url('css/userTran.css') }}">
<style>
    p{
        color: white;
    }
    ::-webkit-scrollbar {
    width: 6px;
} 
::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
} 
::-webkit-scrollbar-thumb {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
}
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="transaction-wrap">
                    <div class="transaction-html">
                        <input id="tab-1" type="radio" name="tab" class="transferMoney" checked><label for="tab-1" class="tab">User Details</label>
                        <input style="display: none" id="tab-2" type="radio" name="tab" class="AccStatement"><label style="display: none" for="tab-2" class="tab">Statement</label>
                        <div class="transaction-form">
                        
                            <div class="transferMoney-htm" style="overflow-y:auto">
                                <div class="group">
                                <br>
                                <p>User Name: <b> {{ $user->name }} </b></p>
                                <p>User Account No.: {{ $user->account }}</p>
                                <p>Account Balance: {{ $user->currency }}{{ $user->amount }}</p>
                                <p>Total Transaction: {{ $tranHistory->count() }}</p>
                                <div class="hr"></div>
                                
                                <p>Total Converted: {{ $user->currency }}{{ $totalAmountSent }}</p>
                                <div class="hr"></div>
                                
                                <p>Third Highest Transaction: {{ $user->currency }}{{ $thirdHighest[0]['tran'] == null ? 0 : $thirdHighest[0]['tran']}}</p>
                                <div class="hr"></div>

                                <label for="user" class="label">Transaction History</label>
                                <br>
                                @foreach($tranHistory as $tran)
                                @if($tran->fromAccount == $user->account)
                                <p>{{$tran->receiverCurr}}{{$tran->sentAmount}} sent to account {{$tran->toAccount}}. </p>
                                @else
                                <p>{{$tran->receiverCurr}}{{$tran->receivedAmount}} received from {{$tran->fromAccount}} </p>

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