@extends('layouts.back')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@push('script')
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {

         $('.select2').select2({
             placeholder:"Pilih Hak Akses",
             width : "100%"
         });
});
    </script>
@endpush

@section('content')

               <form action="{{ route('assign_update', $role->id) }}" method="post">
                        @csrf
                        @method('put')
                            <div class="form-group mt-3">
                                <label for="name">Nama Role</label>
                                <select name="name" id="name" class="form-control input-rounded select2 mt-3">
                                <option disabled selected >Pilih Role</option>
                                    @foreach ($roles as $peran)
                                    <option {{ $role->id == $peran->id ? 'selected' : '' }} value="{{ $peran->id }}"> {{ $peran->name }}</option>
                                    @endforeach
                                </select> 
                                                                
                                @error('name')
                                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                                @enderror                                  
                            </div>
                            <div class="form-group mt-3">
                            <label for="permission">Permission</label>
                            <select name="permission[]" id="permission" class="form-control input-rounded select2 mt-3" multiple>
                                @foreach ($permissions as $hak)
                                <option {{ $role->permissions()->find($hak->id) ? 'selected' : ''}} value="{{ $hak->id }}"> {{ $hak->name }}</option>
                                @endforeach
                            </select> 
                            @error('permission')
                                <div class="text-danger mt-2 d-block">{{ $message }}</div>
                            @enderror
                            </div>
                            <button type="submit" class="btn btn-info mt-4">Assign</button>
                            <a href="{{ route('assignrole') }}" class="btn btn-danger mt-4">Batal</a>
                    </form>
                        
@endsection