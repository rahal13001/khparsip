<?php

namespace App\Http\Livewire\Superadmin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role as ModelRole;

class Role extends Component
{

    protected $listeners = ['updaterole' => 'render'];


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


    
    public function updatedChecked(){
        $this->selectPage =false;
    }

    
    public function isChecked($role_id)
    {
        return in_array($role_id, $this->checked);
    }

    public function deleteDatas(){
        
        $roles = ModelRole::whereKey($this->checked)->delete();
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
        
        ModelRole::destroy($role_id);

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
        return view('livewire.superadmin.role', [
        "roles" => $this->roles,
        "setroles" => $this->setroles
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
       return ModelRole::when($this->cari, function($query){
            $query->where('name','like','%'.$this->cari.'%');
       })->orderBy($this->orderby, $this->asc);
    }


    public function editrole($roleIndex){
        $this->editedroleIndex = $roleIndex;
    }


    public function saverole($roleIndex){
        $role = $this->setroles[$roleIndex] ?? NULL;
      
        if (!is_null($role)) {
            $editedrole = ModelRole::where('id', $this->editedroleIndex);
            if ($editedrole) {
                $editedrole->update($role);
            }

        }

        $this->editedroleIndex = Null;
    }
}
