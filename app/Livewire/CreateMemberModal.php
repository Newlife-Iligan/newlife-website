<?php

namespace App\Livewire;

use App\Models\Members;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Support\Contracts\TranslatableContentDriver;
use Livewire\Component;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

// Import other form components as needed

class CreateMemberModal extends Component implements HasForms, HasActions
{
    use InteractsWithForms, InteractsWithActions;

    public ?array $data = [];
    public bool $showModal = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        // Copy the same form schema from your MembersResource
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required(),
                DatePicker::make('date_joined'),
                // Add other fields from your MembersResource form
            ])
            ->statePath('data');
    }

    #[On('open-modal')] 
    public function openModal()
    {
        $this->showModal = true;
        $this->dispatch('modal-opened');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->form->fill([]);
    }

    public function create()
    {
        $data = $this->form->getState();

        Members::create($data);

        $this->closeModal();

        // Optional: emit event or redirect
        $this->dispatch('member-created');
        session()->flash('success', 'Member created successfully!');
    }

    public function render()
    {
        return view('livewire.create-member-modal');
    }


}
