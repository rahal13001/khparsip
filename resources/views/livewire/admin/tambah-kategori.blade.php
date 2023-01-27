<div>
    <section id="portfolio" class="portfolio mt-3">
        <div class="container">

            <h5 class="mb-3" >Tambah Kategori</h5>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <label for="nama">Nama Kategori</label>
                        <input  type="text" wire:model = "nama" class="form-control {{$errors->first('nama') ? "is-invalid" : "" }}" id="nama" placeholder="Isikan Nama Kategori...." >
                        @error('nama')
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
