<?php

namespace App\Http\Livewire\Superadmin;

use Livewire\Component;
use Spatie\Permission\Models\Permission as ModelPermission;
use Livewire\WithPagination;

class Permission extends Component
{


    protected $listeners = ['updatepermission' => 'render'];


    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $cari ="";
    public $checked = [];
    public $selectPage= false;
    public $selectAll=false;
    public $paginate = 10;
    public $orderby = "created_at";
    public $asc = "DESC";
    public $editedpermissionIndex = Null;
    public $setpermissions = [];


    
    public function updatedChecked(){
        $this->selectPage =false;
    }

    
    public function isChecked($permission_id)
    {
        return in_array($permission_id, $this->checked);
    }

    public function deleteDatas(){
        
        $permissions = ModelPermission::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll=false;
        $this->selectPage=false;
        
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Data Berhasil Terhapus',
            'text' => '',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);
    }


    public function deleteSatuData($permission_id){
        
        ModelPermission::destroy($permission_id);

        $this->checked = array_diff($this->checked, [$permission_id]);
        
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Data Berhasil Terhapus',
            'text' => '',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.superadmin.permission', [
        "permissions" => $this->permissions,
        "setpermissions" => $this->setpermissions
        ]);
    }


    public function selectAll(){
        $this->selectAll=true;
        $this->checked = $this->permissionsQuery->pluck('id')->toArray();
    }

    public function selectPart(){
        $this->selectAll=false;
        $this->checked = $this->permissions->pluck('id')->toArray();
    }

    public function updatedSelectPage($value){
        if ($value) {
            $this->checked = $this->permissions->pluck('id')->toArray();
        } else {
            $this->checked = [];
        }
        
    }

    public function getpermissionsProperty(){
        return $this->permissionsQuery->paginate($this->paginate);
    }

    public function getpermissionsQueryProperty(){
       return ModelPermission::when($this->cari, function($query){
            $query->where('name','like','%'.$this->cari.'%');
       })->orderBy($this->orderby, $this->asc);
    }


    public function editpermission($permissionIndex){
        $this->editedpermissionIndex = $permissionIndex;
    }


    public function savepermission($permissionIndex){
        $permission = $this->setpermissions[$permissionIndex] ?? NULL;
      
        if (!is_null($permission)) {
            $editedpermission = ModelPermission::where('id', $this->editedpermissionIndex);
            if ($editedpermission) {
                $editedpermission->update($permission);
            }

        }

        $this->editedpermissionIndex = Null;
    }
}

