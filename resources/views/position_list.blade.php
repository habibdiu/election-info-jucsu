<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Position List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg rounded-3">
                <div class="card-body">
                    <div class="position-relative mb-3">
                        <h3 class="fw-bold text-center mb-0">Position List</h3>
                        <a href="{{ route('position.add') }}" class="btn btn-primary btn-sm position-absolute end-0 top-50 translate-middle-y">
                            <i class="fa-solid fa-plus"></i> Add
                        </a>
                    </div>


                    @if (session('error'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Failed!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div id="success"></div>
                    <div id="failed"></div>
                    <div class="table-responsive" id="print_data">
                        <table id="dataTableExample" class="table table-hover table-striped table-sm align-middle table-responsive">
                            <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Total Candidate</th>
                                <th>Max Valid Vote</th>
                                <th>Min Valid Vote</th>
                                <th>Election Area</th>
                                <th>Priority</th>
                                <th style="width:15%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['position_list'] as $index => $single_position)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $single_position->name }}</td><td>{{ $single_position->position->name ?? '-' }}</td>
                                        <td>{{ $single_position->details }}</td>
                                        <td>{{ $single_position->election_area->name ?? '-' }}</td>
                                        <td>{{ $single_position->member_no }}</td>
                                        <td>{{ $single_position->ballot_no }}</td>
                                        <td>
                                            <a href="{{ route('position.edit', $single_position->id) }}"
                                            class="btn btn-success btn-sm"><i class="fa-solid fa-edit"></i></a>
                                            <button class="btn btn-danger btn-sm delete-btn"
                                                    data-id="{{ $single_position->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{ $data['position_list']->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).on('click', '.delete-btn', function () {
        if (confirm('Are you sure?')) {
            let id = $(this).data('id');
            let row = $(this).closest('tr');

            $.ajax({
                url: '/member/candidate/delete/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    if (data.status === 'SUCCESS') {
                        row.remove();
                        $('#success').html(
                            `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> ${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                        );
                    } else {
                        $('#failed').html(
                            `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Failed!</strong> ${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                        );
                    }
                },
                error: function(xhr) {
                    $('#failed').html(
                        `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Failed!</strong> Something went wrong
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`
                    );
                }
            });
        }
    });


</script>
</body>
</html>