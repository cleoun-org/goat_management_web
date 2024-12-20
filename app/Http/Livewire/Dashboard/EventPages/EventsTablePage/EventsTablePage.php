<?php

namespace App\Http\Livewire\Dashboard\EventPages\EventsTablePage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Models\Event;

class EventsTablePage extends _Dashboard
{

    public $page_title = "Tabel Event Peternakan";

    public $queryString = ['search_field', 'search_operator', 'search_value', 'page_size'];

    public $searchable_fields = [
        ['name', 'Nama'], ['note', 'Catatan'], ['date', 'Tanggal Event'],
    ];

    public function mount()
    {
        $this->pushBread(1, $this->page_title);
        $this->defaultSearchAttr("name", "like");
    }

    public function render()
    {
        try {
            
            $user = auth_user();

            $page_size = $this->page_size;

            if($this->search_value != null) {

                $opr = $this->searchOperator();

                $events = Event::where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                    ->orderBy('created_at', 'DESC')->paginate($page_size);

            } else {
                $events = Event::orderBy('created_at', 'DESC')->paginate($page_size);
            }

            $data['events'] = $events;
            $data['user'] = $user;
            $data['pageTitle'] = $this->page_title;

            return view('livewire.dashboard.event-pages.events-table-page.events-table-page', $data)
                ->layout('layouts.app', $data);

        } catch (\Throwable $th) {

            $this->onRenderError($th);
        }
    }
}
