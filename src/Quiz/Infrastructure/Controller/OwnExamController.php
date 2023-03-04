<?php

namespace App\Quiz\Infrastructure\Controller;

use App\Quiz\Application\OwnExamGenerator;
use App\Quiz\Application\OwnExamRequest;
use App\Quiz\Application\RandomExamGenerator;
use App\Quiz\Domain\ApplicationId;
use App\Quiz\Domain\Repository\ExamRepository;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class OwnExamController extends AbstractController
{
    private SessionInterface $session;

    public function __construct(
        private readonly RandomExamGenerator $randomExamGenerator,
        private OwnExamGenerator             $ownExamGenerator,
        RequestStack                         $requestStack,
    )
    {
        $this->session = $requestStack->getSession();
    }

    public function __invoke(Request $request, ExamRepository $examRepository)
    {
        $applicationId = $this->session->get('applicationId', 1);

        if ($request->getMethod() === 'POST') {
            $ownExamRequest = new OwnExamRequest();
            $exams = $request->get('exam');
            $numberOfQuestions = $request->get('questionNumber');
            for ($i=0; $i<count($exams); $i++) {
                $examId = $exams[$i];
                $numberOfQuestion = $numberOfQuestions[$i];
                if (!is_numeric($examId) || !is_numeric($numberOfQuestion) || $numberOfQuestion < 1) {
                    continue;
                }
                $ownExamRequest->addExam($examId, $numberOfQuestion);
            }
            $html = $this->ownExamGenerator->__invoke($ownExamRequest);
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->render();
            $dompdf->stream("exam.pdf", [
                "Attachment" => true
            ]);


        }
        return $this->render(
            'quiz_own_exam_configurator.html.twig',
            [
                'exams' => $examRepository->findByApplication(new ApplicationId($applicationId))
            ]
        );
    }
}