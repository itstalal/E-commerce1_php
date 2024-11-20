<?php include './header.php'; ?>
<?php include './navbar.php'; ?>
<body style="font-family: Arial, sans-serif;">
    

<div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 style=" color: #333;">À Propos de Nous</h1>
                <p class="lead" style="font-size: 1.25rem">Découvrez notre histoire, notre équipe et notre passion pour les jeux vidéo.</p>
            </div>
        </div>

        <!-- Section: History -->
        <div class="row mt-4">
            <div class="col-md-6">
                <h2 style=" color: #333;">Notre Histoire</h2>
                <p>Nous sommes une équipe de passionnés de jeux vidéo qui a commencé cette aventure en 2010. Depuis lors, nous avons créé de nombreux jeux primés et continuons à innover dans le domaine.</p>
            </div>
            <div class="col-md-6">
                <img src="images/th2.png"  class="img-fluid" alt="Notre Histoire">
            </div>
        </div>

        <!-- Section: Team -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h2>Notre Équipe</h2>
            </div>
            <div class="col-md-4">
                <div class="card" style=" margin-bottom: 20px;">
                    <img src="path/to/your/image1.jpg" class="card-img-top" alt="Membre 1">
                    <div class="card-body">
                        <h5 class="card-title">Nom Membre 1</h5>
                        <p class="card-text">Description du membre 1.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="path/to/your/image2.jpg" class="card-img-top" alt="Membre 2">
                    <div class="card-body">
                        <h5 class="card-title">Nom Membre 2</h5>
                        <p class="card-text">Description du membre 2.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="path/to/your/image2.jpg" class="card-img-top" alt="Membre 2">
                    <div class="card-body">
                        <h5 class="card-title">Nom Membre 2</h5>
                        <p class="card-text">Description du membre 2.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="path/to/your/image2.jpg" class="card-img-top" alt="Membre 2">
                    <div class="card-body">
                        <h5 class="card-title">Nom Membre 2</h5>
                        <p class="card-text">Description du membre 2.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="path/to/your/image3.jpg" class="card-img-top" alt="Membre 3">
                    <div class="card-body">
                        <h5 class="card-title">Nom Membre 3</h5>
                        <p class="card-text">Description du membre 3.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section: Contact -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h2>Contactez-Nous</h2>
                <form id="contactForm">
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" id="name" placeholder="Votre Nom">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Votre Email">
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" rows="3" placeholder="Votre Message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
<?php include './footer.php'; ?>
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const contactForm = document.getElementById('contactForm');

    contactForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;

        if (name && email && message) {
            alert(`Merci ${name}, nous avons bien reçu votre message !`);
            contactForm.reset();
        } else {
            alert('Veuillez remplir tous les champs.');
        }
    });
});

    </script>
</body>
</html>