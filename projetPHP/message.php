<?php
$message = getMessage();



?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">Titre</th>
            <th scope="col">Envoyeur</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Examen final</td>
            <td>Steve Jobs</td>
            <td>
                <button class="btn btn-success btn-sm" onclick="readItem('Examen final')">Lire</button>
                <button class="btn btn-danger btn-sm" onclick="deleteItem('Examen final')">Effacer</button>
            </td>
        </tr>

    </tbody>
</table>