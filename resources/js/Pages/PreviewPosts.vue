<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Button , Dropdown } from 'flowbite-vue';
import Container from '../Components/Container.vue'
import PostTabs from '@/Components/PostTabs.vue';
import axios from 'axios';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    status: String
})

</script>

<script>
export default {
  data() {
    return {
      table: [],
      entries: 5,
      from: 0,
      status: '',
      prev_page: null,
      next_page: null,
      url: null
    }
  },
  methods: {
    fetchData() {

      !this.url ? this.url = '/api/article/'+this.entries+'/status/'+this.status: '';

      if(this.url) {
        axios.get(this.url).then( response => {
        this.table = response.data.posts;

        if (this.table.data) {

          this.from = this.table.from;

        }
      })
      }
      
    },
    trash(id){
      this.$swal.fire(
          'Are you sure?',
          'warning'
        ).then( (result) => {
          axios.delete('/api/article/'+id).then( response => {
            this.fetchData();
          })
        })
      
    },
    goToPage(url){
      this.url = url;
      this.fetchData();
    }
  },
  mounted(){
    this.status = "publish";
    this.fetchData();
  }
}
</script>

<template>
    <Head title="All Post" />
  <Container> 
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                All Posts
    </h2>
    
    <div class="mt-10">
      <div class="grid grid-cols-4 gap-4">
        <div v-for="row in table.data" class="p-6 bg-white rounded-lg border border-gray-200 shadow-md mx-10">
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight">{{ row.title }}</h5>
            </a>
            <h6>Category : {{ row.category }}</h6>
            <p class="mb-3 font-normal text-gray-700">{{ row.content }}</p>
        </div>
      </div>
    </div>
    <nav class="container mt-6">
      <ul class="flex float-right items-center ">
        <li v-for=" row in table.links">
          <a href="#" v-html="row.label" @click.prevent="goToPage(row.url)" class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
          
          </a>
        </li>
      </ul>
    </nav>
  </Container> 
</template>
