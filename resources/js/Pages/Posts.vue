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
      status,
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
    this.status = this.props.status;
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
    <PostTabs :status="props.status"/>
    
    <div class="mt-10">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-teal-300 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6 text-center">
                        No.
                    </th>
                    <th scope="col" class="py-3 px-6 text-center">
                        Title
                    </th>
                    <th scope="col" class="py-3 px-6 text-center">
                        Category
                    </th>
                    <th scope="col" class="py-3 px-6 text-center">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for=" row,index in table.data ">
                    <td class="py-4 px-6 text-center">
                        {{ index + from}}
                    </td>
                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ row.title }}
                    </th>
                    <td class="py-4 px-6 text-center">
                        {{ row.category }}
                    </td>
                    <td class="py-4 px-6 text-center">
                      <div class="vp-raw inline-flex align-center gap-2 flex-wrap">
                          <Link class="font-medium text-gray-900 focus:outline-none bg-white rounded-lg border-gray-200 focus:z-10 focus:ring-4 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 hover:bg-gray-100 hover:text-blue-700 dark:hover:text-white dark:hover:bg-gray-700 px-3 py-1.5 font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 hover:bg-gray-100 hover:text-blue-700 dark:hover:text-white dark:hover:bg-gray-700 text-sm px-3 py-1.5" 
                                :href="`/post/${row.id}/update`">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8 20l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4h4z"></path>
                                <path d="M13.5 6.5l4 4"></path>
                                <path d="M16 18h4"></path>
                              </svg>
                          </Link>
                          <Button @click.prevent="trash(row.id)" color="red" size="sm">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="4" y1="7" x2="20" y2="7"></line>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                              </svg>
                          </Button>
                      </div>
                    </td>
                </tr>
            </tbody>
        </table>
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
