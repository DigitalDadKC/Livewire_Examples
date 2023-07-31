<div>
    <div class="row mb-3 p-2">
        <div class="col-md-3">
            <label for="">Continent</label>
            <select wire:model="byContinent" name="" id="" class="form-control">
                <option value="">None Selected</option>
                @foreach($continents as $continent)
                    <option value="{{$continent->id}}">{{$continent->continent_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="">Search</label>
            <input type="text" class="form-control" wire:model.debounce.350ms="search">
        </div>
        <div class="col-md-2">
            <label for="">Per Page</label>
            <select name="" id="" class="form-control" wire:model="perPage">
                <option value="5">5</option>
                <option value="10">15</option>
                <option value="15">25</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="">Order By</label>
            <select name="" id="" class="form-control" wire:model="orderBy">
                <option value="country_name">Country Name</option>
                <option value="capital_city">Capital City</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="">Sort by</label>
            <select name="" id="" class="form-control" wire:model="sortBy">
                <option value="asc">ASC</option>
                <option value="desc">DESC</option>
            </select>
        </div>
    </div>
    <button class="btn btn-primary btn-sm mb-3" wire:click="OpenAddCountryModal()">Add New Country</button>
    <div>
        @if ($checkedCountry)
            <button class="btn btn-danger" wire:click="deleteCountries()">Selected Countries({{count($checkedCountry)}})</button>
        @endif
    </div>
    <table class="table table-hover">
        <thead class="thead-inverse">
            <th></th>
            <th>Continent</th>
            <th>Country</th>
            <th>Capital City</th>
            <th>Actions</th>
            <th></th>
        </thead>
        <tbody>
            @forelse($countries as $country)
            <tr class="{{$this->isChecked($country->id)}}">
                <td><input type="checkbox" value="{{$country->id}}" wire:model="checkedCountry"></td>
                <td>{{$country->continent->continent_name}}</td>
                <td>{{$country->country_name}}</td>
                <td>{{$country->capital_city}}</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-danger btn-sm" wire:click="deleteConfirm({{$country->id}})">Delete</button>
                        <button class="btn btn-success btn-sm" wire:click="OpenEditCountryModal({{$country->id}})">Edit</button>
                    </div>
                </td>
            </tr>
            @empty
                <code>No Country Found!</code>
            @endforelse
        </tbody>
    </table>
    @if(count($countries))
        {{$countries->links('livewire-pagination-links')}}
    @endif
    @include('modals.add-modal')
    @include('modals.edit-modal')
</div>
