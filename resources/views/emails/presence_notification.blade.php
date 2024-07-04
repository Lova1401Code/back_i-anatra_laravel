<!DOCTYPE html>
<html>
<head>
    <title>Notification de Présence</title>
</head>
<body>
    <h1>Notification de Présence</h1>
    <p>Bonjour,</p>
    <p>Nous vous informons que votre enfant {{ $eleve->nom }} {{ $eleve->prenom }} a été marqué présent pour {{ $type }} le {{ $eleve->date }}.</p>
    <p>Cordialement,</p>
    <p>L'équipe scolaire</p>
</body>
</html>
