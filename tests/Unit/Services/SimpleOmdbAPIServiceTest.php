<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Log;

use App\Services\SimpleOmdbAPIService;

class SimpleOmdbAPIServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSearch()
    {
        $this->markTestSkipped('Skip API call');

        $service = new SimpleOmdbAPIService(env('OMDB_HOST'), env('OMDB_API_KEY'));
        $result = $service->search('Matrix');

        $this->assertArrayHasKey('Response', $result);
        $this->assertEquals('True', $result['Response']);

        $this->assertArrayHasKey('totalResults', $result);
        $this->assertRegExp('/^\d+$/', $result['totalResults']);

        $this->assertArrayHasKey('Search', $result);
        $this->assertInternalType('array', $result['Search']);

        foreach ($result['Search'] as $value) {
            $this->assertArrayHasKey('Title', $value);
            $this->assertArrayHasKey('Year', $value);
            $this->assertArrayHasKey('imdbID', $value);
            $this->assertArrayHasKey('Type', $value);
            $this->assertArrayHasKey('Poster', $value);
        }        
    }
}
