<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends AuthTest
{
    /**
     * GetPs test with no authentication.
     *
     * @return void
     */
    public function testGetPsNoAuth()
    {
        $response = $this->get('/api/user/get_ps');
        $response->assertStatus(302);
    }

    /**
     * GetPs test.
     *
     * @return void
     */
    public function testGetPs()
    {
        $this->testLogin();
        $response = $this->get('/api/user/get_ps');

        $response->assertStatus(200);
        $this->assertTrue($response['status']);
    }

    /**
     * ListDirectory test.
     *
     * @return void
     */
    public function testListDirectory()
    {
        $this->testLogin();
        $response = $this->get('/api/user/list_directory');
        $response->assertStatus(200);
        $this->assertTrue($response['status']);
    }

    /**
     * CreateDirectory test.
     *
     * @return void
     */
    public function testCreateDirectory()
    {
        $this->testLogin();
        $response = $this->post('/api/user/create_directory', [
            'directory_name'=>'test21'
        ]);
        $response->assertStatus(200);
        $this->assertTrue($response['status']);
    }

    /**
     * CreateFile test.
     *
     * @return void
     */
    public function testCreateFile()
    {
        $this->testLogin();
        $response = $this->post('/api/user/create_file', [
            'file_name'=>'test21'
        ]);
        $response->assertStatus(200);
        $this->assertTrue($response['status']);
    }

    /**
     * ListFile test.
     *
     * @return void
     */
    public function testListFile()
    {
        $this->testLogin();
        $response = $this->get('/api/user/list_file');
        $response->assertStatus(200);
        $this->assertTrue($response['status']);
    }
}
