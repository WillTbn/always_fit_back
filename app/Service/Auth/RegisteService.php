<?php

namespace App\Service\Auth;

use App\Exceptions\ParamerInvalidException;
use App\Models\User;
use App\Service\Service;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Vinkla\Hashids\Facades\Hashids;

class RegisteService extends Service
{
    private $name;
    private $email;
    private $password;
    private ?User $user;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
    public function setUser(): void
    {
        $this->user = User::create([
            'hash_id' => Hashids::encode(fake()->unique()->randomNumber(8, true)),
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
    }
    public function getUser(): ?User
    {
        return $this->user;
    }
    /**
     * Execute the registration process.
     * @return RegisteService
     * @throws ParamerInvalidException
     */
    public function execute(): mixed
    {
        $this->setUser();

        if (!$this->user) {
            throw new ParamerInvalidException('Erro ao registrar usuário.', 500);
        }

        return $this;
    }
}
