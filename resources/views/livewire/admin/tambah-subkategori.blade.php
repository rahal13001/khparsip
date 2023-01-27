@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
<div>
    <section id="portfolio" class="portfolio mt-3">
        <div class="container">

            <h5 class="mb-3" >Tambah Kategori</h5>
                <div class="row mt-3">
                    <div class="col-sm-6">
                        <label for="nama">Nama Sub Kategori</label>
                        <input  type="text" wire:model = "nama" class="form-control {{$errors->first('nama') ? "is-invalid" : "" }}" id="nama" placeholder="Isikan Nama Kategori...." >
                        @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-sm-6" wire:ignore>
                        <label for="selected">Kategori</label>
                        <select class="form-select mb-3 {{$errors->first('selected') ? "is-invalid" : "" }} select2" id="select2">
                          <option selected readonly>Pilih Kategori</option>
                          @foreach ($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->nama }}</option>
                          @endforeach
               
                        </select>
  
                        @error('selected')
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

@push('select2')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   
    $(document).ready(function() {
    $('#select2').select2();
            $('#select2').on('change', function (e) {
                var data = $('#select2').select2("val");
            @this.set('category_id', data);
            });
});
</script>

@endpush