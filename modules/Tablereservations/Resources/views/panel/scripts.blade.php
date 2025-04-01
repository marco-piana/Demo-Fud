<script>
    "use strict";
    var lastid=null;
    var Reservations = null;

    var pusherConn = null;
    var pusherConnForUpdates = null;
    var channel = null;
    var channelUpdate=null;
    var pusherActiveChat=null;
    var companyID="<?php echo auth()->user()->company_id; ?>";
    var serverTimezone = "<?php echo config('app.timezone'); ?>";
    var pusherAvailable=false;



    var initPusher=function(){
        if (typeof Pusher !== 'undefined') {
            // The variable is defined
            // You can safely use it here
            Pusher.logToConsole = false;

            pusherConn = new Pusher(PUSHER_APP_KEY, {
                cluster: PUSHER_APP_CLUSTER
            });
            pusherAvailable=true;

            pusherConnForUpdates = new Pusher(PUSHER_APP_KEY, {
                cluster: PUSHER_APP_CLUSTER
            });

            //Bind to new chat list update
            channelUpdate = pusherConnForUpdates.subscribe('chatupdate.'+companyID);
            channelUpdate.bind('general', chatListUpdate);

            

        } else {
            // Pusher
            js.notify("Error: Pusher is not defined. New reservations will not show up","danger");
        }
    }


    var connectToChannel=function(chatID){
        if(pusherActiveChat!=chatID && pusherAvailable){
            if(channel!=null){
                //Change chat, release old one
                channel.unsubscribe();
                channel.unbind('general', receivedMessageInPusher);
            }
            //Set active chat
            pusherActiveChat=chatID;

            //Bind to new chat
            channel = pusherConn.subscribe('chat.'+chatID);
            channel.bind('general', receivedMessageInPusher);

            

        }else{
            //Same chat, no changes
        }
    }

    function playSound() {
        var audio = new Audio('/vendor/meta/pling.mp3');
        audio.play();
    }

    function escapeSingleQuotesInJSON(jsonString) {
        // Use a regular expression to find and replace single quotes inside string values
        const escapedJSONString = jsonString.replace(/"([^"]*?)":\s*"([^"]*?)"/g, function(match, key, value) {
            const escapedValue = value.replace(/'/g, "\\'");
            return `"${key}": "${escapedValue}"`;
        });

        return escapedJSONString;
    }

    var getReservationsJS=function(area,date){
        axios.get('/api/getreservations/'+area+'/'+date).then(function (response) {
            if(response.data.status=="success"){
                
                //Set all to empty
                Reservations.upcomingAll=[];
                Reservations.upcoming=[];
                Reservations.seatedAll=[];
                Reservations.seated=[];
                Reservations.pendingAll=[];
                Reservations.pending=[];


                //Upcoming
                var upcomming=response.data.upcoming;
                Reservations.upcomingAll=upcomming
                Reservations.upcoming=upcomming;

                //Seated
                var seated=response.data.seated;
                Reservations.seatedAll=seated;
                Reservations.seated=seated;

                //Pending
                var pending=response.data.pending;
                Reservations.pendingAll=pending;
                Reservations.pending=pending;

                
            }else{
                console.log(response);
            }
            
        }).catch(function (error) {
            
        });
    }

    window.onload = function () {
       
        //VUE Chat list
        Vue.config.devtools=true;
        
        Reservations = new Vue({
            el: '#reservation_panel',
            data: {
                search: '',
                areas:  @json($areas),
                areasForFloorPlan: @json($areasForFloorPlan),
                dates:  @json($dates),
                selectedAreaText:@json($areas)[0].name,
                selectedArea:0,
                selectedDateText:@json($dates)[0].name,
                selectedDate:@json($dates)[0].date,
                upcomingAll: [],
                upcoming: [],
                seatedAll: [],
                seated: [],
                pendingAll: [],
                pending: [],
                tab:"all",
                selectedTable:null,
                selectedReservation:null,
                reservationsForTable:[],
                availableTables: [],
            },
            methods:{
                changeArea:function(areaID,areaName){
                    this.selectedArea=areaID;
                    this.selectedAreaText=areaName;
                },
                changeDate:function(dateID,dateName){
                    this.selectedDate=dateID;
                    this.selectedDateText=dateName;
                },
                shouldWeShow:function(areaId){
                    if(this.selectedArea==0){
                        return true;
                    }else{
                        return this.selectedArea==areaId;
                    }
                },
                showTableModal:function(table){
                    console.log(table);
                    this.reservationsForTable=[];
                    //Find reservations for this table from upcoming and seated
                    this.reservationsForTable=this.upcomingAll.concat(this.seatedAll).filter(function (item) {
                        return item.table_id==table.id;
                    });

                

                    //Show modal
                   // this.$refs['modal-table-details'].size="lg";
                    this.$refs['modal-table-details'].show();
                    //this.$refs['modal-table-details'].size="lg";
                    


                },
                getReservationStatusClass:function(tableID){

                    //Find sseated
                    var reservation=this.seatedAll.find(function (item) {
                        return item.table_id==tableID;
                    });
                    if(reservation){
                        return "seated";
                    }

                    var reservation=this.upcomingAll.find(function (item) {
                        return item.table_id==tableID;
                    });
                    if(reservation){
                        return "soon";
                    }


                    
                    return "";
                },
                selectTable:function(reservation){
                    this.availableTables=[];
                    this.selectedReservation=reservation

                    //Get available tables
                    axios.post('/api/getavailabletables/',{
                      
                            
                            date: reservation.reservation_date,
                            time: reservation.reservation_time,
                            guests: reservation.number_of_guests,
                            token: "-",
                            period: reservation.expected_occupancy
                        
                    
                    }).then(function (response) {
                        if(response.data.status=="success"){
                            Reservations.availableTables=[];
                            Reservations.availableTables.push({ value: null, text: 'Please select an option' });
                            var tablesByRestoArea = {};
                            response.data.tables.forEach(function(table){
                                if(!tablesByRestoArea[table.restoarea_id]){
                                    tablesByRestoArea[table.restoarea_id] = [];
                                }
                                tablesByRestoArea[table.restoarea_id].push({ value: table.id, text: table.name, restoareaname: table.restoarea.name});
                            });
                            for(var restoAreaId in tablesByRestoArea){
                                Reservations.availableTables.push({
                                    label: tablesByRestoArea[restoAreaId][0].restoareaname,
                                    options: tablesByRestoArea[restoAreaId]
                                });
                            }
                        
                        }else{
                            js.notify("Error: "+response.data.message,"danger");
                        }
                    }).catch(function (error) {
                        js.notify("Error: "+error,"danger");
                    });

                    //Open modal
                    this.$refs['modal-set-table'].show()
                },
                handleOKOnSelectTable:function(bvModalEvent){
                    //Update reservation
                    console.log("--Do a confirmation--");
                    axios.post('/api/updatereservation/',{'reservation_id':this.selectedReservation.id,'token':"-",'status':"confirmed",'table_id':this.selectedTable}).then(function (response) {
                        if(response.data.status=="success"){
                            js.notify("Reservation confirmed","success");
                            getReservationsJS(Reservations.selectedArea,Reservations.selectedDate);
                        }else{
                            js.notify("Error: "+response.data.message,"danger");
                        }
                    }).catch(function (error) {
                        js.notify("Error: "+error,"danger");
                    });
                },
                updateReservation:function(reservation,status){
                    //Make a post call to update
                    axios.post('/api/updatereservation/',{'reservation_id':reservation.id,'token':"-",'status':status}).then(function (response) {
                        if(response.data.status=="success"){
                            if (status === "canceled") {
                                js.notify("Reservation canceled","success");
                            } else if (status === "seated") {
                                js.notify("Reservation seated","success");
                            } else if (status === "done") {
                                js.notify("Reservation done","success");
                            } else if (status === "confirmed") {
                                js.notify("Reservation confirmed","success");
                            }
                            getReservationsJS(Reservations.selectedArea,Reservations.selectedDate);
                        }else{
                            js.notify("Error: "+response.data.message,"danger");
                        }
                    }).catch(function (error) {
                        js.notify("Error: "+error,"danger");
                    });

                }
            },
            watch: {
                selectedArea: function(val, oldVal) {
                    getReservationsJS(val,this.selectedDate);
                },
                selectedDate: function(val, oldVal) {
                    getReservationsJS(this.selectedArea,val);
                },
                search: function(val, oldVal) {
                    if(val==""){
                        this.upcoming=this.upcomingAll;
                        this.seated=this.seatedAll;
                        this.pending=this.pendingAll;
                    }else{
                        //Filter upcoming by name, phone, or reservation code
                        this.upcoming = this.upcomingAll.filter(function (item) {
                            return item.customer.name.toLowerCase().includes(val.toLowerCase()) ||
                                item.customer.phone.toLowerCase().includes(val.toLowerCase()) ||
                                item.reservation_code.toLowerCase().includes(val.toLowerCase());
                        });

                        //Filter seated by name, phone, or reservation code
                        this.seated = this.seatedAll.filter(function (item) {
                            return item.customer.name.toLowerCase().includes(val.toLowerCase()) ||
                                item.customer.phone.toLowerCase().includes(val.toLowerCase()) ||
                                item.reservation_code.toLowerCase().includes(val.toLowerCase());
                        });

                        //Filter pending by name
                        this.pending = this.pendingAll.filter(function (item) {
                            return item.customer.name.toLowerCase().includes(val.toLowerCase()) ||
                                item.customer.phone.toLowerCase().includes(val.toLowerCase()) ||
                                item.reservation_code.toLowerCase().includes(val.toLowerCase());
                        });
                    }
                }
            },
            computed: {
                isToday:function(){
                    return this.selectedDate==this.dates[0].date;
                },
                upcomingCount: function() {
                    return this.upcoming.length;
                },
                seatedCount: function() {
                    return this.seated.length;
                },
                pendingCount: function() {
                    return this.pending.length;
                }
            }

        })

        getReservationsJS(Reservations.selectedArea,Reservations.selectedDate);
        $('#navbar-main').hide();
    }
</script>