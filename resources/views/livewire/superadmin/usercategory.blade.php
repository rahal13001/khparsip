<div>
    <div>
        <div class="container">
            @include('livewire.superadmin.superadminmodal')
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
                          <th class="text-center" >Nama</th>
                          <th class="text-center" >Kategori</th>
                          <th class="text-center" >Role</th>
                          <th class="text-center">Aksi</th>  
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($users as $user) 
                            <tr> 
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center">
                                  
                                      @foreach ($user->category as $data_category)
                                      @if (!$loop->last && !$loop->first)
                                            ,
                                        @endif
                                        @if (!$loop->first && $loop->last)
                                            dan
                                        @endif
                                        {{ $data_category->nama }}
                                        @endforeach

                                </td>

                                <td class="text-center">
                                    @php
                                        $datarole = implode(', ', $user->getRoleNames()->toArray());
                                    @endphp

                                    {{ $datarole }}
                                </td>
                                
                                <td class="text-center">
                                                                   
                                        <a type="button" class="btn btn-outline-warning" href="{{ route('assignuser_edit', $user->id) }}" >
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>               
                      
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                </table>
            </div>
        </div>

        




    </div>
    
</div>
