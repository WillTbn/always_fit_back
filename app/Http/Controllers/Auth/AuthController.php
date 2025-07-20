<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisteRequest;
use App\Service\Auth\AuthService;
use App\Service\Auth\RegisteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * Handle the incoming request to authenticate a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function auth(LoginRequest $request)
    {
        $authService = new AuthService(
            $request->input('email'),
            $request->input('password')
        );
        $authService->execute();

        return new JsonResponse([
            'success' => true,
            'message' => 'Login efetuado com sucesso.',
            'token' => $authService->getToken()
        ], 200);

    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            PersonalAccessToken::where('tokenable_id', $user->id)
                ->where('tokenable_type', 'App\Models\User')
                ->delete();
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'Logout efetuado com sucesso.'
        ], 200);
    }

    public function validateToken(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Token inválido ou expirado.'
            ], 401);
        }
        // dd($user);
        return new JsonResponse([
            'success' => true,
            'message' => 'Token válido.',
            'user' => $user
        ], 200);
    }

    public function register(RegisteRequest $request): JsonResponse
    {
        $registerService = new RegisteService(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        $user = $registerService->execute();

        return new JsonResponse([
            'success' => true,
            'message' => 'Usuário registrado, com sucesso.',
            'user' => $registerService->getUser()
        ], 201);
    }
}
