<?php

namespace App\Controller;

use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapGismentController extends AbstractController
{
    #[Route('user/MapGisment', name: 'app_mapGisment')]
    public function index(PhotoRepository $photoRepository): Response
    {

        $photos = $photoRepository->findAll();

        return $this->render('mapGisement.html.twig', [
            'photos' => $photos
        ]);
    }

    // #[Route('/test', name: 'app_test')]
    // public function testindex(): Response
    // {
    //     return $this->render('mes_photos/test.html', [
    //     ]);
    // }
}
