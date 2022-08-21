<?php

namespace App\Controller;

use App\Form\FileUploadType;
use App\Service\ClientService;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    #[Route('/upload', name: 'upload')]
    public function index(Request $request, FileUploader $fileUploader, ClientService $clientService): Response
    {
        $form = $this->createForm(FileUploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['upload_file']->getData();

            if ($file) {
                $fileName = $fileUploader->upload($file);

                $directory = $fileUploader->getTargetDirectory();
                $fullPath = $directory.'/'.$fileName;

                $result = $clientService->processFile($fullPath);

                if ($result['success']) {
                    $this->addFlash('success', $result['message']);
                } else {
                    $form->addError(new FormError($result['error']));
                }
            }
        }

        return $this->render('upload/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
