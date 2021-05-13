<?php
declare(strict_types=1);

namespace Tests\Http\Controllers;

use App\Models\Employee\EmployeeDAO;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\Stub\Auth\UserStub;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testStoreValid()
    {
        $this->createDepartment();
        $employee = [
            'first_name' => 'FirstName',
            'last_name' => 'LastName',
            'department_id' => 1,
            'salary' => 40000,
        ];
        $this->actingAs(new UserStub())
             ->json('PUT', '/employee', $employee)
             ->seeJson($employee)
             ->seeInDatabase(EmployeeDAO::TABLE, $employee)
             ->seeStatusCode(200);
    }

    public function testStoreInValid()
    {
        $this->createDepartment();
        $employee = [
            'first_name' => 'First',
            'last_name' => 'LastName',
            'department_id' => 1,
            'salary' => 40000,
        ];
        $this->actingAs(new UserStub())
             ->json('PUT', '/employee', $employee)
             ->seeJson(['errors' => ['first_name' => ["The first name must be at least 6 characters."]]])
             ->seeStatusCode(405);
    }

    public function testStoreInValidDepartment()
    {
        $this->createDepartment();
        $employee = [
            'first_name' => 'FirstName',
            'last_name' => 'LastName',
            'department_id' => 2,
            'salary' => 40000,
        ];
        $this->actingAs(new UserStub())
             ->json('PUT', '/employee', $employee)
             ->seeJson(['errors' => ['department_id' => ["Department not found."]]])
             ->seeStatusCode(405);
    }

    public function testIndex()
    {
        $data = $this->createDepartment();
        $departmentId = 1;
        $employee = [
            'first_name' => 'FirstName',
            'last_name' => 'LastName',
            'department_id' => $departmentId,
            'salary' => 40000,
        ];
        $this->actingAs(new UserStub())
             ->call('PUT', '/employee', $employee);
        $this->actingAs(new UserStub())
             ->json('GET', '/employee', $data)
             ->seeJson(array_merge($employee, ['id' => 1]))
             ->seeStatusCode(200);
    }

    public function testIndexValidDepartment()
    {
        $data = $this->createDepartment();
        $departmentId = 1;
        $employee = [
            'first_name' => 'FirstName',
            'last_name' => 'LastName',
            'department_id' => $departmentId,
            'salary' => 40000,
        ];
        $this->actingAs(new UserStub())
             ->call('PUT', '/employee', $employee);
        $this->actingAs(new UserStub())
             ->json('GET', '/employee?department_id=' . $departmentId, $data)
             ->seeJson(array_merge($employee, ['id' => 1]))
             ->seeStatusCode(200);
    }

    public function testIndexInValidDepartment()
    {
        $data = $this->createDepartment();
        $departmentId = 1;
        $employee = [
            'first_name' => 'FirstName',
            'last_name' => 'LastName',
            'department_id' => $departmentId,
            'salary' => 40000,
        ];
        $this->actingAs(new UserStub())
             ->call('PUT', '/employee', $employee);
        $this->actingAs(new UserStub())
             ->json('GET', '/employee?department_id=2', $data)
             ->seeStatusCode(405);
    }

    /**
     * @return string[]
     */
    private function createDepartment(): array
    {
        $name = 'test-department';
        $data = [
            'name' => $name,
        ];
        $this->actingAs(new UserStub())
             ->call('PUT', '/department', $data);

        return $data;
    }
}
