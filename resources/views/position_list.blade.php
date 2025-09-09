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
                        <a href="#" class="btn btn-primary btn-sm position-absolute end-0 top-50 translate-middle-y" data-bs-toggle="modal" data-bs-target="#addPositionModal">
                            <i class="fa-solid fa-plus"></i> Add
                        </a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

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
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data['position_list'] as $index => $position)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $position->name }}</td>
                                    <td>{{ $position->total_candidate }}</td>
                                    <td>{{ $position->max_valid_vote }}</td>
                                    <td>{{ $position->min_valid_vote }}</td>
                                    <td>{{ $position->election_area->name ?? '-' }}</td>
                                    <td>{{ $position->priority }}</td>
                                    <td>
                                        <a href="{{ route('position.edit', $position->id) }}"
                                        class="btn btn-success btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editPositionModal{{ $position->id }}">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $position->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>

                                <!-- Edit Position Modal -->
                                <div class="modal fade" id="editPositionModal{{ $position->id }}" tabindex="-1" aria-labelledby="editPositionModalLabel{{ $position->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form action="{{ route('position.edit', $position->id) }}" method="POST">
                                                @csrf

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editPositionModalLabel{{ $position->id }}">Edit Position</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label for="name{{ $position->id }}" class="form-label">Position Name</label>
                                                            <input type="text" class="form-control" id="name{{ $position->id }}" name="name" value="{{ $position->name }}" required>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="total_candidate{{ $position->id }}" class="form-label">Total Candidate</label>
                                                            <input type="number" class="form-control" id="total_candidate{{ $position->id }}" name="total_candidate" value="{{ $position->total_candidate }}" min="1" required>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="max_valid_vote{{ $position->id }}" class="form-label">Max Valid Vote</label>
                                                            <input type="number" class="form-control" id="max_valid_vote{{ $position->id }}" name="max_valid_vote" value="{{ $position->max_valid_vote }}" min="0" required>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="min_valid_vote{{ $position->id }}" class="form-label">Min Valid Vote</label>
                                                            <input type="number" class="form-control" id="min_valid_vote{{ $position->id }}" name="min_valid_vote" value="{{ $position->min_valid_vote }}" min="0" required>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="priority{{ $position->id }}" class="form-label">Priority</label>
                                                            <input type="number" class="form-control" id="priority{{ $position->id }}" name="priority" value="{{ $position->priority }}" min="1" required>
                                                        </div>

                                                        
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Edit Position Modal -->
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

<!-- Modal for Add Position -->
<div class="modal fade" id="addPositionModal" tabindex="-1" aria-labelledby="addPositionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 justify-content-center position-relative">
                <h4 class="modal-title text-center" id="addPositionModalLabel">Add Position</h4>
                <button type="button" class="btn-close position-absolute end-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('position.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="col-md-4">
                            <label for="total_candidate" class="form-label">Total Candidate</label>
                            <input type="number" class="form-control" id="total_candidate" name="total_candidate" min="1" required>
                        </div>

                        <div class="col-md-4">
                            <label for="max_valid_vote" class="form-label">Max Valid Vote</label>
                            <input type="number" class="form-control" id="max_valid_vote" name="max_valid_vote" min="0" required>
                        </div>

                        <div class="col-md-4">
                            <label for="min_valid_vote" class="form-label">Min Valid Vote</label>
                            <input type="number" class="form-control" id="min_valid_vote" name="min_valid_vote" min="0" required>
                        </div>

                        <div class="col-md-4">
                            <label for="priority" class="form-label">Priority</label>
                            <input type="number" class="form-control" id="priority" name="priority" min="1" required>
                        </div>
                    </div>



                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Add Position Modal -->


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