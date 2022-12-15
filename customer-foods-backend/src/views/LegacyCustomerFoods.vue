<template>
  <div>
    <div class="notification component-notification"
         :class="{
                    'is-visible': notification.visible,
                    'is-danger': notification.type == 'error',
                    'is-info': notification.type == 'normal',
                    'is-success': notification.type == 'success'}"
    >
             <span class="icon mdi"
                   :class="{'mdi-alert': notification.type == 'error',
                 'mdi-information': notification.type == 'normal',
                 'mdi-check-bold': notification.type == 'success'}"
             ></span>
      <span v-text="notification.text"></span>
    </div>
    <progress class="progress"
              :class="processing ? 'is-processing': 'not-processing'">
    </progress>
    <div class="box has-background-white-bis">
      <div class="columns is-mobile">
        <div class="column is-hidden-mobile is-one-fifth-tablet">
          <h2 v-text="itemNaming.plural"></h2>
        </div>
        <div class="column is-three-fifths-mobile is-three-fifths-tablet">
          <div class="columns is-mobile">
            <div class="column is-three-fifths-mobile">
              <div class="field is-horizontal">
                <div class="field-label is-normal is-hidden-mobile">
                  <label class="label">Buscar: </label>
                </div>
                <div class="field-body">
                  <div class="field">
                    <p class="control">
                      <input class="input is-small" type="text" v-model="term"
                             @keyup="setFilter()"
                      >
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="column is-one-fifth-mobile">
              <button class="button is-active btn-remove-filter" @click="removeFilter()"
                      :class="processing ? 'is-loading' : ''"
              >
                <span class="mdi mdi-filter-remove-outline"></span>
              </button>
            </div>
          </div>
        </div>

        <div class="column right-align is-one-fifth-tablet">
          <button class="button is-active is-success" @click="createItem()">
            <span class="mdi mdi-plus"></span><span>Crear <span v-text="itemNaming.singular"></span></span>
          </button>
        </div>
      </div>
      <div class="columns table-wrapper">
        <table class="table crud-table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
          <thead>
          <tr>
            <th v-for="header in headers" v-text="header.text"></th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, cindex) in items">
            <td v-for="header in headers">
              <span v-if="header.value != 'actions'"
                    v-text="item[header.value]">
              </span>
              <span v-else>
                  <button class="button is-info is-outlined" @click="editItem(item)">
                      <span class="icon mdi mdi-pencil"></span>
                  </button>
                  <button class="button is-danger is-outlined" @click="confirmDelete(item)">
                      <span class="icon mdi mdi-delete"></span>
                  </button>
              </span>
            </td>
          </tr>
          <tr v-if="items.length == 0">
            <td :colspan="headers.length-1">Sin datos</td>
            <td>
              <button class="button" disabled></button>
            </td>
          </tr>
          </tbody>
          <tfoot>
          <tr>
            <td :colspan="headers.length">
              <button class="button is-light"
                      :disabled="processing || parseInt(currentPage) === 1"
                      @click="setPage(currentPage - 1)"
              >Anterior
              </button>
              <button v-for="page in indexPages" v-text="page"
                      class="button"
                      :class="[( parseInt(currentPage) === parseInt(page) )? 'active' : 'is-light']"
                      :disabled="processing || page === currentPage || page === '...'"
                      @click="setPage(page)"
              ></button>
              <button class="button is-light"
                      :disabled="processing || parseInt(currentPage) ===  parseInt(pagesNumber)"
                      @click="setPage(currentPage + 1)"
              >Siguiente
              </button>
              <div class="is-hidden-mobile">
                        <span v-if="term.length >= 3">
                            Mostrando <span v-text="itemsNumber"></span> resultados que contienen: <span
                          v-text="term" class="bold"></span>
                        </span>
                <span v-else>
                        Mostrando
                            <span v-text="itemsNumber"></span>&nbsp;
                            <span v-text="itemNaming.plural"></span>
                            en <span v-text="pagesNumber"></span> páginas
                        </span>
              </div>
            </td>
          </tr>
          </tfoot>
        </table>
      </div>
      <div class="modal modal-customer-foods" :class="dialog ? 'is-active':''">
        <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title" v-text="formTitle"></p>
            <button class="delete" aria-label="close" @click="close()"></button>
          </header>
          <section class="modal-card-body">

            <!-- columnS start -->
            <div class="columns">
              <div class="column">
                <div class="field">
                  <p class="control">
                    <input class="input" type="text"
                           placeholder="Nombre"
                           ref="autofocus"
                           v-model="editedItem.description" :disabled="editedIndex==-2"
                           @keypress.enter="save()"
                    >
                  </p>
                </div>
              </div>
              <div class="column">
                <div class="field">
                  <p class="control  has-icons-right">
                    <input class="input" type="text"
                           placeholder="Cantidad"
                           v-model="editedItem.amount" :disabled="editedIndex==-2"
                           @keypress.enter="save()"
                    >
                    <span class="icon is-right">gr</span>
                  </p>

                </div>
              </div>
            </div>
            <!-- columnS end -->

            <!-- columnS start -->
            <div class="columns">
              <div class="column">
                <div class="field">
                  <p class="control has-icons-right">
                    <input class="input" type="text"
                           placeholder="Proteínas"
                           v-model="editedItem.protein" :disabled="editedIndex==-2"
                           @keypress.enter="save()"
                    >
                    <span class="icon is-right">gr</span>
                  </p>
                </div>
              </div>
              <div class="column">
                <div class="field">
                  <p class="control has-icons-right">
                    <input class="input" type="text"
                           placeholder="Carbohidratos"
                           v-model="editedItem.carbohydrates" :disabled="editedIndex==-2"
                           @keypress.enter="save()"
                    >
                    <span class="icon is-right">gr</span>
                  </p>
                </div>
              </div>
            </div>
            <!-- columnS end -->

            <!-- columnS start -->
            <div class="columns">
              <div class="column">
                <div class="field">
                  <p class="control has-icons-right">
                    <input class="input" type="text"
                           placeholder="Grasas"
                           v-model="editedItem.fat" :disabled="editedIndex==-2"
                           @keypress.enter="save()"
                    >
                    <span class="icon is-right">gr</span>
                  </p>
                </div>
              </div>
              <div class="column">
                <div class="field">
                  <p class="control has-icons-right">
                    <input class="input" type="text"
                           placeholder="Kilocalorías"
                           v-model="editedItem.kCalories" :disabled="editedIndex==-2"
                           @keypress.enter="save()"
                    >
                    <span class="icon is-right">gr</span>
                  </p>
                </div>
              </div>
            </div>
            <!-- columnS end -->
            <div class="columns">
              <div class="column">
                <div class="field">
                  <textarea class="textarea"
                            placeholder="Comentarios"
                            v-model="editedItem.comments" :disabled="editedIndex==-2"
                            rows="2">
                  </textarea>
                </div>
              </div>
            </div>

            <div class="columns">
              <div class="column">
                <button class="button is-small is-link is-outlined is-fullwidth"
                        @click="toggleDetails()"
                >
                  Detalles nutricionales
                </button>
              </div>
            </div>
            <div v-if="detailsAreVisible"
                 class="collapse">

              <div class="columns">
                <div class="column">
                  <p class="advice">
                    Si conoce los siguientes datos del alimento que esta ingresando, llene los siguientes campos, de lo
                    contrario, deje en blanco
                  </p>
                </div>
              </div>

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Vit A"
                             v-model="editedItem.vitA" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Vit B-1"
                             v-model="editedItem.vitB1" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Vit B-2"
                             v-model="editedItem.vitB2" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Vit B-3"
                             v-model="editedItem.vitB3" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Vit B-5"
                             v-model="editedItem.vitB5" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Vit B-6"
                             v-model="editedItem.vitB6" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Vit B-9"
                             v-model="editedItem.vitB9" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Vit B-12"
                             v-model="editedItem.vitB12" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Vit C"
                             v-model="editedItem.vitC" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Vit D"
                             v-model="editedItem.vitD" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Vit E"
                             v-model="editedItem.vitE" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Vit K"
                             v-model="editedItem.vitK" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Colina"
                             v-model="editedItem.choline" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Calcio"
                             v-model="editedItem.calcium" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Cobre"
                             v-model="editedItem.copper" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Hierro"
                             v-model="editedItem.iron" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Magnesio"
                             v-model="editedItem.magnesium" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Manganeso"
                             v-model="editedItem.manganese" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Fósforo"
                             v-model="editedItem.phosphorus" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Potasio"
                             v-model="editedItem.potassium" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Selenio"
                             v-model="editedItem.selenium" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Sodio"
                             v-model="editedItem.sodium" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Zinc"
                             v-model="editedItem.zinc" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Agua"
                             v-model="editedItem.water" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Fibra"
                             v-model="editedItem.fiber" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Colesterol"
                             v-model="editedItem.cholesterol" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Grasas Sat."
                             v-model="editedItem.saturatedFat" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Grasas Mono Sat."
                             v-model="editedItem.monoUnsaturatedFat" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->

              <!-- columnS start-->
              <div class="columns">
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Grasas Poli Sat."
                             v-model="editedItem.polyUnsaturatedFat" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
                <div class="column">
                  <div class="field">
                    <p class="control">
                      <input class="input" type="text"
                             placeholder="Índice Glicémico"
                             v-model="editedItem.glycemicIndex" :disabled="editedIndex==-2"
                             @keypress.enter="save()"
                      >
                    </p>
                  </div>
                </div>
              </div>
              <!-- columnS end-->
            </div>
          </section>
          <footer class="modal-card-foot">
            <div v-if="errors.length > 0" class="notification is-danger">
              <div v-for="error in errors">
                <span class="mdi mdi-alert"></span>&nbsp;&nbsp;
                <span v-text="error"></span>
              </div>
            </div>
            <progress class="progress"
                      :class="processing ? 'is-processing': 'not-processing'"></progress>

            <div class="columns">
              <div class="column">
                <button v-if="editedIndex==-2" class="button is-danger is-fullwidth is-active" @click="deleteItem()"

                        :class="processing ? 'is-loading' : ''">Si, borrar
                </button>
                <button v-else class="button is-fullwidth is-success is-active" @click="save()"
                        :class="processing ? 'is-loading' : ''">Guardar
                </button>
              </div>
              <div class="column">
                <button class="button is-fullwidth" @click="close()">Cancelar</button>
              </div>
            </div>
          </footer>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from '@/components/HelloWorld.vue'



export default {
  name: 'LegacyCustomerFoods',
  data() {
    return {
      dialog: false,
      headers: [
        {text: 'Id', value: 'id'},
        {text: 'Descripción', value: 'description'},
        {text: 'Cantidad', value: 'amount'},
        {text: 'Unidad', value: 'unit'},
        {text: 'Kcal', value: 'kCalories'},
        {text: 'Proteínas', value: 'protein'},
        {text: 'Carbohidratos', value: 'carbohydrates'},
        {text: 'Grasas', value: 'fat'},
        {text: 'Acciones', value: 'actions'},
      ],
      items: [],

      // pagination and filtering
      term: '',
      length: 10,
      page: 1,
      filterTimer: null,

      itemsNumber: 0,
      pagesNumber: 0,
      currentPage: 0,
      indexPages: [],

      // new, delete and edition
      editedIndex: -1, // -1 for new item, -2 for deleting item
      editedItem: {
        id: '',
        description: '',
        amount: '',
        unit: '',
        kCalories: '',
        protein: '',
        carbohydrates: '',
        fat: '',
        vitA: '',
        vitB1: '',
        vitB2: '',
        vitB3: '',
        vitB5: '',
        vitB6: '',
        vitB9: '',
        vitB12: '',
        vitC: '',
        vitD: '',
        vitE: '',
        vitK: '',
        choline: '',
        calcium: '',
        copper: '',
        iron: '',
        magnesium: '',
        manganese: '',
        phosphorus: '',
        potassium: '',
        selenium: '',
        sodium: '',
        zinc: '',
        water: '',
        fiber: '',
        cholesterol: '',
        saturatedFat: '',
        monoUnsaturatedFat: '',
        polyUnsaturatedFat: '',
        glycemicIndex: '',
        comments: ''
      },
      defaultItem: {
        id: '',
        description: '',
        amount: '100',
        unit: 'gr',
        kCalories: '',
        protein: '',
        carbohydrates: '',
        fat: '',
        vitA: '',
        vitB1: '',
        vitB2: '',
        vitB3: '',
        vitB5: '',
        vitB6: '',
        vitB9: '',
        vitB12: '',
        vitC: '',
        vitD: '',
        vitE: '',
        vitK: '',
        choline: '',
        calcium: '',
        copper: '',
        iron: '',
        magnesium: '',
        manganese: '',
        phosphorus: '',
        potassium: '',
        selenium: '',
        sodium: '',
        zinc: '',
        water: '',
        fiber: '',
        cholesterol: '',
        saturatedFat: '',
        monoUnsaturatedFat: '',
        polyUnsaturatedFat: '',
        glycemicIndex: '',
        comments: ''
      },

      // related data
      users: [],

      detailsAreVisible: false,

      // UI
      itemNaming: {
        singular: 'Alimento',
        plural: 'Alimentos revisados'
      },
      processing: false,
      errors: [],
      notification: {
        visible: false,
        text: '',
        type: '', // 'error', 'success', 'normal',
        timer: null,
        duration: 4000
      },
    }
  },
  computed: {
    formTitle() {
      switch (this.editedIndex) {
        case -1:
          return `Crear ${this.itemNaming.singular}`;
        case -2:
          return `¿Borrar ${this.itemNaming.singular}?`;
        default:
          return `Editar ${this.itemNaming.singular}`;
      }
    },
  },
  watch: {
    dialog() {
      if (this.dialog == true) {
        this.$nextTick(() => {
          this.$refs.autofocus.focus();
        });
      }
    }
  },
  mounted: function () {
    this.$nextTick(() => {
      this.setOptimalRowHeight();
      this.initialize();
    });
  },
  methods: {
    initialize() {
      this.getItems();
    },

    toggleDetails() {
      this.detailsAreVisible = !this.detailsAreVisible;
    },

    createItem() {
      this.editedItem = Object.assign({}, this.defaultItem)
      this.dialog = true;
    },
    editItem(item) {
      this.editedIndex = this.items.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true;
    },
    confirmDelete(item) {
      this.editedIndex = -2; //code for deleting
      this.editedItem = Object.assign({}, item)
      this.dialog = true;
    },
    close() {
      this.dialog = false;
      this.detailsAreVisible = false;
      this.$nextTick(() => {
        this.item = Object.assign({}, this.defaultItem)
        this.editedIndex = -1,
          this.errors = []
      })
    },
    save() {
      if (this.editedIndex > -1) {
        this.updateItem();
      } else {
        this.postItem();
      }
    },
    getItems() {
      this.processing = true;
      axiosPostApi('/init_legacy_customer_foods',
        {
          term: this.term,
          length: this.length,
          page: this.page
        },
        res => {
          this.items = res.data.legacy_customer_foods.itemsRows;
          this.itemsNumber = res.data.legacy_customer_foods.itemsNumber;
          this.pagesNumber = res.data.legacy_customer_foods.pagesNumber;
          this.currentPage = res.data.legacy_customer_foods.currentPage;
          this.setFooterPages();
          this.processing = false;
        });
    },
    postItem() {
      this.processing = true;
      axiosPostApi('/legacy_customer_food', {"item": this.editedItem}, res => {
        if (res.data.hasOwnProperty("errors") && res.data.errors.length) {
          this.showNotification("No se pudo guardar", "error");
          this.errors = res.data.errors;
        } else {
          this.close();
          this.getItems();
          this.showNotification('Guardado correctamente', 'success');
        }
        this.processing = false;
      });
    },
    updateItem() {
      this.processing = true;
      axiosPutApi('/legacy_customer_food', {"item": this.editedItem}, res => {
        if (res.data.hasOwnProperty("errors") && res.data.errors.length) {
          this.showNotification('No se pudo actualizar', 'error');
          this.errors = res.data.errors;
        } else {
          this.close();
          this.getItems();
          this.showNotification('Actualizado correctamente', 'success');
        }
        this.processing = false;
      });
    },
    deleteItem() {
      this.processing = true;
      axiosDeleteApi('/legacy_customer_food', {"item": this.editedItem}, res => {
        if (res.data.hasOwnProperty("errors") && res.data.errors.length) {
          this.showNotification('No se pudo borrar', 'error');
          this.errors = res.data.errors;
        } else {
          this.close();
          this.getItems();
          this.showNotification('Borrado correctamente', 'success');
        }
        this.processing = false;
      });
    },
    showNotification(text, type) {
      this.notification.visible = true;
      this.notification.text = text;
      this.notification.type = type;
      clearTimeout(this.notification.timer);
      this.notification.timer = setTimeout(() => {
        this.notification.visible = false;
      }, this.notification.duration);
    },
    setFooterPages() {
      this.pagesNumber = parseInt(this.pagesNumber);
      this.currentPage = parseInt(this.currentPage);
      this.indexPages = [];
      if (this.pagesNumber <= 7) {
        this.indexPages = this.pagesNumber;
      } else {
        // initial block (between the four first pages)
        if (this.currentPage <= 4) {
          this.indexPages = [1, 2, 3, 4, 5, '...', this.pagesNumber];
        }
        // final block (between the four final pages)
        else if (this.currentPage >= this.pagesNumber - 3) {
          this.indexPages = [1, '...', this.pagesNumber - 4, this.pagesNumber - 3, this.pagesNumber - 2, this.pagesNumber - 1, this.pagesNumber];
        } else {
          // medium block
          this.indexPages = [1, '...', this.currentPage - 1, this.currentPage, this.currentPage + 1, '...', this.pagesNumber];
        }
      }
    },
    setPage: function (pageNumber) {
      this.page = pageNumber;
      this.getItems();
    },
    setFilter: function () {
      clearTimeout(this.filterTimer);
      this.filterTimer = setTimeout(() => {
        this.setPage(1);
      }, 500);
    },
    removeFilter: function () {
      this.currentPage = 1;
      this.term = '';
      this.getItems();
    },
    setOptimalRowHeight() {
      // get window height - header height - space (top offset)
      let topOffset = window.getOffset(document.querySelector(".crud-table tbody")).top;
      let rowHeight = document.querySelector(".crud-table tbody td").offsetHeight;
      let documentHeight = document.querySelector("html").offsetHeight;
      let bottomOffset = document.querySelector(".crud-table tfoot").offsetHeight;
      this.length = Math.floor((documentHeight - topOffset - bottomOffset) / rowHeight);
    },
  }
}
</script>
