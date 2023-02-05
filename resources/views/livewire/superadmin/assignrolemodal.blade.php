{{-- Create Assign --}}
<div wire:ignore.self class="modal fade modal-dialog modal-lg" id="assignRoleModal" tabindex="-1" role="dialog" aria-labelledby="assignRoleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignRoleLabel">Assign Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
            
                
                <div class="col-sm-12">
                    <label for="selected">Pilih Role</label> <br>
                    <select class="form-select mb-3 {{$errors->first('selected') ? "is-invalid" : "" }} select2" id="role" wire:model = "name">
                     
                      @foreach ($roles_pilih as $role_pilih)
                          <option value="{{ $role_pilih->id }}">{{ $role_pilih->name }}</option>
                      @endforeach
           
                    </select>

                    @error('selected')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="col-sm-12">
                    <label>Pilih Permission</label>
                    @foreach ($permissions_pilih as $permission_pilih)

                    <div class="form-check">
                        
                            <input class="form-check-input" type="checkbox" id="permissions" multiple wire:model="permissions" value="{{ $permission_pilih->id }}">
                            <label class="form-check-label" for="permissions">
                                {{ $permission_pilih->name }}
                            </label>
                   
                    </div>
                    @endforeach
                   
                  </div>
                      
            <div class="text-center mt-3">
                <button class="btn btn-primary" wire:click = "create" type="submit">Kirim</button>
            </div>

        </div>



        </div>
    </div>
</div>

{{-- Update Assign --}}
<div wire:ignore.self class="modal fade modal-dialog modal-lg" id="updateAssignRoleModal" tabindex="-1" role="dialog" aria-labelledby="updateAssignRoleModal"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateAssignRoleLabel">Update Assign Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="col-sm-12">
                @if($role_id)
                Permission Terekam : <br>
                @foreach ($role_id->getPermissionNames() as $nama)
                    @if (!$loop->last && !$loop->first)
                        ,
                    @endif
                    @if (!$loop->first && $loop->last)
                        dan
                    @endif
                        {{$nama  }}
                @endforeach
                </div>
             
               
                  <div class="col-sm-12 mt-2">
                    <label>Pilih Kembali Permission</label>
                  
                    @foreach ($permissions_pilih as $permission_pilih)
                    <div class="form-check">
                            <input
                                {{{ $role_id->permissions()->find($permission_pilih->id) ? "checked" : ""}}}
                            class="form-check-input" type="checkbox" id="permissions" multiple wire:model="permissions" value="{{ $permission_pilih->id }}" multiple>
                            <label class="form-check-label" for="permissions">
                                {{ $permission_pilih->name }}
                            </label>
                    </div>
                    @endforeach
                    @endif
                   
                  </div>
                      
            <div class="text-center mt-3">
                <button class="btn btn-primary" wire:click = "create" type="submit">Kirim</button>
            </div>

        </div>



        </div>
    </div>
</div>
