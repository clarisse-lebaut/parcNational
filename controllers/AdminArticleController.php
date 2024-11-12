<?php
require_once 'Controller.php';
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/News.php'; // Modèle de news

class AdminArticleController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new News('news'); // Utilisation du modèle NewsModel
    }

    //* Méthode pour afficher la vue des administrateurs
    public function manageArticles()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && !empty($_POST['id'])) {
            $article_id = intval($_POST['id']);
            $deleteSuccess = $this->model->deleteNews($article_id);

            if ($deleteSuccess) {
                $this->redirect('manage_article');
                exit;
            } else {
                echo "Erreur : Impossible de supprimer cet article.";
            }
        }

        $articles = $this->model->get_news();
        $countArticles = count($articles);

        if ($countArticles !== false && !empty($articles)) {
            $this->render('manage_article', [
                'total_articles' => $countArticles,
                'articles' => $articles
            ]);
        } else {
            echo "Erreur lors du chargement des articles.";
        }
    }

    public function createArticle()
    {
        $isEdit = false;
        $articleData = [];

        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $isEdit = true;
            $article_id = intval($_POST['id']);
        } elseif (isset($_GET['id']) && !empty($_GET['id'])) {
            $isEdit = true;
            $article_id = intval($_GET['id']);
        }

        if ($isEdit) {
            $article = $this->model->get_news_by_id($article_id);
            if ($article) {
                $articleData = [
                    'id' => $article['id'] ?? '',
                    'title' => $article['title'] ?? '',
                    'published_date' => $article['published_date'] ?? '',
                    'published_time' => $article['published_time'] ?? '',
                    'picture' => $article['picture'] ?? '',
                    'content' => $article['content'] ?? '',
                ];
            } else {
                echo "Erreur : Article non trouvé.";
                return;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $published_date = $_POST['published_date'] ?? '';
            $published_time = $_POST['published_time'] ?? '';
            $content = $_POST['content'] ?? '';
            $errors = [];

            $picture = null;
            if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
                $pictureTmpPath = $_FILES['picture']['tmp_name'];
                $pictureName = basename($_FILES['picture']['name']);
                $uploadDir = __DIR__ . '/../uploads/';
                $picturePath = $uploadDir . $pictureName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (move_uploaded_file($pictureTmpPath, $picturePath)) {
                    $picture = 'uploads/' . $pictureName;
                } else {
                    $errors[] = "Erreur lors de l'upload de l'picture.";
                }
            }

            if (empty($title)) $errors[] = 'Le titre est requis.';
            if (empty($published_date)) $errors[] = 'La date de publication est requise.';
            if (empty($published_time)) $errors[] = 'L\'heure de publication est requise.';
            if (empty($content)) $errors[] = 'Le contenu est requis.';

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>";
                }
            } else {
                if ($isEdit) {
                    $updateSuccess = $this->model->updateNews(
                        $article_id,
                        $title,
                        $published_date,
                        $published_time,
                        $picture ?: $articleData['picture'], // Vérifiez ici,
                        $content
                    );

                    if ($updateSuccess) {
                        $this->redirect('manage_article');
                        exit;
                    } else {
                        echo 'Erreur lors de la mise à jour de l\'article.';
                    }
                } else {
                    if ($this->model->createNews($title, $published_date, $published_time, $picture, $content)) {
                        $this->redirect('manage_article');
                        exit;
                    } else {
                        echo 'Erreur lors de la création de l\'article.';
                    }
                }
            }
        }

        $this->render('create_articles', ['articleData' => $articleData, 'isEdit' => $isEdit]);
    }
}
