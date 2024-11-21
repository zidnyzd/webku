<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Latihan Midtrans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-GLhlTQ8iRABdZLl603oVMWSktUqkB7I7fZJl13/Jr59b6EGGoI1aFkw7cmDA6j6gD" 
          crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <p>Token : <?= $token; ?></p>
                        <a href="https://app.sandbox.midtrans.com/snap/v2/vtweb/<?= $token; ?>" 
                           target="_blank" 
                           class="btn btn-outline-info">
                           Bayar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-w76AghRfdOBD5zEHJrYeFZ94A6KA-IOyzpE6M1mYQU6Bnh60v8KIYtKUM0T9MOa" 
            crossorigin="anonymous">
    </script>
</body>
</html>
