# parcNational

--> pour acceder aux images dans le fichier assets et dans la base de donnée : 
/parcNational/ 
important parce que l'URL est préconfiguré dans l'index, l'URL contient automatiquement cet aspect

--> pour avoir accées juste de base aux images dans la base de donnée, meme si elles sont pas trouvé 
a cause du chemin relatif : 

cela se passe dans la méthode d'appel dans "NomDeLaPageController" ($this->render('home', ['news' => $news]);), il faut que la variable présent dans la view soit la meme pour être accessible et reconnue.

    // Méthode pour afficher toutes les news dans la page home
    public function news(){ 
        // Récupérer les news en utilisant le modèle
        $news = $this->newsModel->get_news($this->bdd);
        // Afficher la vue 'news' avec les données récupérées
        $this->render('home', ['news' => $news]);
    }