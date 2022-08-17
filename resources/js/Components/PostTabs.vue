<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<script>
export default {
    props: ['status'],
    data() {
        return {
            count: {
                published: 0,
                draft: 0,
                trashed: 0,
            },
        }
    },
    methods: {
        fetchData(){
          
            axios.get('/api/count-status').then( response => {
                let countData = response.data;
                if (countData) {
                    countData.forEach( count => {
                        count.Publish ? this.count.published = count.Publish :  '';
                        count.Draft ? this.count.draft = count.Draft :  '';
                        count.Trash ? this.count.trashed = count.Trash :  '';
                    })
                }
            })
        }
    },
    mounted(){
        this.fetchData();
    }
}
</script>

<template>
<div class="container justify-between items-center">
      
      <div class="hidden w-full md:block md:w-auto" id="navbar-default">
        <ul class="flex flex-col p-4 mt-4 bg-white rounded-lg border border-gray-100 md:flex-row md:space-x-8 md:mt-0 md:text-base md:font-medium md:border-0">
          <li>
            <Link href="/all-post/publish" :class="{'bg-gray-100' : this.status && this.status == 'publish' }" class="block py-2 pr-4 pl-3 text-gray-700 rounded hover:bg-gray-100" aria-current="page">Published ({{ this.count.published}})</Link>
          </li>
          <li>
            <Link href="/all-post/draft" :class="{'bg-gray-100' : this.status && this.status == 'draft' }" class="block py-2 pr-4 pl-3 text-gray-700 rounded hover:bg-gray-100">Drafts ({{ this.count.draft}})</Link>
          </li>
          <li>
            <Link href="/all-post/trash" :class="{'bg-gray-100' : this.status && this.status == 'trash' }" class="block py-2 pr-4 pl-3 text-gray-700 rounded hover:bg-gray-100">Trashed ({{ this.count.trashed}})</Link>
          </li>
        </ul>
      </div>
    </div>
</template>