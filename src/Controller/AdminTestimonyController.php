<?php

namespace App\Controller;

use App\Entity\Testimony;
use App\Form\TestimonyType;
use App\Repository\TestimonyRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/testimony')]
class AdminTestimonyController extends AbstractController
{
    #[Route('/', name: 'app_admin_testimony_index', methods: ['GET'])]
    public function index(TestimonyRepository $testimonyRepository): Response
    {
        return $this->render('admin_testimony/index.html.twig', [
            'testimonies' => $testimonyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_testimony_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $testimony = new Testimony();
        $testimony->setCreatedAt(new DateTimeImmutable());
        $form = $this->createForm(TestimonyType::class, $testimony);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($testimony);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_testimony_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_testimony/new.html.twig', [
            'testimony' => $testimony,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_testimony_show', methods: ['GET'])]
    public function show(Testimony $testimony): Response
    {
        return $this->render('admin_testimony/show.html.twig', [
            'testimony' => $testimony,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_testimony_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Testimony $testimony, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TestimonyType::class, $testimony);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_testimony_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_testimony/edit.html.twig', [
            'testimony' => $testimony,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_testimony_delete', methods: ['POST'])]
    public function delete(Request $request, Testimony $testimony, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$testimony->getId(), $request->request->get('_token'))) {
            $entityManager->remove($testimony);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_testimony_index', [], Response::HTTP_SEE_OTHER);
    }
}
