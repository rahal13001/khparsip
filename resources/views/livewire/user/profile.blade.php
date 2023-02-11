<div class="card mb-3">
    <div class="card-header text-center">
        <h3>Profile Pengguna</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="name">Nama</label>
            @if ($editing)
                <input type="text" class="form-control" id="name" wire:model="name">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            @else
                <p class="form-control-plaintext" id="name">{{ $user->name }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            @if ($editing)
                <input type="email" class="form-control" id="email" wire:model="email">
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            @else
                <p class="form-control-plaintext" id="email">{{ $user->email }}</p>
            @endif
        </div>
        <div class="form-group text-center mt-3">
            @if ($editing)
                <button type="button" class="btn btn-primary" wire:click="update">Save</button>
                <button type="button" class="btn btn-secondary" wire:click="cancel">Cancel</button>
            @else
                <button type="button" class="btn btn-primary" wire:click="edit">Edit</button>
            @endif
        </div>
    </div>
</div>