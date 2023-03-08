<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\PhotoType;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('user/mes/photos')]
class MesPhotosController extends AbstractController
{
    #[Route('/', name: 'app_mes_photos_index', methods: ['GET'])]
    public function index(PhotoRepository $photoRepository): Response
    {
        return $this->render('mes_photos/index.html.twig', [
            'photos' => $photoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mes_photos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PhotoRepository $photoRepository): Response
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();
            if ($image !== null)
            {
                $fichier_nom = md5( uniqid("image")) . '.' . $image->guessExtension();
                $fichier_directory = $this->getParameter('images_directory');

                //supression de l'ancienne image
                if (is_file($fichier_directory . '/' . $photo->getImage()) && $photo->getImage() !== null)
                {
                    unlink($fichier_directory . '/' . $photo->getImage());
                }

                $image->move( $fichier_directory, $fichier_nom);
                $photo->setImage($fichier_nom);
            }
            $photoRepository->save($photo, true);

            return $this->redirectToRoute('app_mes_photos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mes_photos/new.html.twig', [
            'photo' => $photo,
            'form' => $form,
            
        ]);
    }

    #[Route('/{id}', name: 'app_mes_photos_show', methods: ['GET'])]
    public function show(Photo $photo): Response
    {
        return $this->render('mes_photos/show.html.twig', [
            'photo' => $photo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mes_photos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Photo $photo, PhotoRepository $photoRepository): Response
    {
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoRepository->save($photo, true);

            return $this->redirectToRoute('app_mes_photos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mes_photos/edit.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mes_photos_delete', methods: ['POST'])]
    public function delete(Request $request, Photo $photo, PhotoRepository $photoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$photo->getId(), $request->request->get('_token'))) {
            $photoRepository->remove($photo, true);
        }

        return $this->redirectToRoute('app_mes_photos_index', [], Response::HTTP_SEE_OTHER);
    }
}
