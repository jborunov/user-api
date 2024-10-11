<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_ip_address_sum_calculation()
    {
        // Simulate a User model with an IP address
        $user = new User(['ip_address' => '192.168.1.1']);
        
        // Check if the sum of IP parts is calculated correctly
        $this->assertEquals(362, $user->ipAddressSum);
    }
}
