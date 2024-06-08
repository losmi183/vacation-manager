<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    private $statusNames = [
        1 => 'Na čekanju',
        2 => 'Odobren',
        3 => 'Odbijen'
    ];

    protected $guarded = ['id'];

    protected $dates = ['date_from', 'date_to'];

        // Definirajte accessor za status_name
    public function getStatusNameAttribute()
        {    
            return $this->statusNames[$this->status] ?? 'Nepoznat status';
        }
    
        // Osigurajte da je status_name uključen u serializaciju modela
        protected $appends = ['status_name'];
}
