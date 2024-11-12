<?php

require_once 'Controller.php';

class AboutController extends Controller
{

    public function about()
    {
        $this->render('about');

        // Enregistrer la visite pour la page d'accueil uniquement
        $this->enregistrerVisite('about');
    }

}