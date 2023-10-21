<div class="container">
    <div class="row justify-content-center">
        <div class="mt-3">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
    <!-- START FORM -->
    @if ($errors->any())    
    <div class="my-3 p-3 alert alert-danger">
        <ul>
            @foreach ($errors->all() as $item )
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if (session()->has('success'))
        <div class="my-3 p-3 alert alert-success">
            <ul>
                <li>{{ session('success') }}</li>
            </ul>
        </div>
        
    @endif  
    @if ($editMode == true)
    <div class="my-3 p-3 bg-warning-subtle rounded shadow-sm">
    @else    
    <div class="my-3 p-3 bg-body rounded shadow-sm">
    @endif
        <form class="fw-bold">
            <div class="mb-3 row">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="title">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="author" class="col-sm-2 col-form-label">Author</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="author">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="year" class="col-sm-2 col-form-label">Year</label>
                <div class="col-sm-10">
                    <input type="number" min="4" class="form-control" wire:model="year">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    @if ($editMode == true)
                        <button type="button" class="btn btn-primary" wire:click="update" name="submit">UPDATE</button>
                        <button type="button" class="btn btn-secondary" wire:click="clear">CANCEL</button>
                    @else    
                        <button type="button" class="btn btn-primary" wire:click="store" name="submit">SAVE</button>
                        <button type="button" class="btn btn-secondary" wire:click="clear">Clear</button>
                    @endif
                    
                </div>
            </div>
        </form>
    </div>
    <!-- END FORM -->

    <!-- START DATA -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1 class="my-3 text-center">Books List</h1>
        <div class="p-3">
            <input type="text" class="form-control bg-light border-1 w-25" wire:model.live="search" placeholder="Search...">
        </div>
        @if ($selected)
        <a wire:click="deleteConfirmation('')" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete : {{ count($selected)}} Selected</a>
        @endif
        <table class="table table-striped table-sortable">
            <thead>
                <tr>
                    <th></th>
                    <th class="col-md-1">No</th>
                    <th class="col-md-4 sort @if ($sortColumn == 'title'){{$sortDirection}} @endif " wire:click="sort('title')">Title</th>
                    <th class="col-md-3 sort @if ($sortColumn == 'author'){{$sortDirection}} @endif" wire:click="sort('author')">Author</th>
                    <th class="col-md-2 sort @if ($sortColumn == 'year'){{$sortDirection}} @endif" wire:click="sort('year')">Year</th>
                    <th class="col-md-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $key => $value)
                <tr>
                    <td>
                        <input type="checkbox" wire:key="{{ $value->id }}" wire:model.live="selected" value="{{ $value->id }}">
                    </td>
                    <td>{{ $books->firstItem() + $key }}</td>
                    <td>{{ $value->title }}</td>
                    <td>{{ $value->author }}</td>
                    <td>{{ $value->year }}</td>
                    <td>
                        <a wire:click="edit({{ $value->id }})" class="btn btn-warning btn-sm">Edit</a>
                        <a wire:click="deleteConfirmation({{ $value->id }})" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $books->links() }}

    </div>
    <!-- END DATA -->
    {{-- MODAL --}}
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Book</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Are You Sure You Want To Delete This Book?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button wire:click="delete" type="button" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
            </div>
          </div>
        </div>
      </div>
      {{-- END MODAL --}}
</div>
