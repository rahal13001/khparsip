@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
<div>
    <section id="portfolio" class="portfolio mt-3">
        <div class="container">

            <h5 class="mb-3" >Berikan Role</h5>
                <div class="row mt-3">
                    <div class="col-sm-6" wire:ignore>
                        <label for="selected">Nama</label>
                        <select class="form-select mb-3 {{$errors->first('selected') ? "is-invalid" : "" }} select2" id="userrole">
                          <option selected readonly>Pilih User</option>
                          @foreach ($usersrole as $userrole)
                              <option value="{{ $userrole->id }}">{{ $userrole->name }}</option>
                          @endforeach
               
                        </select>
  
                        @error('selected')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
  
                      </div>


                    <div class="col-sm-6" wire:ignore>
                        <label for="selected">Role</label>
                        <select class="form-select mb-3 {{$errors->first('selected') ? "is-invalid" : "" }} select2" id="role" multiple>
                          @foreach ($roles as $role)
                              <option value="{{ $role->id }}">{{ $role->name }}</option>
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
                    <button class="btn btn-primary" wire:click="taut" type="submit">Kirim</button>
                </div>


        </div>
    </section>
</div>



@push('select2')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   
    $(document).ready(function() {
    $('#role').select2({
        placeholder : "Pilih Kategori"
    });
            $('#role').on('change', function (e) {
                var data = $('#role').select2("val");
            @this.set('role_id', data);
            });
            
           
    });

       
    $(document).ready(function() {
        $('#userrole').select2();
                $('#userrole').on('change', function (e) {
                    var data = $('#userrole').select2("val");
                @this.set('user_idrole', data);
                });
             
    });

    
   

   
</script>

@endpush