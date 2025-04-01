<div class="card mt-2">
    <div class="card-header">
        <div class="row">
            <div class="col-1">
                <!-- Avatar -->
                <img :src="reservation.customer.gravatar" alt="Avatar" class="avatar">
            </div>
            <div class="col-8">
                #{{ __('RES') }}: @{{ reservation.reservation_code }}<br />
                
                <span v-if='reservation.status!="late" && reservation.status!="no-show"' class="badge badge-success">@{{ reservation.status }}</span>
                <div v-else-if='reservation.status=="late" || reservation.status=="no-show"' class="badge badge-danger">@{{ reservation.status }}</div>
            </div>
            <div class="col-2 justify-content-end text-right">
                <!-- Action button -->
                <div v-if='reservation.status=="soon" || reservation.status=="confirmed"  || reservation.status=="late" || reservation.status=="no-show" ' class="upcoming justify-content-end text-right">
                    <!-- Seated button -->
                    <button @click="updateReservation(reservation,'cancelled')" class="btn btn-outline-danger btn-sm">{{ __('Cancel')}}</button>
                    <button @click="updateReservation(reservation,'seated')" class="btn btn-success btn-sm">{{ __('Seated')}}</button>
                </div>
                <div v-else-if='reservation.status=="seated"' class="pending justify-content-end text-right">
                    <!-- Seated button -->
                    <button  @click="updateReservation(reservation,'completed')" class="btn btn-outline-success btn-sm">{{ __('Completed')}}</button>
                </div>
                <div v-else-if='reservation.status=="pending"' class="pending justify-content-end text-right">
                    <!-- Seated button -->
                    <button @click="updateReservation(reservation,'cancelled')" class="btn btn-outline-danger btn-sm">{{ __('Cancel')}}</button>
                    <button @click="selectTable(reservation)" class="btn btn-outline-success btn-sm">Accept</button>
                </div>
                
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 container-fluid">
                <!-- Reservation details -->
                <div class="row clearfix">


                    <div class="col-xs-6 col-sm-4">
                        <p>
                            <svg style="height: 24px" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd"
                                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                    clip-rule="evenodd" />
                            </svg>
                            @{{ reservation.customer.name }}
                        </p>
                        <p>
                            <svg style="height: 24px" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor" className="size-6">
                                <path
                                    d="M10.5 18.75a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" />
                                <path fillRule="evenodd"
                                    d="M8.625.75A3.375 3.375 0 0 0 5.25 4.125v15.75a3.375 3.375 0 0 0 3.375 3.375h6.75a3.375 3.375 0 0 0 3.375-3.375V4.125A3.375 3.375 0 0 0 15.375.75h-6.75ZM7.5 4.125C7.5 3.504 8.004 3 8.625 3H9.75v.375c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V3h1.125c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-6.75A1.125 1.125 0 0 1 7.5 19.875V4.125Z"
                                    clipRule="evenodd" />
                            </svg>
                            @{{ reservation.customer.phone }}
                        </p>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <p>
                            <svg style="height: 24px" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor" className="size-6">
                                <path
                                    d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                <path fillRule="evenodd"
                                    d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                    clipRule="evenodd" />
                            </svg>
                            @{{ reservation.reservation_date }}
                        </p>
                        <p>
                            <svg style="height: 24px" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                                stroke="currentColor" className="size-6">
                                <path strokeLinecap="round" strokeLinejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>

                            @{{ reservation.reservation_time }}  ( @{{ reservation.expected_occupancy}} min )
                        </p>

                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <p>
                            <svg style="height: 24px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                              </svg>
                              
                            @{{ reservation.number_of_guests }}  
                        </p>
                        <p v-if="reservation.table"  >
                            <svg  style="height: 24px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                              </svg>
                              
                              
                             
                              <span  class="badge badge-pill badge-success"> @{{ reservation.table.restoarea.name }} - @{{ reservation.table.name }}</span>
                              
                        </p>

                    </div>


                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <span  v-if="reservation.special_requests" class="text-muted">{{ __('Note')}}: @{{ reservation.special_requests }}  </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>