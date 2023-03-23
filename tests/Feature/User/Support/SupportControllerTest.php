<?php

namespace Tests\Feature\User\Support;

use App\Models\Company;
use App\Models\Support;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SupportControllerTest extends TestCase
{
    use RefreshDatabase;

    protected string $apiUrl = '/api/student/supports/';

    public function test_support_list()
    {
        $company = Company::factory()->create();
        $user = User::factory()->state(['role' => User::Student])->create();
        UserInfo::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();
        Support::factory(20)->state(['company_id' => $company->id, 'user_id' => $user->id])->create();

        Sanctum::actingAs($user, ['student.support.list']);

        $response = $this->get($this->apiUrl);

        $response->assertJsonCount(20);
    }

    public function test_support_create()
    {
        $company = Company::factory()->create();
        $user = User::factory()->state(['role' => User::Student])->create();
        UserInfo::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();
        $support = Support::factory()->make();

        Sanctum::actingAs($user, ['student.support.create']);

        $response = $this->postJson($this->apiUrl, $support->toArray());
        $response->assertStatus(201);
    }

    public function test_support_delete()
    {
        $company = Company::factory()->create();
        $user = User::factory()->state(['role' => User::Student])->create();
        UserInfo::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();
        $booking = Support::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();

        Sanctum::actingAs($user, ['student.support.delete']);

        $response = $this->delete($this->apiUrl.$booking->id);
        $response->assertStatus(200);
    }
}
