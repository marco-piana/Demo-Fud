<div>
    <b-modal id="modal-set-table" @ok="handleOKOnSelectTable" ref="modal-set-table" title="Select a table" ok-variant="success" ok-title="Assign table and Accept" :ok-disabled="!selectedTable">
      <p class="my-4">List of available tables</p>
      <template>
        <div>
          <b-form-select v-model="selectedTable" :options="availableTables"></b-form-select>
          
        </div>
      </template>
    </b-modal>
    <b-modal ref="modal-table-details" scrollable  id="modal-table-details" size="lg" title="">
        <div  v-for="reservation in reservationsForTable" >
            @include('tablereservations::panel.reservation')
        </div>
    </b-modal>
  </div>