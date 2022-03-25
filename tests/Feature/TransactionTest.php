<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\transaction;

class TransactionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */

    public function transaction_create()
    {
        $response = $this->create('/user/tran',[
            '_token' => csrf_token(),
            
            'username' => 'test',
            'accNo' => 12,
            'amount' => 100,
        ]);

        
        $this->assertEquals(201, $response->getStatusCode());
        

    }

    

    
}
