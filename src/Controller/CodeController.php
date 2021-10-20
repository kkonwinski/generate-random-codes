<?php

namespace App\Controller;

use App\Form\CodeType;
use App\Service\GenerateCodeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CodeController extends AbstractController
{
    private GenerateCodeService $generateCode;

    public function __construct(GenerateCodeService $generateCode)
    {
        $this->generateCode = $generateCode;
    }

    /**
     * @Route("/", name="code")
     * @throws \Exception
     */
    public function index(Request $request): Response
    {

        $form = $this->createForm(CodeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $randomCodes = $this->generateCode->generate($data['numberOfCodes'], $data['lengthCode']);
        }

        return $this->render('code/index.html.twig', [
            'codeForm' => $form->createView(),
        ]);
    }
}
