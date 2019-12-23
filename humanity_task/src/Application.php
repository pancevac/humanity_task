<?php


namespace App;


use App\Classes\HumanityApiV1;
use App\Classes\HumanityManager;
use App\Classes\FakeHumanityApi;

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

        $entityManager = new HumanityManager(new HumanityApiV1());

        $startDate = (new \DateTime('yesterday'));
        $endDate = (new \DateTime('today'));

        $shifts = $entityManager->getShifts($startDate, $endDate);

        return $this->template->render('list.html.twig', compact('shifts'));
    }
}