<div>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 mb-4">Data User Device</h1>


        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row justify-content-between mx-2 align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                    <form class="form-inline" wire:submit.prevent='search'>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="inputSearch" class="sr-only">Search</label>
                            <input type="text" wire:model='search' name="search" class="form-control"
                                id="inputSearch" placeholder="Search">
                        </div>

                        <button type="button" class="btn btn-secondary mb-2 ml-3" data-toggle="modal"
                            data-target="#createModal">Add Data</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        @if ($data->count())
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ($data as $key => $item)
                                <tbody>
                                    <tr>
                                        <td>{{ $key + $data->firstItem() }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            <div class="row justify-content-center">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#editModal"
                                                    wire:click.prevent='show({{ $item->id }})'>Edit</button>
                                                <button type="button" class="btn btn-danger ml-2" data-toggle="modal"
                                                    data-target="#deleteModal"
                                                    wire:click.prevent='show({{ $item->id }})'>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        @endif
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click.prevent='resetData'>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input wire:model.defer='name' type="text"
                            class="form-control @error('name') is-invalid @enderror" id="exampleFormControlInput1"
                            placeholder="name">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Email</label>
                        <input wire:model.defer='email' type="email"
                            class="form-control @error('email') is-invalid @enderror " id="exampleFormControlInput1"
                            placeholder="email">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click.prevent='resetData'>Close</button>
                    <button type="button" class="btn btn-primary"
                        wire:click.prevent='update'>Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click.prevent='resetData'>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input wire:model.defer='name' type="text"
                            class="form-control @error('name') is-invalid @enderror " id="exampleFormControlInput1"
                            placeholder="name">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Email</label>
                        <input wire:model.defer='email' type="email"
                            class="form-control  @error('email') is-invalid @enderror" id="exampleFormControlInput1"
                            placeholder="email">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Password</label>
                        <input wire:model.defer='password' type="password"
                            class="form-control @error('password') is-invalid @enderror "
                            id="exampleFormControlInput1" placeholder="password">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click.prevent='resetData'>Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent='store'>Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click.prevent='resetData'>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to deleted this data? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click.prevent='resetData'>Close</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        wire:click.prevent='delete'>Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    window.addEventListener('closeCreateModal', event=> {
        $('#createModal').modal('hide')
    })
    window.addEventListener('closeEditModal', event=> {
        $('#editModal').modal('hide')
    })
    </script>
</div>
