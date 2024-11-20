<?php include './header.php' ?>

<body>
<?php include './navbar.php'; ?>
<div class="container mt-5">
    <h1 class="text-center">Page de Support</h1>
    <p class="text-center">Comment pouvons-nous vous aider?</p>

    <div class="row mt-4">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <h5 class="card-title">FAQ</h5>
            <p class="card-text">Trouvez des réponses aux questions fréquemment posées.</p>
            <a href="https://ask-crew.com/dem/g2/ca/?utm_source=bing&utm_medium=cpc&utm_campaign=603666784&utm_term=faq%20games&utm_content=1332610502527442&msclkid=eed9b8e82ee51a1e4309de69b02343cd" class="btn btn-primary">Voir la FAQ</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <h5 class="card-title">Assistance par Email</h5>
            <p class="card-text">Contactez-nous par email pour obtenir de l'aide.</p>
            <a href="#" class="btn btn-primary">Envoyer un Email</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <h5 class="card-title">Support Téléphonique</h5>
            <p class="card-text">Appelez notre équipe de support pour une assistance immédiate.</p>
            <a href="#" class="btn btn-primary">Appeler le Support</a>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-5">
      <h3 class="text-center">Envoyer une Demande</h3>
      <form>
        <div class="form-group">
          <label for="name">Nom</label>
          <input type="text" class="form-control" id="name" placeholder="Entrez votre nom">
        </div>
        <div class="form-group">
          <label for="email">Adresse Email</label>
          <input type="email" class="form-control" id="email" placeholder="Entrez votre email">
        </div>
        <div class="form-group">
          <label for="message">Message</label>
          <textarea class="form-control" id="message" rows="5" placeholder="Décrivez votre problème ou question"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
    </div>
  </div>

 <?php include './footer.php'; ?>
</body>
</html>
