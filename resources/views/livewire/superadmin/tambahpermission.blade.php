<div>
    <section id="portfolio" class="portfolio mt-3">
        <div class="container">

            <h5 class="mb-3" >Tambah Permission</h5>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <label for="name">Nama Permission</label>
                        <input  type="text" wire:model = "name" class="form-control {{$errors->first('name') ? "is-invalid" : "" }}" id="name" placeholder="Isikan Nama Permission...." >
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-primary" wire:click = "submit" type="submit">Kirim</button>
                </div>

        </div>
    </section>
</div>