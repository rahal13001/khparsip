<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class Profile extends Component
{
    public $user;
    public $editing = false;
    public $name;
    public $email;

    public function mount()
    {
        $this->user = auth()->user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }
    public function edit()
    {
        $this->editing = true;
    }

    public function cancel()
    {
        $this->editing = false;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    public function update()
    {
        // Validate the form data...

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->editing = false;
    }

    public function render()
    {
        
        return view('livewire.user.profile', [
            'user' => $this->user,
            'editing' => $this->editing,
        ]);
    }
}
