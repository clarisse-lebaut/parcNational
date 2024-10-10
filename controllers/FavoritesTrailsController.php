<?php

require_once 'Controller.php';
require_once __DIR__ . '/../model/FavoriteTrail.php';

class FavoritesTrailsController extends Controller{
    public function manageFavoriteTrail(){
        $favoriteTrailObject  = new FavoriteTrail('favorites_trails');
        $trailId = $_GET['trail_id'];
        $favoriteTrail = $favoriteTrailObject->getFavoriteTrail($trailId);
        if($favoriteTrail === false){
            $favoriteTrailObject->addFavoriteTrail($trailId);
            $this->redirect('trails');
        }else{
            $favoriteTrailObject->deleteFavoriteTrail($trailId);
            $this->redirect('profile');
        }

        
    }

}