<?php

namespace App\Http\Livewire\Superadmin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Assignrole extends Component
{

  


    protected $listeners = ['updateUserKategori' => 'render'];


    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $cari ="";
    public $checked = [];
    public $selectPage= false;
    public $selectAll=false;
    public $paginate = 10;
    public $orderby = "created_at";
    public $asc = "DESC";
    public $editedroleIndex = Null;
    public $setroles = [];
    public $permissions = [];
    public $name, $role_pilih, $permissions_pilih, $role_edit, $permission_id, $role_id;

    
    public function updatedChecked(){
        $this->selectPage =false;
    }

    
    public function isChecked($role_id)
    {
        return in_array($role_id, $this->checked);
    }

    public function deleteDatas(){
        
        $roles = Role::whereKey($this->checked)->delete();
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


    public function deleteSatuData($role_id){
        
        Role::where('id', $role_id)->delete();

        $this->checked = array_diff($this->checked, [$role_id]);
        
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
        // $this->setroles = Role::all()->toArray();
        $this->permissions_pilih = Permission::get();

        return view('livewire.superadmin.assignrole', [
            "roles_pilih" => $this->roles,
            "permissions_pilih" => $this->permissions_pilih,

        ]);
    }


    public function selectAll(){
        $this->selectAll=true;
        $this->checked = $this->rolesQuery->pluck('id')->toArray();
    }

    public function selectPart(){
        $this->selectAll=false;
        $this->checked = $this->roles->pluck('id')->toArray();
    }

    public function updatedSelectPage($value){
        if ($value) {
            $this->checked = $this->roles->pluck('id')->toArray();
        } else {
            $this->checked = [];
        }
        
    }

    public function getrolesProperty(){
        return $this->rolesQuery->paginate($this->paginate);
    }

    public function getrolesQueryProperty(){
       return Role::where('name','like','%'.$this->cari.'%')
        ->orWhereHas('permissions', function($datapermissions){
                $datapermissions->where('name','like','%'.$this->cari.'%');
            })->orderBy($this->orderby, $this->asc);
    }

}
