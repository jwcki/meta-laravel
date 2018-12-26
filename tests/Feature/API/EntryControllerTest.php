<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Interfaces\OmdbAPIService;
use App\Services\Interfaces\EntryService;

use App\Entry;
use App\EntryImage;

class EntryControllerTest extends TestCase
{   
    const MOCK_API_RESPONSE = [
        'Search' => [
            [
                'Title' => 'Film A',
                'Year' => '2000',
                'imdbID' => 'tt000001',
                'Type' => 'movie',
                'Poster' => 'https://m.media-amazon.com/images/M/MV5BNzQzOTk3OTAtNDQ0Zi00ZTVkLWI0MTEtMDllZjNkYzNjNTc4L2ltYWdlXkEyXkFqcGdeQXVyNjU0OTQ0OTY@._V1_SX300.jpg',
            ],
            [
                'Title' => 'Film B',
                'Year' => '2003',
                'imdbID' => 'tt000002',
                'Type' => 'movie',
                'Poster' => 'N/A',
            ]
        ],
        'totalResults' => '2',
        'Response' => 'True',
    ];

    CONST EXPECT_RESPONSE = [
        'data' => [
            [
                'title' => 'Film A',
                'year' => '2000',
                'imdbID' => 'tt000001',
                'type' => 'movie',
                'poster' => 'https://m.media-amazon.com/images/M/MV5BNzQzOTk3OTAtNDQ0Zi00ZTVkLWI0MTEtMDllZjNkYzNjNTc4L2ltYWdlXkEyXkFqcGdeQXVyNjU0OTQ0OTY@._V1_SX300.jpg',
            ],
            [
                'title' => 'Film B',
                'year' => '2003',
                'imdbID' => 'tt000002',
                'type' => 'movie',
                'poster' => null,
            ]
        ]
    ];

    public function testEntriesResponse() {
        $this->mockServices(self::MOCK_API_RESPONSE);
        $this->get('/api/entries?s=Matrix')
            ->assertOk()
            ->assertExactJson(json_decode(json_encode(self::EXPECT_RESPONSE), true))
        ;
    }

    public function testEntriesResponseWithoutResult() {
        $this->mockServices(['Response' => 'False']);
        $this->get('/api/entries?s=')
            ->assertOk()
            ->assertExactJson([ 'data' => [] ])
        ;
    }

    private function mockServices($mockInput) {
        $this->mockAPIService($mockInput);
        $this->mockEntryService($mockInput);
    }

    private function mockAPIService($mockInput) {
        $this->mockAPIService = $this->createMock(OmdbAPIService::class);
        $this->mockAPIService
            ->expects($this->once())
            ->method('search')
            ->willReturn(json_decode(json_encode($mockInput), true));
    
        $this->app
            ->instance('App\Services\Interfaces\OmdbAPIService', $this->mockAPIService);
    }

    private function mockEntryService($mockInput) {
        $this->mockEntryService = $this->createMock(EntryService::class);
        if (isset($mockInput['Search'])) {
            $this->mockEntryService
                ->expects($this->exactly(count($mockInput['Search'])))
                ->method('update')
                ->will($this->onConsecutiveCalls(
                    ...collect($mockInput['Search'])
                    ->map(function ($value) {
                        return $this->getEntry($value);
            })));
        } else {
            $this->mockEntryService
                ->expects($this->exactly(0))
                ->method('update');
        }
    
        $this->app
            ->instance('App\Services\Interfaces\EntryService', $this->mockEntryService);
    }

    private function getEntry($mockInput) {
        $entry = new Entry;
        $entry->title = $mockInput['Title'];
        $entry->imdbID = $mockInput['imdbID'];
        $entry->year = $mockInput['Year'];
        $entry->type = $mockInput['Type'];

        if (strpos($mockInput['Poster'], 'http') === 0) {
            $image = new EntryImage;
            $image->url = $mockInput['Poster'];
            $entry->image = $image;
        }

        return $entry;
    }
}
