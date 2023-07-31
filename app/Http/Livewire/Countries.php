<?php

namespace App\Http\Livewire;

use App\Models\Country;
use Livewire\Component;
use App\Models\Continent;
use Livewire\WithPagination;

class Countries extends Component
{
    use WithPagination;

    public $continent, $country_name, $capital_city;
    public $upd_continent, $upd_country_name, $upd_capital_city, $cid;
    protected $listeners = ['delete', 'deleteCheckedCountries'];
    public $checkedCountry = [];
    public $byContinent = null;
    public $perPage = 5;
    public $orderBy = 'country_name';
    public $sortBy = 'asc';
    public $search;
    public function render()
    {
        return view('livewire.countries', [
            'continents' => Continent::orderBy('continent_name', 'asc')->get(),
            'countries' =>
            // doesn't work (yet)
            // Country::with('continents')->orderBy('continents.continent_name', 'asc')->get()

            // works
            // Country::select('countries.*')->join('continents', 'continents.id', '=', 'countries.continent_id')->orderBy('continents.continent_name')->paginate(5)

            // works
            // Country::orderBy(Continent::select('continents.continent_name')->whereColumn('continents.id', 'countries.continent_id'))->get()
            Country::when($this->byContinent, function ($query) {
                $query->where('continent_id', $this->byContinent);
            })
                ->search(trim($this->search))
                ->orderBy($this->orderBy, $this->sortBy)
                ->paginate($this->perPage)
        ]);
    }

    public function OpenAddCountryModal()
    {
        $this->continent = '';
        $this->country_name = '';
        $this->capital_city = '';
        $this->dispatchBrowserEvent('OpenAddCountryModal');
    }

    public function save()
    {
        $this->validate([
            'continent' => 'required',
            'country_name' => 'required|unique:countries',
            'capital_city' => 'required'
        ]);
        $save = Country::insert([
            'continent_id' => $this->continent,
            'country_name' => $this->country_name,
            'capital_city' => $this->capital_city
        ]);
        if ($save) {
            $this->dispatchBrowserEvent('CloseAddCountryModal');
            $this->checkedCountry = [];
        }
    }
    public function OpenEditCountryModal($id)
    {
        $info = Country::find($id);
        $this->upd_continent = $info->continent_id;
        $this->upd_country_name = $info->country_name;
        $this->upd_capital_city = $info->capital_city;
        $this->cid = $info->id;
        $this->dispatchBrowserEvent('OpenEditCountryModal', [
            'id' => $id
        ]);
    }
    public function update()
    {
        $cid = $this->cid;
        $this->validate([
            'upd_continent' => 'required',
            'upd_country_name' => 'required|unique:countries,country_name,' . $cid,
            'upd_capital_city' => 'required'
        ], [
            'upd_continent.required' => 'You must select a continent',
            'upd_country_name.required' => 'You must enter a country',
            'upd_country_name.unique' => 'That country is already taken',
            'upd_capital_city.required' => 'You must enter a capital city'
        ]);
        $update = Country::find($cid)->update([
            'continent_id' => $this->upd_continent,
            'country_name' => $this->upd_country_name,
            'capital_city' => $this->upd_capital_city
        ]);
        if ($update) {
            $this->dispatchBrowserEvent('CloseEditCountryModal');
            $this->checkedCountry = [];
        }
    }
    public function deleteConfirm($id)
    {
        $info = Country::find($id);
        $this->dispatchBrowserEvent('SwalConfirm', [
            'title' => 'Are you sure?',
            'html' => 'You want to delete <strong>' . $info->country_name . '</strong>',
            'id' => $id
        ]);
    }
    public function delete($id)
    {
        $del = Country::find($id)->delete();
        if ($del) {
            $this->dispatchBrowserEvent('deleted');
        }
        $this->checkedCountry = [];
    }

    public function deleteCountries()
    {
        $this->dispatchBrowserEvent('swal:deleteCountries', [
            'title' => 'Are you sure?',
            'html' => 'You want to delete these countries?',
            'checkedIDs' => $this->checkedCountry,
        ]);
    }
    public function deleteCheckedCountries($ids)
    {
        Country::whereKey($ids)->delete();
        $this->checkedCountry = [];
    }

    public function isChecked($countryID)
    {
        return in_array($countryID, $this->checkedCountry) ? 'bg-info text-white' : '';
    }
}