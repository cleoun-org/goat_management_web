<?php

namespace App\Http\Livewire\Dashboard\ProfilePage\AccountPage\Components;

use App\Http\Livewire\Dashboard\_Dashboard;
use Livewire\WithPagination;

class MilksTable extends _Dashboard
{
    use WithPagination;
    
    public $username;

    public $page_title = "Tabel Catatan Susu";

    public $search_field = 'name';
    public $search_operator = 'like';
    public $search_value;
    public $key;

    public $queryString = ['search_field', 'search_operator', 'search_value', 'key'];

    public $searchable_fields = [
        ['type', 'Tipe'], ['produced', 'Produksi'], ['consumption', 'Konsumsi']
    ];

    public function mount(string $username)
    {
        $this->pushBread(3, $this->page_title);
        $this->search_field = "type";
        $this->search_operator = "like";

        $this->username = $username;
    }

    public function render()
    {
        try {

            $user = get_user($this->username);

            $page_size = 5;

            if($page_size >= 40) {
                $page_size = 40;
            }

            if($this->search_value != null) {

                $opr = $this->searchOperator();

                $goats = $user->milknote()
                    ->where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                    ->orderBy('created_at', 'DESC')->paginate($page_size);

            } else {

                $goats = $user->milknote()->orderBy('created_at', 'DESC')->paginate($page_size);

            }

            $data['milks'] = $goats;

            $data['user'] = $user;

            return view('livewire.dashboard.profile-page.account-page.components.milks-table', $data);

        } catch (\Throwable $th) {

            $this->onRenderError($th);
        }
    }
}