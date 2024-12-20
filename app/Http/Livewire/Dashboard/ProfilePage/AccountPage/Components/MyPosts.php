<?php

namespace App\Http\Livewire\Dashboard\ProfilePage\AccountPage\Components;

use Livewire\Component;

class MyPosts extends Component
{
    public $posts;

    public function mount()
    {
        $this->posts = [];
    }

    public function render()
    {
        return view('livewire.dashboard.profile-page.account-page.components.my-posts');
    }
}
