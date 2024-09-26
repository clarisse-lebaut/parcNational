<?php 
// require_once 'ConnectBDD.php';

class News {
    private $id;
    private $title;
    private $published_date;
    private $published_time;
    private $picture;
    private $content;

    //§ id
    //* Récupérer la valeur de l'id
    public function get_id(){
        return $this->id;
    }
    //* Modifer la valeur de l'id
    public function set_id($id){
        $this->id = $id;
        return $this;
    }

    //§ title
    //* Récupérer la valeur du titre
    public function get_title(){
        return $this->title;
    }
    //* Modifier la valeur du titre
    public function set_title($title){
        $this->title = $title;
        return $this;
    }

    //§ date de publication
    //* Récupérer la valeur de la date de publication
    public function get_published_date(){
        return $this->published_date;
    }
    //* Modifer la valeur de la date de publication
    public function set_published_date($published_date){
        $this->published_date = $published_date;
        return $this;
    }

    //§ heure de la publication
    //*  Récupérer la valeur de l'heure de publication
    public function get_published_time(){
        return $this->published_time;
    }
    //* Modifier la valeur de l'heure de publication
    public function set_published_time($published_time){
        $this->published_time = $published_time;
        return $this;
    }

    //§ picture
    //* Récupérer la valeur de l'image
    public function get_picture(){
        return $this->picture;
    }
    //* Modifier la valeur de l'image
    public function set_picture($picture){
        $this->picture = $picture;
        return $this;
    }

    //§ content
    //* Récupérer la valeur du contenue
    public function get_content(){
        return $this->content;
    }
    //* Modifier la valeur du contenue
    public function set_content($content){
        $this->content = $content;
        return $this;
    }

    //+ Requête pour récupérer les données dans la base de donnée
    public function get_news($bdd){
        $sql = "SELECT * FROM news";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}