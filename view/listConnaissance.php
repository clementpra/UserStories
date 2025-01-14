<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once '../header.php'; ?>
    <title>Connaissances</title>
</head>

<body>
    <?php require_once '../navbar.php'; ?>

    <div class="card shadow-lg rounded m-3">
        <div class="card-header">
            <h5>Toute les connaissances</h5>
        </div>
        <div class="card-body">
            <button class="btn btn-outline-secondary" id="toggleLastName" activé="false">Afficher les noms de famille</button>
            <div class="container" id="connaissances">

            </div>
        </div>
    </div>
</body>
<script src="../relation.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        getAllRelation("getAllRelationForShow", 0);

    });
</script>

</html>