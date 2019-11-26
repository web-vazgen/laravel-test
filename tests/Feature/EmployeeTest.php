<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/get-employees?hire_date=1997-11-30&user_type=employee&gender=M&department=Production',['Accept'=>'application/json']);

        $response->dump();

        $response->assertStatus(200);
    }
}
