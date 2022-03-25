<?php

namespace App\Observers;

use App\Models\transaction;
use App\Models\User;

class TranObserver
{
    /**
     * Handle the transaction "created" event.
     *
     * @param  \App\Models\transaction  $transaction
     * @return void
     */
    public function created(transaction $transaction)
    {

    }

    /**
     * Handle the transaction "updated" event.
     *
     * @param  \App\Models\transaction  $transaction
     * @return void
     */
    public function updated(transaction $transaction)
    {
        //
    }

    /**
     * Handle the transaction "deleted" event.
     *
     * @param  \App\Models\transaction  $transaction
     * @return void
     */
    public function deleted(transaction $transaction)
    {
        //
    }

    /**
     * Handle the transaction "restored" event.
     *
     * @param  \App\Models\transaction  $transaction
     * @return void
     */
    public function restored(transaction $transaction)
    {
        //
    }

    /**
     * Handle the transaction "force deleted" event.
     *
     * @param  \App\Models\transaction  $transaction
     * @return void
     */
    public function forceDeleted(transaction $transaction)
    {
        //
    }
}
