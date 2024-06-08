<?php 

namespace App\Services;

use App\Models\Team;
use Illuminate\Support\Collection;
use App\Repositories\TeamRepository;

class TeamService {

    private TeamRepository $teamRepository;

    public function __construct(TeamRepository $teamRepository) {
        $this->teamRepository = $teamRepository;
    }

    public function store(array $data): Team {
        return $this->teamRepository->store($data);
    }
   
}