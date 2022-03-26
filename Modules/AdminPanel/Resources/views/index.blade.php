<style>


h1{
  font-size: 30px;
  color: Black;
  text-transform: uppercase;
  font-weight: 300;
  text-align: center;
  margin-bottom: 15px;
}
table{
  width:100%;
  table-layout: fixed;
}
.tbl-header{
  background-color: #2563ebe0;
  border-radius: 3px;
 }
.tbl-content{
  background-color: white;
  box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
  height:300px;
  overflow-x:auto;
  margin-top: 0px;
  border: 1px solid rgba(255,255,255,0.3);
}
th{
  padding: 20px 15px;
  text-align: left;
  font-weight: 500;
  font-size: 12px;
  color: #fff;
  text-transform: uppercase;
}
td{
  padding: 15px;
  text-align: left;
  vertical-align:middle;
  font-weight: 500;
  font-size: 15px;
  color: black;
  border-bottom: solid 1px rgba(255,255,255,0.1);
}


/* demo styles */


section{
  margin: 50px;
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
            {{ __('User List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">
                <section>
                <!--for demo wrap-->
                    <div class="tbl-header" style="background: linear-gradient(to right top, #094aac, #153997, #192783, #1a156e, #18015a);">
                        <table cellpadding="0" cellspacing="0" border="0">
                        <thead>
                            <tr>
                            <th></th>
                            <th></th>
                            <th>Name</th>
                            <th>Account No.</th>
                            <th>No. Of Transactions</th>
                            <th>Details</th>
                            </tr>
                        </thead>
                        </table>
                    </div>
                    <div class="tbl-content" style="height: auto">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                                <tr>
                                    <td colspan="2">User With Most Transaction</td>
                                    <td>{{ $userWithMostConv->name }}</td>
                                    <td>{{ $userWithMostConv->account }}</td>
                                    <td>{{ $userWithMostConv->NoOfTran }}</td>
                                    <td> <a href="{{ route('admin.userDetails',$userWithMostConv->id) }}">Details</a> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="tbl-header">
                        <table cellpadding="0" cellspacing="0" border="0">
                        <thead>
                            <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Account No.</th>
                            <th>Balance</th>
                            <th>Currency</th>
                            <th>Details</th>
                            </tr>
                        </thead>
                        </table>
                    </div>
                    <div class="tbl-content">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                                
                            <?php $i=1; ?>
                                @foreach($allUser as $user)
                                
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->account }}</td>
                                    <td>{{ $user->amount }}</td>
                                    <td>{{ $user->currency }}</td>
                                    <td> <a href="{{ route('admin.userDetails',$user->id) }}">Details</a> </td>
                                </tr>
                                </a>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </div>
    </div>
</x-app-layout>