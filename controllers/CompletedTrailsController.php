<?php

require_once 'Controller.php';
require_once __DIR__ . '/../models/CompletedTrails.php';

class CompletedTrailsController extends Controller{
    public function manageCompletedTrail(){
        if (isset($_SESSION['user_id'])){
            $completedTrailsObject = new CompletedTrails('completed_trails');
            $trailId = $_GET['trail_id'];
            $completedTrail = $completedTrailsObject->getCompletedTrail($trailId);
            if($completedTrail === FALSE){
                $completedTrailsObject->addCompletedTrail($trailId);
                $this->redirect('trails');
            }else{
                $completedTrailsObject->deleteCompletedTrail($trailId);
                $this->redirect('profile');
            }
        }else{
            $this->redirect('login');
        }

    }

    public function manageCompletedTrailAjax(){
        if (isset($_SESSION['user_id'])){
            $completedTrailsObject = new CompletedTrails('completed_trails');
            $trailId = $_GET['trail_id'];
            $completedTrail = $completedTrailsObject->getCompletedTrail($trailId);
            if($completedTrail === FALSE){
                $completedTrailsObject->addCompletedTrail($trailId);
            }else{
                $completedTrailsObject->deleteCompletedTrail($trailId);
            }
            exit;
        }else{
            $this->redirect('login');
        }

    }
}