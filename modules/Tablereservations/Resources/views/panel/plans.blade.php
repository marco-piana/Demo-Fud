@section('head')
  <!-- Import Interact --->
  <script src="{{ asset('vendor') }}/interact/interact.min.js"></script>
   <style>
       .canva {
            width: 1024px;
            height: 540px;
            background-color: #dee2e6;
            display: inline-block;
            text-align: center; 
            justify-content: center; 
            align-items: center;
            margin: auto;
            border-radius: 6px;
            border: dashed 2px rgba(0,0,0,0.2);
       }
       .resize-drag {
            width: 120px;
            border-radius: 2px;
            padding: 20px;
            background-color:#1aae6f;
            color: white;
            font-size: 20px;
            font-family: sans-serif;
            margins: "0px 2px 0px 2px";
            marginm: 1rem;
            touch-action: none;
            position: absolute;

            border: dashed 2px rgba(255, 255, 255,0.5);

            /* This makes things *much* easier */
            box-sizing: border-box;
            text-align: center;
          }
          .resize-drag.circle {
            border-radius: 60px;
            height: 120px;
          }
        .resize-drag p {
            text-align: center;
            justify-content:center;
            top: 0;
            opacity: 1
        }
        .resize-drag span {
            text-align: center;
            position: absolute;
            bottom: 0;
            opacity: 0.6
        }
        .seated {
            background-color: #29e;
        }
        .soon {
            background-color: #ffc107;
        },
        
   </style> 
@endsection

<template v-for="restoarea in areasForFloorPlan">
    <div v-if="shouldWeShow(restoarea.id)" class="card-body" style="display: inline-block; text-align: center; justify-content: center; align-items: center; background-color:#f4f5f7">
        <h4 class="text-mutted mt-3">@{{ restoarea.name }}</h4>
        <div class="canva" id="canvaHolder">
            <template v-for="table in restoarea.tables">
                <div 
                v-on:click="showTableModal(table)"
                :id="'drag-' + table.id" 
                :data-id="table.id" 
                :data-x="table.x"
                :data-y="table.y"
                :data-name="table.name"
                :data-rounded="table.rounded ? table.rounded : 'no'"
                :data-size="table.size"
                :class="['resize-drag ', table.rounded == 'yes' ? 'circle' : '',getReservationStatusClass(table.id)]" 
                :style="{ transform: 'translate(' + table.x + 'px, ' + table.y + 'px)', width: table.w + 'px', height: table.h + 'px' }">
                    <p> @{{ table.name }} </p>
                    <span>@{{ table.size }}</span>
                </div>
            </template>
        </div>
        <br />
    </div>  
</template>
