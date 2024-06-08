<?php 

namespace App\Services;

use Carbon\Carbon;
use App\Models\Request;
use Illuminate\Support\Collection;
use App\Repositories\TeamRepository;
use App\Repositories\RequestRepositiry;

class RequestService {

    private RequestRepositiry $requestRepositiry;
    private UserService $userService;
    private teamService $teamService;
    private TeamRepository $teamRepository;

    public function __construct(
        RequestRepositiry $requestRepositiry,
        TeamRepository $teamRepository, 
        UserService $userService, 
        TeamService $teamService,
    ){
        $this->requestRepositiry = $requestRepositiry;
        $this->teamRepository = $teamRepository;
        $this->userService = $userService;
        $this->teamService = $teamService;
    }   

    public function requests(): \stdClass
    {
        $user = $this->userService->loggedUser();
        
        $userData = new \stdClass;
        $userData->daysLeft = $user->days;
        $userData->vacationLeft = $user->vacation;
        $userData->daysLeftrequests = $this->requestRepositiry->requests($user->id);
        return $userData;
    }
    public function teamRequests(): Collection
    {
        $user = $this->userService->loggedUser();
        $teamUsers = $this->userService->teamUsers($user->team_id);
        $user_ids = $teamUsers->pluck('id')->toArray();

        return $this->requestRepositiry->teamRequests($user_ids);
    }

    public function request(array $data): Request
    {   
        $user = $this->userService->loggedUser();
        
        $data['user_id'] = $user->id;
        $data['working_days'] = $this->countWorkingDays($data['date_from'], $data['date_to']);

        return $this->requestRepositiry->create($data);
    }

    public function managerTeamRequests()
    {
        $managerTeamIds = $this->teamService->managerTeamIds();

        foreach ($managerTeamIds as $managerTeamId) {
            $userInTeamIds = $this->teamRepository->userInTeamIds($managerTeamId);
            $teamRequestsAll = $this->requestRepositiry->teamRequestsAll($userInTeamIds);
            dd(1);
        }

    }


    // Count working days between two dates with Carbon library
    // Find saturday and sunday in period and not count 
    public function countWorkingDays(string $startDate, string $endDate): int
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $days = $end->diffInDays($start) + 1; // Uključivanje krajnjeg dana u računanje
    
        $nonWorkingDays = 0;
        $year = Carbon::parse($startDate)->year;
        $holidays = $this->holidays($year);
    
        // Iterate between start and end - check count weekend days
        for ($date = $start; $date->lte($end); $date->addDay()) {
            if ($date->isWeekend() || in_array($date->toDateString(), array_map(function ($holiday) {
                return $holiday->toDateString();
            }, $holidays))) {
                $nonWorkingDays++;
            }
        }
    
        $workingDays = $days - $nonWorkingDays;
    
        return $workingDays;
    }

    public function holidays($year): array
    {        
        $holidays = config('settings.holidays');
        $carbonHolidays = [];
    
        foreach ($holidays as $value) {
            $carbonHolidays[] = Carbon::parse($year . '-' . $value);
        }
    
        return $carbonHolidays;
    }
}