<?php
declare(strict_types=1);

namespace Tests\Http\Controllers;

use App\Models\Department\DepartmentDAO;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\Stub\Auth\UserStub;
use Tests\TestCase;

class DepartmentControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testStoreValid()
    {
        $name = 'test-department';
        $data = [
            'name' => $name,
        ];
        $this->actingAs(new UserStub())
             ->json('PUT', '/department', $data)
             ->seeJson(['name' => $name])
             ->seeInDatabase(DepartmentDAO::TABLE, $data)
             ->seeStatusCode(200);
    }

    public function testStoreInValid()
    {
        $name = '';
        $data = [
            'name' => $name,
        ];
        $this->actingAs(new UserStub())
             ->json('PUT', '/department', $data)
             ->seeJson(['errors' => ['name' => ['The name field is required.']]])
             ->seeStatusCode(405);
    }

    public function testIndex()
    {
        $name = 'test-department';
        $data = [
            'name' => $name,
        ];
        $this->actingAs(new UserStub())
             ->json('PUT', '/department', $data)
             ->seeJson(['name' => $name])
             ->seeInDatabase(DepartmentDAO::TABLE, $data)
             ->seeStatusCode(200);
        $this->actingAs(new UserStub())
             ->json('GET', '/department', $data)
             ->seeJson([['id' => 1, 'name' => $name]])
             ->seeStatusCode(200);
    }

    public function testIndexMaxSalary0()
    {
        $name = 'test-department';
        $data = [
            'name' => $name,
        ];
        $this->actingAs(new UserStub())
             ->json('PUT', '/department', $data)
             ->seeJson(['name' => $name])
             ->seeInDatabase(DepartmentDAO::TABLE, $data)
             ->seeStatusCode(200);
        $this->actingAs(new UserStub())
             ->json('GET', '/department?include_max_salary=1', $data)
             ->seeJson([['id' => 1, 'name' => $name, 'max_salary' => 0]])
             ->seeStatusCode(200);
    }
}
