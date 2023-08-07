<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $name = $form->get('name')->getData();
            $firstname = $form->get('firstname')->getData();
            $email = $form->get('email')->getData();
            $subject = $form->get('subject')->getData();
            $content = $form->get('content')->getData();

            $email = (new Email())
                ->from($email)
                ->to('gambiervictoria@hotmail.fr')
                ->subject($subject)
                ->text($content)
                ->html('<p>See Twig integration for better HTML integration!</p>');

            $mailer->send($email);
            
            return $this->redirectToRoute('app_success');
            
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form,
        ]);
    }

    #[Route('/contact/success', name: 'app_success')]
    public function success(): Response
    {
        return $this->render('success/index.html.twig', [
            'controller_name' => 'SuccessController',
        ]);
    }
}
