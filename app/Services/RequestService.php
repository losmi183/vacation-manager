<?php 

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
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

    /**
     * managerTeamRequests - get requests for team manager
     * multiple teams is assigned
     * 
     * @return array
     */
    public function managerTeamRequests(): array
    {
        // Get manager teams
        $managerTeamIds = $this->teamService->managerTeamIds();

        $allTeamsRequests = [];

        // Foreach all teams
        foreach ($managerTeamIds as $managerTeamId) {
            // Get users in team
            $userInTeamIds = $this->teamRepository->userInTeamIds($managerTeamId);
            // Get team requests - request for user ids
            $teamRequestsAll = $this->requestRepositiry->teamRequestsAll($userInTeamIds);
            $obj = new \stdClass;
            $obj->team_id = $managerTeamId;
            $obj->requests = $teamRequestsAll;
            array_push($allTeamsRequests, $obj);
        }
        return $allTeamsRequests;
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

    public function managerResolveRequest($id)
    {
        // Check if request exists and status is Cekanje
        $status = config('settings.status');
        $request = $this->requestRepositiry->getRequestWithStatus($id, $status['Cekanje']);
        // Abort if not found
        if (!$request) {
            abort(400, 'Not found unresolved request.');
        }

        /**
         * Checking if manager have rights to resolve request
         */
        $managerTeamIds = $this->teamService->managerTeamIds();

        $allManagerUsers = [];

        foreach ($managerTeamIds as $managerTeamId) {
            // Get users in team
            $users = $this->teamRepository->userInTeamIds($managerTeamId);
            // Add to allManagerUsers
            $allManagerUsers = array_merge($allManagerUsers, $users);
        }
        // Check if user (request) is in manager team
        if (!in_array($request->user_id, $allManagerUsers)) {
            abort(400, 'You have no rights to resolve this request.');
        }

        /**
         * Get other unresolved team requests
         */
        $user = User::find($request->user_id);
        $usersInTeam = $this->teamRepository->userInTeamIds($user->team_id);

        // Finaly all team requests with status Odobren
        $teamAllRequests = $this->requestRepositiry->teamApprovedRequests($usersInTeam, $status['Odobren']);


        /**
         * Checking dates between request and team requests
         */
        $overlappingRequest = false;
        $newStart = Carbon::parse($request->date_from);
        $newEnd = Carbon::parse($request->date_to);
        foreach ($teamAllRequests as $req) {
            $existingStart = Carbon::parse($req->date_from);
            $existingEnd = Carbon::parse($req->date_to);
        
            // Provera da li se novi period preklapa sa postojećim periodom
            if ($newStart <= $existingEnd && $newEnd >= $existingStart) {
                // Ako postoji preklapanje, postavljamo $overlappingRequest na $req i izlazimo iz petlje
                $overlappingRequest = $req;
                break;
            }
        }
        
        if ($overlappingRequest) {
            abort(400, 'Request overlaps with request from teammate(s)');
        }
        dd(1);
    }
}