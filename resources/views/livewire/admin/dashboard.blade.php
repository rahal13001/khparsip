<div class="container">
    <h4 class="mb-3 text-lg font-large leading-6 text-gray-900">Data Pelaporan</h4>

    <div class="row mb-2">
        <div class="col-md-3 col-sm-3 d-flex">
            <input class="form-control form-control-sm" type="text" placeholder="Cari What, Where, Penyusun..." wire:model.debounce.300ms="cari">
        </div>
       
         {{-- Total --}}
         <div class="col-md-3 col-sm-3 d-flex">
            <input class="form-control form-control-sm" type="date" placeholder="Nilai Minimal" wire:model.debounce.300ms="mulai">
            <input class="form-control form-control-sm" type="date" placeholder="Nilai Maksimal" wire:model.debounce.300ms="akhir">
          </div>

          {{-- Urutan --}}
          <div class="col-md-3 col-sm-3 d-flex">
            <select wire:model="orderby" name="orderby" id="orderby" class="form-control form-control-sm rounded-md shadow-sm">
                <option selected value="id">Urutan Default</option>
                <option value="what">What</option>
                <option value="when">When</option>
                <option value="user_id">Penyusun</option>
            </select>
            <select wire:model="asc" name="asc" id="asc" class="form-control form-control-sm rounded-md shadow-sm">
              <option value="ASC">Terkecil</option>
              <option value="DESC">Terbesar</option>
            </select>
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


    </div>
    <div class="row mb-2">
        <div class="col-md-4 col-sm-4" wire:ignore>
          <label for="kategori">Filter Kategori</label><br>
          <select name="kategori" id="kategori" class="form-control input-rounded select2" multiple>
            <option disabled>Pilih Kategori</option>
          @foreach ($categories as $category )
             <option value="{{ $category->id }}">{{ $category->nama }}</option>
          @endforeach
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
                  <li><a class="dropdown-item" href="#" onclick="confirm('Yakin Ingin Mengeksport {{ count($checked) }} Data ?')||event.stopImmediatePropagation()" wire:click="eksporexcel">Ekspor Excel ({{ count($checked) }})</a></li>            
              </ul>
              @endif
            </div>
          </div>


    </div>
    <div class="row mb-2">
      @if (!is_null($selectedSubkategori) && count($selectedSubkategori)>0)
        <div class="col-md-23 col-sm-12">
        ---- Sub Kategori ---- <br>
        
              @foreach ($selectedSubkategori as $items)
                        <strong>Kategori : {{ $items->nama }}</strong><br>
                        @foreach ($items->subcategories as $item)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="{{ $item->id }}" wire:model.lazy="subkategori">
                            <label class="form-check-label">
                            {{ $item->nama }}
                            </label>
                        </div>
                        @endforeach<br>
               @endforeach
        
        </div>
      @endif
    </div>

    @if ($selectPage)
    <div class="col-md-10 my-3">
      @if ($selectAll)
      Anda Telah Memilih <strong>Seluruh Data ({{ $datas->total() }} Data)</strong>
      <a href="#" role="button" class="badge bg-success" wire:click="selectPart" style="text-decoration: none">Pilih Yang Ditampilkan Saja</a>
      @else
      Anda Telah Memilih <strong>{{ count($checked) }} Data</strong>, Apakah Anda Ingin Memilih Seluruh Data <strong>({{ $datas->total() }} Data)</strong> ?
      <a href="#" role="button" class="badge bg-primary" wire:click="selectAll" style="text-decoration: none">Pilih Semua</a>
      @endif
    </div>
        
    @endif

    @if (session()->has('message'))
      <div class="alert alert-success alert-dismissible fade show" role="alert"">
          {{ session('message') }}
          <button type="button" class="close float-right" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
   @endif
    <div class="table-responsive-lg">
        <table class="table table-hover">
            <thead>
                <tr>
                  <th><input type="checkbox" wire:model="selectPage"></th>
                  <th class="text-center">No</th>
                  <th class="text-center">Tanggal</th>
                  <th>What</th>
                  <th>Where</th>
                  <th>Penyusun</th>
                  <th class="text-center">Aksi</th>  
                </tr>
              </thead>
              <tbody>
                @foreach ($datas as $data)
                  <tr class="@if ($this->isChecked($data->id)) table-primary @endif">
                    <td><input type="checkbox" value="{{ $data->id }}" wire:model="checked"></td>
                    <td class="text-center">{{ $loop->iteration}}</td>       
                    <td class="text-center">{{ $data->when }}</td>
                    <td>{{ $data->what }}</td>
                    <td>{{ $data->where }}</td>
                    <td>{{ $data->user->name }}</td>
                    <td class="text-center">
                      <a class="btn btn-outline-primary" href="{{ route('report_detail', $data->id) }}"><i class="bi bi-eye-fill"></i></i></a>
                      
                      @if (!$checked)
                      <a class="btn btn-outline-danger"
                      onclick="confirm('Apakah Yakin Ingin Menghapus Data Survei Judul {{ $data->what }} Tanggal {{ $data->when }} Milik {{ $data->user->name }}  ?')||event.stopImmediatePropagation()"
                      wire:click="deleteSatuData({{$data->id}})" ><i class="bi bi-trash-fill"></i></a>
                          
                      @endif
                      
                    </td>
                  </td>
                @endforeach

              </tbody>
             </table>
        </div>


        <div class="row mt-4">
            <div class="col-sm-12">
              {{ count($datas) }} dari {{ $datas->total() }}
            </div>
            <div class="col-sm-12">
              {{ $datas->links() }}
            </div>
          </div>


</div>
@push('select2')
 
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script>
    $(document).ready(function() {
      $('#kategori').select2();
              $('#kategori').on('change', function (e) {
                  var data = $('#kategori').select2("val");
              @this.set('kategori', data);
              });
    });
</script>
@endpush
