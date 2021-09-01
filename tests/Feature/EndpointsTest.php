<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EndpointsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // testing 'books' endpoint
        $response = $this->get('/api/books');
        $response->assertStatus(200);

        // testing book creation and getting the data
        $response = $this->post('/api/book', [
            'author' => 'PHPTEST AUTHOR',
            'title' => 'PHPTEST TITLE'
        ]);
        $response->assertStatus(201);

        $book = json_decode($response->getContent());
        $book = $book->data;
        $id = (int)$book->id;
        $this->assertTrue($id > 0);

        // testing update method, trying to alter 
        // newly created book
        $response = $this->put('/api/book/' . $id, [
            'author' => 'PHPTEST AUTHOR NEW VAL',
            'title' => 'PHPTEST TITLE NEW VAL'
        ]);

        $response->assertStatus(204);

        // test if the book was edited sucessfully
        $response = $this->get('/api/book/' . $id);
        $response->assertStatus(200);
        $book = json_decode($response->getContent());
        $book = $book->data;

        $this->assertTrue($book->author == 'PHPTEST AUTHOR NEW VAL');

        // delete test data
        $response = $this->delete('/api/book/' . $id);

        $response->assertStatus(204);
    }
}
