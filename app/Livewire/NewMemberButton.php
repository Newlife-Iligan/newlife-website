<?php

namespace App\Livewire;

use Livewire\Component;

class NewMemberButton extends Component
{
    public function openModal()
    {
        $this->dispatch('open-modal');
    }

    public function render()
    {
        return view('livewire.new-member-button');
    }
}
