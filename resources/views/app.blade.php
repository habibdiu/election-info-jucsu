<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-5">
        <h2 class="mb-5">JUCSU Election 2025</h2>
        <div class="row justify-content-center">
            <div class="col-md-3 mb-5">
                <a href="{{ route('member_candidate.list') }}" class="btn btn-primary btn-block py-2">
                    Member Candidates
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('position.list') }}" class="btn btn-success btn-block py-2">
                    Member Position
                </a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
