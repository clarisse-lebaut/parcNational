<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Actualitées</title>
</head>
<body>
    <header>
        <?php include "components/_header.php"; ?>
    </header>
    <main>
        <section>
            <h1><?php echo htmlspecialchars($news['title']); ?></h1>
        </section>

        
        <section>
            <p><?php echo htmlspecialchars($news['published_date']); ?></p>
        </section>
        
        <section>
            <p><?php echo htmlspecialchars($news['published_time']); ?></p>
        </section>
        
        <section>
            <img src="<?php echo htmlspecialchars($news['picture']); ?>"></p>
        </section>

        <aside>
            <h2>Articles récents</h2>
            <ul>
                <?php foreach ($allNews as $news): ?>
                    <li>
                        <a href="details_news?id=<?php echo $news['id']; ?>">
                            <?php echo htmlspecialchars($news['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <section>
            <p><?php echo htmlspecialchars($news['content']); ?></p>
        </section>

    </main>
    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>
</body>
</html>