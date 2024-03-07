<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class CourseBillCreated
{
    use Dispatchable;

    public int $courseBillId;

    /**
     * Create a new event instance.
     */
    public function __construct($courseBillId)
    {
        $this->courseBillId = $courseBillId;
    }
}
