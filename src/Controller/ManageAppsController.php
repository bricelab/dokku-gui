<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationType;
use App\Message\Command\CloneApp;
use App\Message\Command\CreateNewApp;
use App\Message\Command\DestroyApp;
use App\Message\Command\LockApp;
use App\Message\Command\RenameApp;
use App\Message\Command\SynchronizeApps;
use App\Repository\ApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/manage/apps')]
class ManageAppsController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    #[Route('/', name: 'manage_apps_index', methods: ['GET'])]
    public function index(ApplicationRepository $applicationRepository): Response
    {
        return $this->render('manage_apps/index.html.twig', [
            'applications' => $applicationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'manage_apps_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($application);
            $entityManager->flush();

            $this->commandBus->dispatch(new CreateNewApp($application->getName()));

            return $this->redirectToRoute('manage_apps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('manage_apps/new.html.twig', [
            'application' => $application,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'manage_apps_show', methods: ['GET'])]
    public function show(Application $application): Response
    {
        return $this->render('manage_apps/show.html.twig', [
            'application' => $application,
        ]);
    }

    #[Route('/{id}/edit', name: 'manage_apps_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Application $application): Response
    {
        $old = $application->getName();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            if ($old !== $application->getName()) {
                $this->commandBus->dispatch(new RenameApp($old, $application->getName()));
            }

            return $this->redirectToRoute('manage_apps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('manage_apps/edit.html.twig', [
            'application' => $application,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'manage_apps_delete', methods: ['POST'])]
    public function delete(Request $request, Application $application): Response
    {
        if ($this->isCsrfTokenValid('delete'.$application->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($application);
            $entityManager->flush();

            $this->commandBus->dispatch(new DestroyApp($application->getName()));
        }

        return $this->redirectToRoute('manage_apps_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/synchronize', name: 'manage_apps_synchronize', methods: ['GET'])]
    public function synchronize(Request $request): Response
    {
        $this->commandBus->dispatch(new SynchronizeApps());

        return $this->redirectToRoute('manage_apps_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/clone', name: 'manage_apps_clone', methods: ['GET', 'POST'])]
    public function clone(Request $request, Application $application): Response
    {
        $form = $this->createFormBuilder()->add('new', TextType::class)->getForm()->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $new = $form->get('new')->getData();

            $app = new Application();
            $app->setName($new)->setDescription($application->getDescription());

            $this->getDoctrine()->getManager()->persist($app);
            $this->getDoctrine()->getManager()->flush();

            $this->commandBus->dispatch(new CloneApp($application->getName(), $app->getName()));

            return $this->redirectToRoute('manage_apps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('manage_apps/edit.html.twig', [
            'application' => $application,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/{lock<0|1>}', name: 'manage_apps_lock', methods: ['GET'])]
    public function lock(Request $request, Application $application, int $lock): Response
    {
        $application->setLocked(boolval($lock));

        $this->getDoctrine()->getManager()->flush();

        $this->commandBus->dispatch(new LockApp($application->getName(), boolval($lock)));

        return $this->redirectToRoute('manage_apps_index', [], Response::HTTP_SEE_OTHER);
    }
}
