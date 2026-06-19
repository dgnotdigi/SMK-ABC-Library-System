<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Circulation Rules
    |--------------------------------------------------------------------------
    |
    | Tune these to match your school's actual policy. They're read by
    | App\Services\CirculationService.
    |
    */

    'loan_days' => env('LIBRARY_LOAN_DAYS', 14),

    'fine_cents_per_day' => env('LIBRARY_FINE_CENTS_PER_DAY', 25),

    'max_checkouts_per_student' => env('LIBRARY_MAX_CHECKOUTS_PER_STUDENT', 5),

];
