<div>
    <div class="form-group row mt-3">
        <div class="col-md-9">
            <label for="name">Nama</label>
            <input type="text" wire:model="name" id="name" class="form-control input-rounded" value="{{ $name }}" {{ $ubah ? '' : 'disabled' }}>
                                      
            @error('name')
                <div class="text-danger mt-2 d-block">{{ $message }}</div>
            @enderror 
        </div>
        <div class="col-md-3">
            @if (!$ubah)
                <button wire:click="ubah" class="btn btn-primary mt-4">Ubah Nama</button>
            @else
                <button wire:click="update({{ $user->id }})" class="btn btn-primary mt-4">Lakukan Perubahan</button>
                <button wire:click="batal" class="btn btn-danger mt-4">Batal Ubah</button>
            @endif
        </div>
                               
    </div>
    
</div>
