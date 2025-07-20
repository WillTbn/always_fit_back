<?php

namespace App\Service\Auth;

use App\Exceptions\ParamerInvalidException;
use App\Models\User;
use App\Service\Service;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService extends Service
{
    private $email;
    private $password;
    private ?User $user;
    private $token;
    /**
     * Create a new AuthService instance.
     *
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function setUser(): void
    {
        $this->user = User::where('email', $this->email)
            ->first();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
    public function setToken(string $token): void
    {
        $this->token = $token;
    }
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Execute the authentication logic.
     *
     * @return SanctumAuthService
     * @throws InvalidParametersException
     */
    public function execute(): mixed
    {
        $this->setUser();

        if(is_null($this->user) || !Hash::check($this->password, $this->user->password)) {
            throw new ParamerInvalidException(
                'Email ou senha inválidos.',
                404
            );
        }

        PersonalAccessToken::where('tokenable_id', $this->user->id)
            ->delete();
        $this->setToken($this->user->createToken('auth_token')->plainTextToken);

        return $this;
    }
}
