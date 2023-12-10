<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseService
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id): mixed
    {
        return $this->model->find($id);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getByName($name): mixed
    {
        return $this->model->where('name', $name)->first();
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->model->all()->toArray();
    }

    /**
     * @param Carbon $time
     * @return mixed
     */
    public function getByTime(Carbon $time): mixed
    {
        return $this->model->where('created_at', '>=', $time)->get();
    }

    /**
     * @param string $email
     * @return string
     */
    public function createToken(string $email): string
    {
        do {
            $token = strtoupper(Str::random(8));
        } while ($this->tokenExists($token));

        if ($this->model->where('email', $email)->exists()) {
            $this->model->where('email', $email)->update([
                'token' => $token,
            ]);
        } else {
            $this->model->create([
                'email' => $email,
                'token' => $token,
            ]);
        }

        return $token;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function tokenExists(string $token): bool
    {
        return $this->model->where('token', $token)->exists();
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function getByToken(string $token)
    {
        return $this->model->where('token', $token)->first();
    }
}
