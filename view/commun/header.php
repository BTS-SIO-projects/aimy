<!DOCTYPE html>
<html>

<head>
  <title>AIMY</title>
  <link rel="stylesheet" type="text/css" href="style/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="style/css/bootstrap.min.css.map" />
  <link rel="stylesheet" type="text/css" href="style/css/style.css" />
</head>

<body>
  <?php
  if (!isset($_SESSION['email'])) {
  ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php?page=default">AIMY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" href="index.php?page=faq">Centre d'aide</a>
            <a class="nav-link" href="index.php?page=patient">S'inscrire/Se connecter</a>
          </div>
        </div>
      </div>
    </nav>
  <?php
  } else {
  ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php?page=default">AIMY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" href="index.php?page=faq">Centre d'aide</a>
            <a class="nav-link" href="index.php?page=rdv">Rendez-vous</a>
            <a class="nav-link" href="index.php?page=document">Documents</a>
            <a class="nav-link" href="index.php?page=deconnexion">Deconnexion</a>
          </div>
        </div>
        <a class="user-info" href="index.php?page=profil">Profil</a>

      </div>
    </nav>
  <?php
  }
  ?>