<?php 

namespace App\Services;
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
}