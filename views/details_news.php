<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Actualitées</title>
    <link rel="stylesheet" href="assets/style/user/details_news.css">
</head>
<body>
    <header>
        <?php include "components/_header.php"; ?>
    </header>

    <main class="main-container">
        <article class="main-article">
            <h1 class="title-news"><?php echo htmlspecialchars($news['title']); ?></h1>

            <section class="date_and_time">
                <p><i>publié le : </i><?php echo htmlspecialchars($news['published_date']); ?></p>
                <p><i>à : </i><?php echo htmlspecialchars($news['published_time']); ?></p>
            </section>
                
            <section class="pic_container">
                <img class="news-pic" src="<?php echo htmlspecialchars($news['picture']); ?>" alt="">
            </section>

            <section>
                <p><?php echo htmlspecialchars($news['content']); ?></p>
            </section>
        </article>

        <aside class="recent-articles">
            <h2>Articles récents</h2>
            <div>
                <?php foreach ($allNews as $news): ?>
                    <article>
                        <a href="details_news?id=<?php echo $news['id']; ?>">
                            <img src="<?php echo htmlspecialchars($news['picture']); ?>" alt="">
                            <p><?php echo htmlspecialchars($news['title']); ?></p>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </aside>
    </main>

    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>
</body>
</html>
