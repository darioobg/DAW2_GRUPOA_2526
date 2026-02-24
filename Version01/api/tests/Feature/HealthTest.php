<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthTest extends TestCase
{
    public function test_api_health(): void
    {
        $response = $this->get('/api/v1/health');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'ok'
            ]);
    }
}
