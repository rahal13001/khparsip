@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

<div>
    <div>
        {{-- @include('livewire.superadmin.assignrolemodal') --}}
        <div class="container">
            @include('livewire.superadmin.assignrolemodal')
            <h2 class="mb-3 text-lg font-large leading-6 text-gray-900">Data Kategori</h2>
    
            <div class="row mb-2">
                {{-- Kolom Cari --}}
                <div class="col-md-3 col-sm-3 d-flex">
                      <input class="form-control form-control-sm" type="text" placeholder="Cari Data..." wire:model.debounce.300ms="cari"> 
                </div>

                   {{-- Pagination --}}
            <div class="col-md-2 col-sm-2 d-flex">
                <select wire:model="paginate" name="paginate" id="paginate" class="form-control form-control-sm rounded-md shadow-sm">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div class="col-md-3 col-sm-3 d-flex">
                <select wire:model="orderby" name="orderby" id="orderby" class="form-control form-control-sm rounded-md shadow-sm">
                    <option selected value="id">Urutan Default</option>
                    <option value="name">Nama</option>
                </select>
                <select wire:model="asc" name="asc" id="asc" class="form-control form-control-sm rounded-md shadow-sm">
                  <option value="ASC">Terkecil</option>
                  <option value="DESC">Terbesar</option>
                </select>
            </div>
               
            </div>
            
            <div class="table-responsive-lg">
                <table class="table table-hover">
                    <thead>
                        <tr>
                          <th class="text-center">No</th>
                          <th class="text-center" >Role</th>
                          <th class="text-center" >Permission</th>
                          <th class="text-center">Aksi</th>  
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($roles_pilih as $role) 
                            <tr class="@if ($this->isChecked($role->id)) table-primary @endif"> 
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $role->name }}</td>
                                <td class="text-center">
                                  
                                      @foreach ($role->getPermissionNames() as $data_role)
                                      @if (!$loop->last && !$loop->first)
                                            ,
                                        @endif
                                        @if (!$loop->first && $loop->last)
                                            dan
                                        @endif
                                        {{ $data_role }}
                                        @endforeach

                                </td>                                
                                <td class="text-center">
                                    @if (!$checked)
                                        <a type="button"
                                        {{-- data-bs-target="#updateAssignRoleModal" --}}
                                        class="btn btn-outline-warning"
                                        {{-- wire:click="editAssign({{$role->id}})" --}}
                                        href="{{ route('assign_edit', $role->id) }}"
                                        >
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        
                                    @endif
                                    {{-- @if (!$checked)
                                    <a class="btn btn-outline-danger"
                                    onclick="confirm('Apakah Yakin Ingin Menghapus Pemberian akses role {{ $role->name }}  ?')||event.stopImmediatePropagation()"
                                    wire:click="deleteSatuData({{$role->id}})" ><i class="bi bi-trash-fill"></i></a>    
                                    @endif --}}
                      
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                </table>
            </div>
        </div>
    </div>   
</div>

{{-- @push('select2')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>


    $(document).ready(function() {
    $('#role').select2(
        {
            dropdownParent: $('#assignRoleModal')
        }
    );
            $('#role').on('change', function (e) {
                var data = $('#role').select2("val");
            @this.set('name', data);
            });
    });


    $(document).ready(function() {
    $('#permissions').select2(
        {
            dropdownParent: $('#assignRoleModal')
        }
    );
            $('#permissions').on('change', function (e) {
                var data = $('#permissions').select2("val");
            @this.set('permissions', data);
            });
    });

</script>

@endpush --}}