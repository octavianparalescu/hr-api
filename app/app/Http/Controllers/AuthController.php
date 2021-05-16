<?php

namespace App\Http\Controllers;

use App\Models\Auth\PasswordAuthentication;
use App\Repository\Auth\AuthTokenRepository;
use App\Repository\Auth\UserRepository;
use App\Validation\Auth\AuthTokenFormatValidationInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    const VALIDATION_PASSWORD = 'min:6|max:255';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
    }

    public function login(
        Request $request,
        PasswordAuthentication $passwordAuthentication,
        UserRepository $userRepository,
        AuthTokenRepository $authTokenRepository,
        AuthTokenFormatValidationInterface $authTokenFormatValidation
    ): JsonResponse {
        try {
            $this->validate(
                $request,
                [
                    'email' => 'required|email',
                    'password' => 'required|' . self::VALIDATION_PASSWORD,
                ]
            );
        } catch (ValidationException $validationException) {
            return response()->json(['errors' => $validationException->errors()], 405);
        }

        $credentials = $request->only(['email', 'password']);

        $existingPassword = $userRepository->getPasswordForEmail($credentials[PasswordAuthentication::FIELD_EMAIL]);

        if (!$existingPassword) {
            return response()->json(['errors' => ['email' => ['Credentials do not match records in our database.']]], 405);
        }

        if (!$passwordAuthentication->verify($credentials, $existingPassword)) {
            return response()->json(['errors' => ['email' => ['Credentials do not match records in our database.']]], 405);
        }

        $user = $userRepository->fetchByEmail($credentials[PasswordAuthentication::FIELD_EMAIL]);

        $token = $authTokenRepository->create($user->getKey(), $authTokenFormatValidation->generate());

        return response()->json($token);
    }

    public function register(
        Request $request,
        UserRepository $userRepository,
        PasswordAuthentication $passwordAuthentication
    ): JsonResponse {
        try {
            $this->validate(
                $request,
                [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|confirmed|' . self::VALIDATION_PASSWORD,
                ]
            );
        } catch (ValidationException $validationException) {
            return response()->json(['errors' => $validationException->errors()], 405);
        }

        $inputData = $request->only(['first_name', 'last_name', 'email', 'password']);

        if ($userRepository->isEmailRegistered($inputData['email'])) {
            return response()->json(['errors' => ['email' => ['An account with this email is already registered.']]], 405);
        }

        $inputData[PasswordAuthentication::FIELD_PASSWORD] = $passwordAuthentication->hash(
            $inputData[PasswordAuthentication::FIELD_PASSWORD]
        );

        $user = $userRepository->create($inputData);

        return response()->json($user);
    }

    public function check(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json($user);
    }
}
