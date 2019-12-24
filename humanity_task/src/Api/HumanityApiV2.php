<?php


namespace App\Api;


use App\Entities\Shift;

class HumanityApiV2 extends GenericHumanity
{

    /**
     * Create and return new shift object with data.
     *
     * @param $shiftData
     * @return Shift
     */
    protected function createShift($shiftData): Shift
    {
        // TODO: Implement hydrateShift() method.
    }

    /**
     * Call lifecycle method to signal child class for calling requests...
     *
     * @return void
     */
    protected function sendRequests(): void
    {
        // TODO: Implement sendRequests() method.
    }
}