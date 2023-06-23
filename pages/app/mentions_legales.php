<main class="about-container grid">
    <h1><?= $title ?></h1>
    <div class="error-container" style="<?= !empty($_SESSION['message']) ? "display: block;" : "display: none;"  ?>"><?= isset($_SESSION['message']) ? $_SESSION['message'] : ""  ?></div>
    <div class="mentions-data grid">
        <h2> Éditeur du site :</h2>
        <ul>
            <li><?= $settings->getEtp_name() ?></li>
            <li>Adresse : <?= $settings->getLocation() ?></li>
            <li>Téléphone : <?= $settings->getNum() ?></li>
            <li>E-mail : <?= $settings->getEmail() ?></li>
        </ul>
        <h2>Hébergement du site :</h2>
        <ul>
            <li>Nom de l'hébergeur : <?= $settings->getHost_name() ?></li>
            <li>Adresse : <?= $settings->getHost_location() ?></li>
            <li>Téléphone : <?= $settings->getHost_number() ?></li>
        </ul>
        <h2>
            Propriété intellectuelle :

        </h2>
        <p>
            Le contenu du site <?= $settings->getEtp_name() ?> (textes, images, vidéos, logos, etc.) est protégé par le droit d'auteur et autres lois relatives à la propriété intellectuelle. Toute reproduction, distribution, modification ou utilisation sans autorisation préalable de l'éditeur est strictement interdite.
        </p>
        <h2>Données personnelles :</h2>

        <p> <?= $settings->getEtp_name() ?> collecte et traite les données personnelles conformément à sa politique de confidentialité. Les informations recueillies sont utilisées dans le but de fournir les services demandés par les utilisateurs et de leur offrir une expérience personnalisée sur le site. Les utilisateurs ont le droit d'accéder à leurs données, de les rectifier ou de les supprimer en contactant <?= $settings->getEtp_name() ?> via les coordonnées fournies ci-dessus.</p>

        <h2>Liens externes :</h2>

        <p>Le site <?= $settings->getEtp_name() ?> peut contenir des liens vers des sites externes. L'éditeur n'assume aucune responsabilité quant au contenu ou à la politique de confidentialité de ces sites tiers.</p>

        <h2>Limitation de responsabilité :</h2>

        <p> <?= $settings->getEtp_name() ?> met tout en œuvre pour s'assurer de l'exactitude et de la mise à jour des informations présentes sur le site. Cependant, l'éditeur ne peut garantir l'absence d'erreurs ou d'omissions. En aucun cas, <?= $settings->getEtp_name() ?> ne pourra être tenu responsable des dommages directs ou indirects résultant de l'utilisation du site.</p>

        <h2>Droit applicable et juridiction compétente :</h2>

        <p>Les présentes mentions légales sont régies par la loi française. Tout litige relatif au site <?= $settings->getEtp_name() ?> relèvera de la compétence exclusive des tribunaux français.</p>

        <p>Date de dernière mise à jour : 23 juin 2023</p>
    </div>
</main>