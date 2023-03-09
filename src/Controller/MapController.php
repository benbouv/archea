<?php

namespace App\Controller;

use App\Repository\GeolocalisationRepository;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    #[Route('/map', name: 'app_map')]
    public function index(PhotoRepository $photoRepository, GeolocalisationRepository $geolocalisationRepository): Response
    {

        $photos = $photoRepository->findAll();
        $gisments = $geolocalisationRepository->findAll();

        return $this->render('map/index.html.twig', [
            'controller_name' => 'MapController',
            'photos' => $photos,
            'gisments' => $gisments
        ]);
    }
}
