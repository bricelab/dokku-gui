<?php

namespace App\Controller;

use App\Entity\Parameters;
use App\Form\ParametersType;
use App\Repository\ParametersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/parameters')]
class ParametersController extends AbstractController
{
    #[Route('/', name: 'parameters_index', methods: ['GET'])]
    public function index(ParametersRepository $parametersRepository): Response
    {
        return $this->render('parameters/index.html.twig', [
            'parameters' => $parametersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'parameters_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $parameter = new Parameters();
        $form = $this->createForm(ParametersType::class, $parameter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($parameter);
            $entityManager->flush();

            return $this->redirectToRoute('parameters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parameters/new.html.twig', [
            'parameter' => $parameter,
            'form' => $form,
        ]);
    }

    #[Route('/{configName}', name: 'parameters_show', methods: ['GET'])]
    public function show(Parameters $parameter): Response
    {
        return $this->render('parameters/show.html.twig', [
            'parameter' => $parameter,
        ]);
    }

    #[Route('/{configName}/edit', name: 'parameters_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parameters $parameter): Response
    {
        $form = $this->createForm(ParametersType::class, $parameter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('parameters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parameters/edit.html.twig', [
            'parameter' => $parameter,
            'form' => $form,
        ]);
    }

    #[Route('/{configName}', name: 'parameters_delete', methods: ['POST'])]
    public function delete(Request $request, Parameters $parameter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parameter->getConfigName(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($parameter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('parameters_index', [], Response::HTTP_SEE_OTHER);
    }
}
