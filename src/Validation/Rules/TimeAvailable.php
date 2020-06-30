<?php
namespace App\Validation\Rules;

use App\Models\Appointment;
use Respect\Validation\Rules\AbstractRule;

class TimeAvailable extends AbstractRule
{
    public function validate($input) : bool
    {
        $date = new \DateTime($input);

        if($date->format('H') < 9 || $date->format('H') > 17)
        {
            return false;
        }
        $appointments = Appointment::all();
        foreach($appointments as $appointment)
        {

            $a = new \DateTime($appointment->time);
            if(
                $a->format('Y') == $date->format('Y') &&
                $a->format('m') == $date->format('m') &&
                $a->format('d') == $date->format('d') &&
                $a->format('H') == $date->format('H')
                )
            {
                return false;
            }
        }

        return true;
    }
}