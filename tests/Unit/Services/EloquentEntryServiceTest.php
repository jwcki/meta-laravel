<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\EloquentEntryService;

class EloquentEntryServiceTest extends TestCase
{
    use RefreshDatabase;

    CONST INPUT = [
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
            'imdbID' => 'tt000001',
            'type' => 'game',
            'poster' => 'N/A',
        ],
        [
            'title' => 'Film C',
            'year' => '2003',
            'imdbID' => 'tt000001',
            'type' => 'game',
            'poster' => 'https://images-na.ssl-images-amazon.com/images/M/MV5BOTUwOTY3Mjg1MF5BMl5BanBnXkFtZTcwODI2MTAyMQ@@._V1_SX300.jpg',
        ],
        [
        'title' => 'Film D',
        'year' => '2005',
        'imdbID' => 'tt000005',
        'type' => 'movie',
        'poster' => 'https://m.media-amazon.com/images/M/MV5BMTIzMTA4NDI4NF5BMl5BanBnXkFtZTYwNjg5Nzg4._V1_SX300.jpg',
        ]   
        ];

    public function testUpdate() {
        $entryService = new EloquentEntryService;

        foreach (self::INPUT as $input) {
            $entryObj = $entryService->update($input);
            $this->assertEntry($input, $entryObj);
        }
    }

    private function assertEntry($expected, $entryObj) {
        $this->assertEquals($expected['title'], $entryObj->title);
        $this->assertEquals($expected['year'], $entryObj->year);
        $this->assertEquals($expected['imdbID'], $entryObj->imdbID);
        $this->assertEquals($expected['type'], $entryObj->type);

        $this->assertDatabaseHas(
            'entries', 
            collect($expected)->filter(function ($value, $key) {
                return $key !== 'poster';
            })->all()
        );

        if (strpos($expected['poster'], 'http') === 0) {
            logger('update image');
            $this->assertNotNull($entryObj->image);
            $this->assertEquals($expected['poster'], $entryObj->image->url);
            $this->assertDatabaseHas(
                'entry_images', 
                [ 
                    'imdbID' => $expected['imdbID'],
                    'url' => $expected['poster'],
                ]
            );
        } else {
            logger('delete image');
            $this->assertNull($entryObj->image);
            $this->assertDatabaseMissing(
                'entry_images',
                [ 'imdbID' => $expected['imdbID'] ]
            );
        }
    }
}
