<?php
declare(strict_types=1);

namespace Tests\Http\Controllers;


use App\Entities\Time\TimeInterface;
use App\Models\Auth\UserDAO;
use App\Providers\AuthServiceProvider;
use App\Validation\Auth\AuthTokenFormatValidationInterface;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\Stub\Auth\AuthTokenFormatValidationStub;
use Tests\Stub\Time\TimeStub;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testRegisterValid()
    {
        $email = 'test@test.com';
        $data = [
            'email' => $email,
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
            'first_name' => 'Test',
            'last_name' => 'Test',
        ];

        $this->json('POST', '/auth/register', $data)
             ->seeJson(['email' => $email])
             ->seeStatusCode(200)
             ->seeInDatabase(UserDAO::TABLE, ['email' => $email]);
    }

    public function testRegisterInvalid()
    {
        $email = 'test@test.com';
        $data = [
            'email' => $email,
            'password' => 'testp',
            'password_confirmation' => 'testp',
            'first_name' => 'Test',
            'last_name' => 'Test',
        ];

        $this->json('POST', '/auth/register', $data)
             ->seeStatusCode(405)
             ->notSeeInDatabase(UserDAO::TABLE, ['email' => $email]);
    }

    public function testRegisterAlreadyExists()
    {
        $email = 'test@test.com';
        $data = [
            'email' => $email,
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
            'first_name' => 'Test',
            'last_name' => 'Test',
        ];

        $this->json('POST', '/auth/register', $data)
             ->seeStatusCode(200)
             ->seeInDatabase(UserDAO::TABLE, ['email' => $email])
             ->seeJson(['email' => $email]);

        $data = [
            'email' => $email,
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
            'first_name' => 'Test 2',
            'last_name' => 'Test 2',
        ];

        $this->json('POST', '/auth/register', $data)
             ->seeStatusCode(405)
             ->seeJson(['errors' => ['email' => ['An account with this email is already registered.']]]);
    }

    public function testLoginSuccessful()
    {
        $email = 'test@test.com';
        $password = 'testpassword';
        $this->registerSuccesfully($email, $password);

        $loginData = [
            'email' => $email,
            'password' => $password,
        ];

        $time = new TimeStub();
        $this->app->singleton(TimeInterface::class, fn() => $time);
        $this->app->singleton(AuthTokenFormatValidationInterface::class, fn() => new AuthTokenFormatValidationStub());

        $this->json('POST', '/auth/login', $loginData)
             ->seeJson(
                 [
                     'user_id' => 1,
                     'created_at' => $time->getTimeSqlFormat(),
                     'used_at' => $time->getTimeSqlFormat(),
                     'token' => AuthTokenFormatValidationStub::TEST_TOKEN,
                 ]
             )
             ->seeStatusCode(200);
    }

    public function testLoginInvalidPassword()
    {
        $email = 'test@test.com';
        $password = 'testpassword';
        $this->registerSuccesfully($email, $password);

        $loginData = [
            'email' => $email,
            'password' => $password . 'something-else',
        ];

        $this->json('POST', '/auth/login', $loginData)
             ->seeStatusCode(405)
             ->seeJson(['errors' => ['email' => ['Credentials do not match records in our database.']]]);
    }

    public function testLoginInvalidEmail()
    {
        $email = 'test@test.com';
        $password = 'testpassword';
        $this->registerSuccesfully($email, $password);

        $loginData = [
            'email' => $email . '.de',
            'password' => $password,
        ];

        $this->json('POST', '/auth/login', $loginData)
             ->seeStatusCode(405)
             ->seeJson(['errors' => ['email' => ['Credentials do not match records in our database.']]]);
    }

    public function testLoginNoPassword()
    {
        $email = 'test@test.com';
        $password = 'testpassword';
        $this->registerSuccesfully($email, $password);

        $loginData = [
            'email' => $email,
        ];

        $this->json('POST', '/auth/login', $loginData)
             ->seeStatusCode(405)
             ->seeJson(['errors' => ['password' => ['The password field is required.']]]);
    }

    /**
     * @param string $email
     * @param string $password
     */
    private function registerSuccesfully(string $email, string $password): void
    {
        $registerData = [
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
            'first_name' => 'Test',
            'last_name' => 'Test',
        ];

        $this->call('POST', '/auth/register', $registerData);
    }

    public function testVerifyValidLogin()
    {
        $email = 'test@test.com';
        $password = 'testpassword';
        $this->registerSuccesfully($email, $password);

        $loginData = [
            'email' => $email,
            'password' => $password,
        ];

        $loginResponse = $this->json('POST', '/auth/login', $loginData)->response->json();

        $token = $loginResponse['token'];

        $this->json('GET', '/auth/check', [], [AuthServiceProvider::AUTH_TOKEN => $token])
             ->seeStatusCode(200)
             ->seeJson(['email' => $email]);
    }

    public function testVerifyInValidLogin()
    {
        $this->json('GET', '/auth/check', [], [AuthServiceProvider::AUTH_TOKEN => 'something'])
             ->seeStatusCode(401)
             ->seeJson(null);
    }
}
