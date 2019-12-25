<?php


namespace App;


use App\Api\HumanityApiV1;
use App\Api\HumanityApiV2;
use App\Classes\HumanityManager;

class Application
{
    protected $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    /**
     * Boot the app.
     *
     * @return string
     * @throws \Exception
     */
    public function boot(): string
    {
        // set time/zone of app
        date_default_timezone_set('Europe/Belgrade');

        // Here, we can swap different concrete implementation of Humanity API
        $entityManager = new HumanityManager(new HumanityApiV1());

        // Define time interval for shifts
        $startDate = new \DateTime('today');
        $endDate = new \DateTime('today');

        $shifts = $entityManager->getShifts($startDate, $endDate);

        return $this->template->render('index.html.twig', compact('shifts'));
    }
}