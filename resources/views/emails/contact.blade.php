<!-- resources/views/emails/contact.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message de contact</title>
</head>
<body>
    <p>Nom: {{ $data['name'] }}</p>
    <p>Email: {{ $data['email'] }}</p>
    <p>Message:</p>
    <p>{{ $data['message'] }}</p>
</body>
</html>
