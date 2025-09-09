<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member Candidate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-3">
                <div class="card-body">
                    <h3 class="fw-bold text-center mb-4">Edit Member Candidate</h3>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('member_candidate.edit', $data['member_candidate']->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        @php
                        $member_candidate = $data['member_candidate'];
                        @endphp

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $member_candidate->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <select class="form-select" id="position" name="position" required>
                                <option value="">Select Position</option>
                                @foreach($data['positions'] as $position)
                                    <option value="{{ $position->id }}" 
                                        {{ $position->id == $data['member_candidate']->position_id ? 'selected' : '' }}>
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Details</label>
                            <textarea class="form-control" id="details" name="details" rows="3">{{ $member_candidate->details }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="election_area" class="form-label">Election Area</label>
                            <select class="form-select" id="election_area" name="election_area" required>
                                <option value="">Select Election Area</option>
                                @foreach($data['election_areas'] as $area)
                                    <option value="{{ $area->id }}" 
                                        {{ $area->id == $data['member_candidate']->election_area_id ? 'selected' : '' }}>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="member_no" class="form-label">Member No</label>
                            <input type="text" class="form-control" id="member_no" name="member_no" value="{{ $member_candidate->member_no }}">
                        </div>
                        <div class="mb-3">
                            <label for="ballot_no" class="form-label">Ballot No</label>
                            <input type="text" class="form-control" id="ballot_no" name="ballot_no" value="{{ $member_candidate->ballot_no }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            @if($member_candidate->photo)
                                <img src="{{ asset($member_candidate->photo) }}" alt="Photo" class="img-thumbnail mt-2" style="width:80px; height:80px; object-fit:cover;">
                            @endif
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('member_candidate.list') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>