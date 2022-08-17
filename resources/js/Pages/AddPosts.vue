<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Button , Dropdown } from 'flowbite-vue';
import Container from '../Components/Container.vue'

const editPost = defineProps({
    post: Object
});

</script>

<script>
export default {
    data() {
        return {
            form: {
                title: '',
                content: '',
                category: '',
                id: null
            },
            errors: []
        }
    },
    methods: {
        publish(){
            this.form.status = 'Publish';
            this.submit();
        },
        draft(){
            this.form.status = 'Draft';
            this.submit();
        },
        submit(){
            
            this.$swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
                }).then((result) => { 

                    if ( result.isConfirmed) {

                        axios.post('/api/article', this.form).then(response => {
                
                            this.form.title = '';
                            this.form.category = '';
                            this.form.content = '';

                            this.errors = [];
                    
                            this.$swal.fire(
                                'Success!',
                                'Data Update Successfully',
                                'success'
                                ).then( (result) => {
                                    this.$inertia.get(`/all-post/${this.form.status.toLowerCase()}`);
                                });

                    }).catch( reject => {
                        this.errors = reject.response.data.errors;
                        this.$swal.fire(
                            'Failed!',
                            'Data Update Failed',
                            'error'
                            )

                    })

                    }
                    
                });
                
        }
    },
    mounted(){
        if (this.editPost.post) {
            this.form.title = this.editPost.post.title;
            this.form.content = this.editPost.post.content;
            this.form.category = this.editPost.post.category;
            this.form.id = this.editPost.post.id;
        }
    }
}
</script>
<template>
    <Head title="Add Post" />
  <Container> 
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Add Posts
    </h2>
    <div class="container justify-between items-center">
      
      <div class="hidden w-full md:block md:w-auto p-4 bg-white">
        <form>
        <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium" :class="[{'text-gray-900': !errors.title}, {'text-red-600': errors.title}]">Title</label>
            <input v-model="form.title" type="text" id="title" :class="[{'border-gray-300 text-gray-900': !errors.title}, {'border-red-300 text-red-600': errors.title}]" class="bg-gray-50 border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Input title" required="">
            <p class="mt-2 text-sm text-red-600 dark:text-red-500" v-for=" error in errors.title "> {{ error }}</p>
        </div>
        <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium" :class="[{'text-gray-900': !errors.category}, {'text-red-600': errors.category}]">Category</label>
            <input v-model="form.category" type="text" id="category" :class="[{'border-gray-300 text-gray-900': !errors.category}, {'border-red-300 text-red-600': errors.category}]" class="bg-gray-50 border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Input Category" required="">
            <p class="mt-2 text-sm text-red-600 dark:text-red-500" v-for=" error in errors.category "> {{ error }}</p>
        </div>
        <div class="mb-6">
            <label for="message" class="block mb-2 text-sm font-medium" :class="[{'text-gray-900': !errors.content}, {'text-red-600': errors.content}]">Content</label>
            <textarea v-model="form.content" id="message" rows="4" :class="[{'border-gray-300 text-gray-900': !errors.content}, {'border-red-300 text-red-600': errors.content}]" class="block p-2.5 w-full text-sm bg-gray-50 rounded-lg border focus:ring-blue-500 focus:border-blue-500" placeholder="Input your content...">
            </textarea>
            <p class="mt-2 text-sm text-red-600 dark:text-red-500" v-for=" error in errors.content "> {{ error }}</p>
        </div>
            <div class="vp-raw inline-flex align-center gap-2 flex-wrap">
                <Button color="yellow" size="sm" @click.prevent=" draft(form) ">
                    Save as Draft
                </Button>
                <Button color="default" size="sm"  @click.prevent=" publish(form) ">
                    Publish
                </Button>
            </div>
        </form>
      </div>
    </div>
    
  </Container> 
</template>
