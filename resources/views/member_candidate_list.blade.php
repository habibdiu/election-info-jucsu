<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Candidate List</title>
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
                        <h3 class="fw-bold text-center mb-0">Member Candidate List</h3>
                        <a href="{{ route('member.candidate.add') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberCandidateModal">
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
                                <th>SL</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Details</th>
                                <th>Election Area</th>
                                <th>Member No</th>
                                <th>Ballot No</th>
                                <th style="width:15%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['member_candidate_list'] as $index => $single_member_candidate)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <img src="{{ asset($single_member_candidate->photo ?: 'backend_assets/images/user-dummy.png') }}"
                                                alt="Photo" class="img-thumbnail" style="width:40px; height:40px; object-fit:cover;">
                                        </td>
                                        <td>{{ $single_member_candidate->name }}</td>
                                        <td>{{ $single_member_candidate->position->name ?? 'N/A' }}</td>
                                        <td>{{ $single_member_candidate->details }}</td>
                                        <td>{{ $single_member_candidate->election_area->name ?? 'N/A' }}</td>
                                        <td>{{ $single_member_candidate->member_no }}</td>
                                        <td>{{ $single_member_candidate->ballot_no }}</td>
                                        <td>
                                            <a href="{{ route('member.candidate.edit', $single_member_candidate->id) }}"
                                             class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editMemberCandidateModal{{$single_member_candidate->id}}"><i class="fa-solid fa-edit"></i></a>
                                            <button class="btn btn-danger btn-sm delete-btn"
                                                    data-id="{{ $single_member_candidate->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal for Edit Member Candidate -->
                                    <div class="modal fade" id="editMemberCandidateModal{{$single_member_candidate->id}}" tabindex="-1" aria-labelledby="editMemberCandidateModalLabel{{$single_member_candidate->id}}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header border-0 justify-content-center position-relative">
                                                    <h4 class="modal-title text-center" id="editMemberCandidateModalLabel{{$single_member_candidate->id}}">Edit Member Candidate</h4>
                                                    <button type="button" class="btn-close position-absolute end-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <form action="{{ route('member.candidate.edit', $single_member_candidate->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('POST')
                                                    <div class="modal-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label for="name" class="form-label">Name</label>
                                                                <input type="text" class="form-control" id="name" name="name"
                                                                    value="{{ $single_member_candidate->name }}" required>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="position" class="form-label">Position</label>
                                                                <select class="form-select" id="position" name="position" required>
                                                                    <option value="">Select Position</option>
                                                                    @foreach($data['positions'] as $position)
                                                                        <option value="{{ $position->id }}"
                                                                            {{ $position->id == $single_member_candidate->position_id ? 'selected' : '' }}>
                                                                            {{ $position->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="election_area" class="form-label">Election Area</label>
                                                                <select class="form-select" id="election_area" name="election_area" required>
                                                                    <option value="">Select Election Area</option>
                                                                    @foreach($data['election_areas'] as $area)
                                                                        <option value="{{ $area->id }}"
                                                                            {{ $area->id == $single_member_candidate->election_area_id ? 'selected' : '' }}>
                                                                            {{ $area->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="member_no" class="form-label">Member No</label>
                                                                <input type="text" class="form-control" id="member_no" name="member_no"
                                                                    value="{{ $single_member_candidate->member_no }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="ballot_no" class="form-label">Ballot No</label>
                                                                <input type="text" class="form-control" id="ballot_no" name="ballot_no"
                                                                    value="{{ $single_member_candidate->ballot_no }}" required>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="photo" class="form-label">Photo</label>
                                                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                                                                @if($single_member_candidate->photo)
                                                                    <img src="{{ asset($single_member_candidate->photo) }}" alt="Photo"
                                                                        class="img-thumbnail mt-2" style="width:80px; height:80px; object-fit:cover;">
                                                                @endif
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="details" class="form-label">Details</label>
                                                                <textarea class="form-control" id="details" name="details" rows="3">{{ $single_member_candidate->details }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Edit Modal -->

                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{ $data['member_candidate_list']->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal To Add member -->
<div class="modal fade" id="addMemberCandidateModal" tabindex="-1" aria-labelledby="addMemberCandidateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header border-0 justify-content-center position-relative">
            <h4 class="modal-title text-center" id="addMemberCandidateModalLabel">Add Member Candidate</h4>
            <button type="button" class="btn-close position-absolute end-0" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

      <form action="{{ route('member.candidate.add') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-md-4">
              <label for="position" class="form-label">Position</label>
              <select class="form-select" id="position" name="position" required>
                <option value="">Select Position</option>
                @foreach($data['positions'] as $position)
                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label for="election_area" class="form-label">Election Area</label>
              <select class="form-select" id="election_area" name="election_area" required>
                <option value="">Select Election Area</option>
                @foreach($data['election_areas'] as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label for="member_no" class="form-label">Member No</label>
              <input type="text" class="form-control" id="member_no" name="member_no">
            </div>
            <div class="col-md-4">
              <label for="ballot_no" class="form-label">Ballot No</label>
              <input type="text" class="form-control" id="ballot_no" name="ballot_no" required>
            </div>
            <div class="col-md-4">
              <label for="photo" class="form-label">Photo</label>
              <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
            </div>
            <div class="col-12">
              <label for="details" class="form-label">Details</label>
              <textarea class="form-control" id="details" name="details" rows="3"></textarea>
            </div>
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
<!-- End of Add Modal -->

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