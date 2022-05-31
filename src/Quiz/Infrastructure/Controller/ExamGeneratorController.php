<?php

namespace App\Quiz\Infrastructure\Controller;

use App\Exam\Application\RandomExamGenerator;
use App\Exam\Domain\ApplicationId;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ExamGeneratorController extends AbstractController
{
    private SessionInterface $session;

    public function __construct(
        private readonly RandomExamGenerator $randomExamGenerator,
        RequestStack                         $requestStack,
    )
    {
        $this->session = $requestStack->getSession();
    }

    public function __invoke()
    {
        $applicationId = $this->session->get('applicationId');

        $html = $this->randomExamGenerator->__invoke(new ApplicationId($applicationId));

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream("exam.pdf", [
            "Attachment" => true
        ]);
    }


}