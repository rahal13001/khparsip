<div>
    <div>
        <div class="container">
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
                    <option value="nama">Nama</option>
                    <option value="category_id">Kategori</option>
                </select>
                <select wire:model="asc" name="asc" id="asc" class="form-control form-control-sm rounded-md shadow-sm">
                  <option value="ASC">Terkecil</option>
                  <option value="DESC">Terbesar</option>
                </select>
            </div>

            <div class="col-md-3 col-sm-3 d-flex">
                <div class="d-grid btn-group" role="group">
                  @if ($checked)
                  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Aksi ({{count($checked)}})
                  </button>
                  <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#" onclick="confirm('Yakin Ingin Menghapus {{ count($checked) }} Data ?')||event.stopImmediatePropagation()" wire:click="deleteDatas()">Delete ({{ count($checked) }})</a></li>           
                  </ul>
                  @endif
                </div>
              </div>
          
            </div>

            
            @if ($selectPage)
                <div class="col-md-10 my-3">
                @if ($selectAll)
                Anda Telah Memilih <strong>Seluruh Data ({{ $subcategories->total() }} Data)</strong>
                <a href="#" role="button" class="badge bg-success" wire:click="selectPart" style="text-decoration: none">Pilih Yang Ditampilkan Saja</a>
                @else
                Anda Telah Memilih <strong>{{ count($checked) }} Data</strong>, Apakah Anda Ingin Memilih Seluruh Data <strong>({{ $subcategories->total() }} Data)</strong> ?
                <a href="#" role="button" class="badge bg-primary" wire:click="selectAll" style="text-decoration: none">Pilih Semua</a>
                @endif
                </div>         
            @endif
            
            <div class="table-responsive-lg">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th><input type="checkbox" wire:model="selectPage"></th>
                          <th class="text-center col-1">No</th>
                          <th class="text-center col-5" >Sub Kategori</th>
                          <th class="text-center col-4" >Kategori</th>
                          <th class="text-center col-3">Aksi</th>  
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($subcategories as $subcategory) 
                            <tr class="@if ($this->isChecked($subcategory->id)) table-primary @endif"> 
                                <td><input type="checkbox" value="{{ $subcategory->id }}" wire:model="checked">
                                    @if ($editedSubcategoryIndex == $subcategory->id)
                                    @endif</td>
                                <td class="text-center col-1">{{ $loop->iteration }}</td>
                                <td class="text-center col-5">
                                    @if ($editedSubcategoryIndex !== $subcategory->id)
                                    
                                    {{ $subcategory->nama }}
                                    
                                    @else
                                    <input  type="text" wire:model.defer ="setsubcategories.{{$subcategory->id}}.nama" class="form-control
                                        {{$errors->first('nama') ? "is-invalid" : "" }}" id="nama">                                
                                        @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    @endif
                                   
                                    
                                    
                                </td>
                                <td class="text-center col-4">
                                    @if ($editedSubcategoryIndex !== $subcategory->id)
                                        {{ $subcategory->categories->nama }}</td>
                                    @else

                                        <div class="col-sm-6">
                                           
                                            <select class="form-select mb-3 {{$errors->first('selected') ? "is-invalid" : "" }}" wire:model.defer = "setsubcategories.{{ $subcategory->id}}.category_id">
                                            <option selected readonly>Pilih Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>{{ $category->nama }}</option>
                                            @endforeach
                                
                                            </select>
                    
                                            @error('selected')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                    
                                        </div>

                                    @endif

                                <td class="text-center col-3">
                                    <a class="btn btn-outline-primary" href=""><i class="bi bi-eye-fill"></i></i></a>
                                    @if (!$checked)
                                        @if ($editedSubcategoryIndex !== $subcategory->id)
                                            <a class="btn btn-outline-warning" wire:click.prevent="editSubcategory({{ $subcategory->id }})">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-outline-warning" wire:click.prevent="saveSubcategory({{ $subcategory->id }})">
                                                <i class="bi bi-sd-card-fill"></i>
                                            </button>
                                        @endif
                                    {{-- <a class="btn btn-outline-warning" href=""><i class="bi bi-pencil-fill"></i></i></a> --}}
                                    @endif
                                    @if (!$checked)
                                    <a class="btn btn-outline-danger"
                                    onclick="confirm('Apakah Yakin Ingin Menghapus Data Survei Judul {{ $subcategory->nama }} Yang Berkategori {{ $subcategory->categories->nama }}  ?')||event.stopImmediatePropagation()"
                                    wire:click="deleteSatuData({{$subcategory->id}})" ><i class="bi bi-trash-fill"></i></a>    
                                    @endif
                      
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                </table>
            </div>
        </div>

        




    </div>
    
</div>
