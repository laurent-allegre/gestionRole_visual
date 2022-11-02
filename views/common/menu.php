<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="<?= URL; ?>accueil">Accueil</a>
        </li>
        <?php if(!Securite::estConnecte()) : ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>login">Se connecter</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>creerCompte">Créer compte</a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>compte/profil">Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?= URL; ?>compte/deconnexion">Se déconnecter</a>
          </li>
        <?php endif; ?>
        <?php if(Securite::estConnecte() && Securite::estAdministrateur()) : ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Administration
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="<?= URL; ?>administration/droits">Gérer les droits</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>