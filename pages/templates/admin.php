<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Description" />
    <link rel="stylesheet" href="<?= BASE_PUBLIC ?>/assets/css/reset.css">
    <link rel="stylesheet" href="<?= BASE_PUBLIC ?>/assets/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="<?= BASE_PUBLIC ?>/assets/js/main.js" defer type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous" defer></script>
    <title><?= $app->title ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= URL ?>/admin">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Utilisateurs
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= URL ?>/admin/users">Voir utilisateurs</a></li>
                            <li><a class="dropdown-item" href="<?= URL ?>/admin/users/insert">Insérer utilisateur</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Catégories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= URL ?>/admin/categorys">Voir categories</a></li>
                            <li><a class="dropdown-item" href="<?= URL ?>/admin/categorys/insert">Insérer catégorie</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Produits
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= URL ?>/admin/products">Voir produits</a></li>
                            <li><a class="dropdown-item" href="<?= URL ?>/admin/products/insert">Insérer produit</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL ?>/admin/orders">Commandes</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Commentaires
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= URL ?>/admin/reviews">Voir commentaires</a></li>
                            <li><a class="dropdown-item" href="<?= URL ?>/admin/reviews/insert">Insérer commentaires</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL ?>/admin/settings">Paramètres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL ?>">Page d'accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL ?>/logout">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?= $content ?>
</body>

</html>