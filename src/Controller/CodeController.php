<?php

namespace App\Controller;

use App\Form\CodeType;
use App\Service\GenerateCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CodeController extends AbstractController
{
    private GenerateCode $generateCode;

    public function __construct(GenerateCode $generateCode)
    {
        $this->generateCode = $generateCode;
    }

    /**
     * @Route("/", name="code")
     */
    public function index(Request $request): Response
    {

        $form = $this->createForm(CodeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->generateCode->generate($data['numberOfCodes'], $data['lengthCode']);
        }

        return $this->render('code/index.html.twig', [
            'codeForm' => $form->createView(),
        ]);
    }
}
