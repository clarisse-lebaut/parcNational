<?php

require_once 'Controller.php';
require_once __DIR__ . '/../model/FavoriteTrail.php';

class FavoritesTrailsController extends Controller{
    public function manageFavoriteTrail(){
        var_dump('crazy');
        $favoriteTrailObject  = new FavoriteTrail('favorites_trails');
        $trailId = $_GET['trail_id'];
        $favoriteTrail = $favoriteTrailObject->getFavoriteTrail($trailId);
        if($favoriteTrail === false){
            $favoriteTrailObject->addFavoriteTrail($trailId);
        }else{
            $favoriteTrailObject->deleteFavoriteTrail($trailId);
        }
        
    }
}