<?php

namespace Tests\Feature\Manager\Announcement;

use App\Models\Announcement;
use App\Models\Company;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AnnouncementControllerTest extends TestCase
{
    use RefreshDatabase;

    protected string $apiUrl = '/api/manager/announcements/';

    public function test_announcement_list()
    {
        $company = Company::factory()->create();
        $user = User::factory()->state(['role' => User::Manager])->create();
        UserInfo::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();
        Announcement::factory(20)->state(['company_id' => $company->id])->create();

        Sanctum::actingAs($user, ['manager.announcement.list']);

        $response = $this->get($this->apiUrl);

        $response->assertJsonCount(20);
    }

    public function test_announcement_create()
    {
        $company = Company::factory()->create();
        $user = User::factory()->state(['role' => User::Manager])->create();
        UserInfo::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();
        $announcement = Announcement::factory()->state(['company_id' => $company->id])->make();

        Sanctum::actingAs($user, ['manager.announcement.create']);

        $response = $this->postJson($this->apiUrl, $announcement->toArray());
        $response->assertStatus(201);
    }

    public function test_announcement_show()
    {
        $company = Company::factory()->create();
        $user = User::factory()->state(['role' => User::Manager])->create();
        UserInfo::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();
        $announcement = Announcement::factory()->state(['company_id' => $company->id])->create();

        Sanctum::actingAs($user, ['manager.announcement.show']);

        $response = $this->get($this->apiUrl.$announcement->id);
        $response->assertJsonFragment(['id' => $announcement->id]);
    }

    public function test_announcement_update()
    {
        $company = Company::factory()->create();
        $user = User::factory()->state(['role' => User::Manager])->create();
        UserInfo::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();
        $announcement = Announcement::factory()->state(['company_id' => $company->id])->create();

        Sanctum::actingAs($user, ['manager.announcement.update']);

        $response = $this->putJson($this->apiUrl.$announcement->id, [
            'title' => 'test',
            'content' => 'test',
        ]);
        $response->assertStatus(200);
    }

    public function test_announcement_delete()
    {
        $company = Company::factory()->create();
        $user = User::factory()->state(['role' => User::Manager])->create();
        UserInfo::factory()->state(['user_id' => $user->id, 'company_id' => $company->id])->create();
        $announcement = Announcement::factory()->state(['company_id' => $company->id])->create();

        Sanctum::actingAs($user, ['manager.announcement.delete']);

        $response = $this->delete($this->apiUrl.$announcement->id);
        $response->assertStatus(200);
    }
}
