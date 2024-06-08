<?php 

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService {

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function users(): Collection {
        return $this->userRepository->users();
    }
    public function usersPaginate(array $params): LengthAwarePaginator {
        return $this->userRepository->usersPaginate($params);
    }
    public function store(array $data): User {
        $data['password'] = bcrypt($data['password']);
        return $this->userRepository->store($data);
    }
    public function update(array $data, int $id): User {
        $data['password'] = bcrypt($data['password']);
        return $this->userRepository->update($data, $id);
    }

    public function userRole(array $data): User 
    {
        return $this->userRepository->userRole($data);
    }

    public function loggedUser(): User
    {
        return auth()->user();
    }

    public function teamUsers($team_id): Collection
    {
        return User::where('team_id', $team_id)->get();
    }
}