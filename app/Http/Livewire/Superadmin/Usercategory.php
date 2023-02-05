<?php

namespace App\Http\Livewire\Superadmin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;

use Livewire\Component;

class Usercategory extends Component
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
    public $editedcategoryIndex = Null;
    public $setcategories = [];




    public function render() : View
    {

        return view('livewire.superadmin.usercategory', [
            "users" => $this->users,
            "setcategories" => $this->setcategories,
            
        ]);
    }

    public function getusersProperty(){
        return $this->usersQuery->paginate($this->paginate);
    }

    public function getusersQueryProperty(){
        
       return User::cari(trim($this->cari))
        ->orderBy($this->orderby, $this->asc);
    }

}
