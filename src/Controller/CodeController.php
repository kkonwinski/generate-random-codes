<?php

namespace App\Controller;

use App\Form\CodeType;
use App\Service\GenerateFile;
use App\Service\GenerateCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class CodeController extends AbstractController
{
    private GenerateCode $generateCode;
    private GenerateFile $generateFile;

    public function __construct(GenerateCode $generateCode, GenerateFile $generateFile)
    {


        $this->generateCode = $generateCode;
        $this->generateFile = $generateFile;
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
            $this->generateFile->createFile();
            $writeCode = $this->generateFile->writeCodesToFile($randomCodes);


            return $this->render('code/index.html.twig', [
                'codeForm' => $form->createView(),
                'fileIsWrite' => $writeCode
            ]);
        }

        return $this->render('code/index.html.twig', [
            'codeForm' => $form->createView(),
            'fileIsWrite' => false

        ]);
    }

    /**
     * @Route("/download", name="download_file")
     **/
    public function downloadFileAction():BinaryFileResponse
    {
        $response = new BinaryFileResponse('../tmp/kody.txt');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'kody.txt');

        return $response;
    }
}
