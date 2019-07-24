<?php

namespace App\Controller;


use App\Entity\Quack;
use App\Form\QuackType;
use App\Repository\QuackRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quack")
 */
class QuackController extends AbstractController
{
    /**
     * @Route("/", name="quack_index", methods={"GET"})
     */
    public function index(QuackRepository $quackRepository): Response
    {

        return $this->render('quack/index.html.twig', [
            'quacks' => $quackRepository->findBy(['parent' => null]),

        ]);

    }

    /**
     * @Route("/new", name="quack_new", methods={"GET","POST"})
     * @Route("/{parent}/comment/new", name="quack_new_comment", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader, ?Quack $parent): Response
    {
        $quack = new Quack();
        $form = $this->createForm(QuackType::class, $quack);
        if ($parent) {
            $quack->setParent($parent);
            $form->remove("pic")->remove("tags");
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $quack->setAuthor($this->getUser());

            if (!$parent) {
                /** @var UploadedFile $pictureFile */
                $pictureFile = $form['pic']->getData();
                if ($pictureFile) {
                    $pictureFileName = $fileUploader->upload($pictureFile);
                    $quack->setPic('/uploads/' . $pictureFileName);
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quack);
            $quack->setCreatedAt(new \DateTime('now'));
            $entityManager->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack/new.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quack_show", methods={"GET"})
     */
    public function show(Quack $quack): Response
    {
        //$this->denyAccessUnlessGranted('quack_show', $quack);

        return $this->render('quack/show.html.twig', [
            'quack' => $quack,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="quack_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quack $quack, FileUploader $fileUploader): Response
    {
        $this->denyAccessUnlessGranted('quack_edit', $quack);

        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $pictureFile */
            $pictureFile = $form['pic']->getData();
            if ($pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);
                $quack->setPic('/uploads/' . $pictureFileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack/edit.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quack_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Quack $quack): Response
    {
        if ($this->isCsrfTokenValid('delete' . $quack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quack_index');
    }
}
