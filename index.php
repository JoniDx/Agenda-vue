<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/vuex@3.4.0/dist/vuex.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>

    <title></title>
  </head>


  <body>
  <div id="app">
    <Agenda>
    </Agenda>
    <hr>
    <label for=""> Agregar Contacto </label><br>

    <label for="">Nombre</label><br>
    <input type="text" v-model="nombreP"><br>
    <label for="">Telefono</label><br>
    <input type="number" v-model.number="telefonoP"><br>
    <label for="">Descripcion</label><br>
    <input type="text" v-model="descripcionP"><br>

    <button  @click="agregarC">Confirmar</button><br>


    <hr>
    <label for=""> EDITAR </label><br>

    <label for="">ID</label><br>
    <input type="number" v-model.number="idC"><br>
    <label for="">Nombre</label><br>
    <input type="text" v-model="nombreC"><br>
    <label for="">Telefono</label><br>
    <input type="number" v-model.number="telefonoC"><br>
    <label for="">Descripcion</label><br>
    <input type="text" v-model="descripcionC"><br>

    <button  @click="editC">Confirmar</button><br>

  </div>

<script>
// intentando un componente
  Vue.component('Agenda',{
    template:
    `
    <div>
    <button @click="obteneragenda">Abrir Agenda</button>
    <hr>
      <ul v-for="item of contactos">
        <li>{{item.id}}-{{item.nombre}} - {{item.numero}} - {{item.descripcion}}</li>
      </ul>

    </div>
    `,
    // mapeo lochon
    computed:{
      ...Vuex.mapState(['contactos'])
    },
    methods:{
     ...Vuex.mapMutations(['tomarContactos']),
      ...Vuex.mapActions(['obteneragenda']),

    }
  });
  // almacenamiento
  const store = new Vuex.Store({
    // la tiendita
    state:{
      contactos: []

    },
    mutations: {
    llenarC (state,contactosA) {
      state.contactos = contactosA
      }
    },
    // async get
    actions: {
      obteneragenda: async function ({ commit }){
        const data = await fetch('http://localhost/Pages/Portafolio2/public/api/contactos');
        const contactos = await data.json();
        commit('llenarC', contactos);
      }
    }

  });

  new Vue({
    // varibles locochonas
    el:'#app',
    data: {
    idC: 0,
    nombreC: "",
    telefonoC: 0,
    descripcionC: "",
    nombreP: "",
    telefonoP: 0,
    descripcionP: ""

  },
  store:store,
  methods:{
    // editar
    editC(){
      axios.put('http://localhost/Pages/Portafolio2/public/api/contactos/update/'+this.idC,{
        nombre: this.nombreC,
        numero: this.telefonoC,
        descripcion: this.descripcionC
      });
      this.idC='';
      this.nombreC = '';
      this.telefonoC = '';
      this.descripcionC = '';
    },
    // Post
    agregarC(){
      axios.post('http://localhost/Pages/Portafolio2/public/api/contactos/nuevo',{
        nombre: this.nombreP,
        numero: this.telefonoP,
        descripcion: this.descripcionP
      });
      this.nombreP = '';
      this.telefonoP = '';
      this.descripcionP = '';
    }
  }
  });
</script>
  </body>
</html>
