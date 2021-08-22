<?php

namespace App\Quiz\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __invoke()
    {
        return $this->render('quiz_home.html.twig');
    }

}