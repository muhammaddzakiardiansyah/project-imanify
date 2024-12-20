@extends('components.main')

@section('app')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Table Places</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                    <div class="button">
                        <a class="btn btn-primary" id="btnCreate">Create</a>
                    </div>
                    <div class="search">
                        <form action="" class="d-flex gap-2" method="get">
                            <input list="searchs" class="form-control" name="search" id="search"
                                placeholder="Search evrything..." value="{{ Request::query('search') }}">
                            <datalist id="searchs">
                                <option value="item in">
                                <option value="item out">
                            </datalist>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="cardCreatePlace d-none card border p-4">
                    <h3>Create Place</h3>
                    <form class="form mt-3" action="{{ route('description-items.create') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="place-name-column">Place Name</label>
                                    <input type="text" id="place-name-column"
                                        class="form-control w-100 @error('place_name') is-invalid @enderror"
                                        placeholder="Place Name" name="place_name" value="{{ old('place_name') }}">
                                    @error('place_name')
                                        <div class="invalid-feedback">
                                            <i class="bx bx-radio-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Create</button>
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Table with outer spacing -->
                <div class="table-responsive">
                    <table class="table table-lg">
                        <thead>
                            <tr>
                                <th>PLACE NAME</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($places as $place)
                                <tr>
                                    <td class="text-bold-500">{{ $place->place_name }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="/dashboard/description-items/edit/{{ $place->id }}"
                                            class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                                        <form
                                            action="{{ route('description-items.delete', ['id' => $place->id]) }}"
                                            method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Sure deleted this description item?')"
                                                class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="cardEditPlace card border p-4">
                        <h3>Edit Place</h3>
                        <form class="form mt-3" action="{{ route('description-items.create') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="place-name-column">Place Name</label>
                                        <input type="text" id="place-name-column"
                                            class="form-control w-100 @error('place_name') is-invalid @enderror"
                                            placeholder="Place Name" name="place_name" value="{{ old('place_name') }}" autofocus="on">
                                        @error('place_name')
                                            <div class="invalid-feedback">
                                                <i class="bx bx-radio-circle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Create</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const btnCreate = document.getElementById('btnCreate');
        const cardCreatePlace = document.querySelector('.cardCreatePlace');

        btnCreate.addEventListener('click', () => {
            cardCreatePlace.classList.toggle('d-none');
            btnCreate.textContent == 'Create' ? btnCreate.innerHTML = 'Close' : btnCreate.innerHTML = 'Create'
        });
    </script>
@endsection
