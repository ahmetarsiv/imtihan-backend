<?php

namespace Tests\Feature\Manager\Booking;

use App\Models\Booking;
use App\Models\Company;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected string $apiUrl = '/api/manager/bookings/';

    public function test_booking_list()
    {
        $company = Company::factory()->create();
        $user = User::factory()->state(['role' => User::Manager])->create();
        UserInfo::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();
        Booking::factory(20)->state(['company_id' => $company->id])->create();

        Sanctum::actingAs($user, ['manager.booking.list']);

        $response = $this->get($this->apiUrl);

        $response->assertJsonCount(20);
    }

    public function test_booking_create()
    {
        $company = Company::factory()->create();
        $user = User::factory()->state(['role' => User::Manager])->create();
        UserInfo::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();
        $booking = Booking::factory()->make();

        Sanctum::actingAs($user, ['manager.booking.create']);

        $response = $this->postJson($this->apiUrl, $booking->toArray());
        $response->assertStatus(201);
    }

    public function test_booking_show()
    {
        $company = Company::factory()->create();
        $user = User::factory()->state(['role' => User::Manager])->create();
        UserInfo::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();
        $booking = Booking::factory()->state(['company_id' => $company->id])->create();

        Sanctum::actingAs($user, ['manager.booking.show']);

        $response = $this->get($this->apiUrl.$booking->id);
        $response->assertJsonFragment(['id' => $booking->id]);
    }

    public function test_booking_update()
    {
        $company = Company::factory()->create();
        $user = User::factory()->state(['role' => User::Manager])->create();
        UserInfo::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();
        $booking = Booking::factory()->state(['company_id' => $company->id])->create();

        Sanctum::actingAs($user, ['manager.booking.update']);

        $response = $this->putJson($this->apiUrl.$booking->id, [
            'description' => 'test',
        ]);
        $response->assertStatus(200);
    }

    public function test_booking_delete()
    {
        $company = Company::factory()->create();
        $user = User::factory()->state(['role' => User::Manager])->create();
        UserInfo::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();
        $booking = Booking::factory()->state(['company_id' => $company->id])->create();

        Sanctum::actingAs($user, ['manager.booking.delete']);

        $response = $this->delete($this->apiUrl.$booking->id);
        $response->assertStatus(200);
    }
}
