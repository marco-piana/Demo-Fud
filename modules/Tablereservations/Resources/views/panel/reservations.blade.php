<div class="row">
    @include('tablereservations::panel.modals')
    <div class="col-12">
        <div class="row">
            <div class="col-8">
                <div class="header">
                    <div class="header-body">
                        <h1 class=" mt-5 ml-3">@{{ selectedDateText }} {{ __('reservations') }}</h1>
                    </div>    
                </div>
            </div>
            <div class="col-4 mt-5">
                <div class="input-group mb-3">
                    <input v-model="search" type="text" class="form-control" placeholder="{{__('Search by name, phone or reservation code')}}" aria-label="Search" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primarys" type="button" id="button-addon2">
                            <svg style="height: 24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-6">
                                <path fillRule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clipRule="evenodd" />
                              </svg>
                              
                              
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
   
    <div class="col-12">
        <div class="nav-wrapper">
            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                        href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1"
                        aria-selected="true"><i class="ni ni-cloud-upload-96 mr-2"></i>{{ __('Upcoming')}}
                        <span class="badge badge-primary">@{{ upcomingCount }}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-floor-tab" data-toggle="tab"
                        href="#tabs-icons-text-floor" role="tab" aria-controls="tabs-icons-text-floor"
                        aria-selected="true"><i class="ni ni-cloud-upload-96 mr-2"></i>{{ __('Overview')}}
                    </a>
                </li>
                <li v-if="isToday" class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                        href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                        aria-selected="false"><i class="ni ni-bell-55 mr-2"></i>{{ __('Seated')}}
                        <span class="badge badge-primary">@{{ seatedCount }}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab"
                        href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3"
                        aria-selected="false"><i class="ni ni-calendar-grid-58 mr-2"></i>
                        {{ __('Pending')}}
                        <span class="badge badge-danger">@{{ pendingCount }}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                aria-labelledby="tabs-icons-text-1-tab">
                <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                    aria-labelledby="tabs-icons-text-1-tab">


                   
                    <div  v-for="reservation in upcoming" >
                        @include('tablereservations::panel.reservation')
                    </div>
                    <div v-if="upcoming.length==0" class="text-center">
                        <p class="text-mutted mt-4">{{ __('No upcoming reservations for')}} @{{ selectedDateText }}</p>
                    </div>
                        
                 

                    

                    
                </div>
            </div>

            <div class="tab-pane fade text-center" id="tabs-icons-text-floor" role="tabpanel" aria-labelledby="tabs-icons-text-floor-tab">
                @include('tablereservations::panel.plans')
            </div>

            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel"
                aria-labelledby="tabs-icons-text-2-tab">
                <div  v-for="reservation in seated" >
                    @include('tablereservations::panel.reservation')
                </div>
                <div v-if="seated.length==0" class="text-center">
                    <p class="text-mutted mt-4">{{ __('No seated customers')}}</p>
                </div>

            </div>
            <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel"
                aria-labelledby="tabs-icons-text-3-tab">
                <div v-if="pending.length==0" class="text-center">
                    <p class="text-mutted mt-4">{{ __('No pending reservations')}}</p>
                </div>
                <div v-else class="text-center">
                    <p class="text-mutted mt-4">{{ __('All pending reservations are displayed')}}</p>
                </div>
                <div  v-for="reservation in pending" >
                    @include('tablereservations::panel.reservation')
                </div>


            </div>
        </div>
    </div>
</div>