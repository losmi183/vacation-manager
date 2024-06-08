<?php 

namespace App\Services;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\TeamRepository;

class TeamService {

    private TeamRepository $teamRepository;
    private UserService $userService;

    public function __construct(TeamRepository $teamRepository, UserService $userService) {
        $this->teamRepository = $teamRepository;
        $this->userService = $userService;
    }

    public function store(array $data): Team {
        return $this->teamRepository->store($data);
    }

    public function assignUser(array $data): User {
        return $this->teamRepository->assignUser($data);
    }

    /**
     * teamManager - manager teams
     * 
     * @param array $data
     * 
     * @return User
     */
    public function teamManager(array $data): User {
        return $this->teamRepository->teamManager($data);
    }

    /**
     * managerTeamIds - manager teams ids
     * 
     * @return array
     */
    public function managerTeamIds(): array 
    {
        $manager = $this->userService->loggedUser();
        return DB::table('team_manager')
        ->where('user_id', $manager->id)
        ->pluck('team_id')
        ->toArray();
    }   
}