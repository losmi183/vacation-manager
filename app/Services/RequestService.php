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

    public function __construct(RequestRepositiry $requestRepositiry, UserService $userService) {
        $this->requestRepositiry = $requestRepositiry;
        $this->userService = $userService;
    }   

    public function requests(): Collection
    {
        $user = $this->userService->loggedUser();
        return $this->requestRepositiry->requests($user->id);
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