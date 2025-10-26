<?php

namespace App\Livewire;

use App\Models\JobApplication;
use Livewire\Component;
use Filament\Notifications\Notification;

class JobApplicationModal extends Component
{
    public $applicationId;
    public $application;
    public $allApplicationIds = [];
    public $currentIndex = 0;

    public function mount($applicationId)
    {
        $this->applicationId = $applicationId;
        $this->allApplicationIds = JobApplication::orderBy('created_at', 'desc')->pluck('id')->toArray();
        $this->currentIndex = array_search($applicationId, $this->allApplicationIds);
        $this->loadApplication();
    }

    public function loadApplication()
    {
        $this->application = JobApplication::with('job')->findOrFail($this->applicationId);
    }

    public function previousApplication()
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
            $this->applicationId = $this->allApplicationIds[$this->currentIndex];
            $this->loadApplication();
        }
    }

    public function nextApplication()
    {
        if ($this->currentIndex < count($this->allApplicationIds) - 1) {
            $this->currentIndex++;
            $this->applicationId = $this->allApplicationIds[$this->currentIndex];
            $this->loadApplication();
        }
    }

    public function updateStatus()
    {
        try {
            $this->application->save();

            Notification::make()
                ->title('Status Updated')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Update Failed')
                ->body('Could not update the status.')
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.job-application-modal');
    }
}
