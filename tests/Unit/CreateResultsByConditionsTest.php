<?php

namespace Tests\Unit;

use LeadBrowser\Extractor\Jobs\CreateResultsByConditions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateResultsByConditionsTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    /** @test */
    public function it_creates_results_by_conditions()
    {
        // Arrange
        // Set up any necessary data or dependencies for the test

        // Act
        // Perform the action being tested
        $job = new CreateResultsByConditions(
            'LeadBrowser\Organization\Models\Organization', // class
            1, // search_id
            1, // user_id
            'Test Title', // title
            ['conditions'], // conditions
            ['types'] // types
        );
        $job->handle();

        // Assert
        // Verify that the action has the expected results
        $this->assertDatabaseHas('results', [
            'search_id' => 1,
            'user_id' => 1,
            'title' => 'Test Title',
            // Assert other necessary fields as needed
        ]);
    }
}