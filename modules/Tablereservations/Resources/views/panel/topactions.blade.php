<div class="row">
    <div class="col-4">
        <!-- A button for drop down of area selection -->
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @{{ selectedAreaText }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a v-for="area in areas" class="dropdown-item"  @click="changeArea(area.id,area.name)" >@{{ area.name }}</a>
                
            </div>
        </div>

        <!-- A button for drop down of data selection -->
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @{{ selectedDateText }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a v-for="date in dates" class="dropdown-item"  @click="changeDate(date.date,date.name)" >@{{ date.name }}</a>
                
            </div>
        </div>
    </div>
    <div class="col-4">
        <!-- Center -->
    </div>
    <div class="col-4 text-right ">
        <!-- Walk in customer -->
        <a href="{{ route('tablereservations.create') }}?status=seated" class="btn btn-icon btn-success" type="button">
           
            <span class="btn-inner--text">{{ __('Walk in customer') }}</span>
        </a>
         <!-- Phone reservation -->
         <a href="{{ route('tablereservations.create') }}" class="btn btn-icon btn-success" type="button">
            
            <span class="btn-inner--text">{{ __('Phone reservation') }}</span>
         </a>
    </div>
</div>