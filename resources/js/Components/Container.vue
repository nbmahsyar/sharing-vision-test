<script setup>
import { Button , Dropdown } from 'flowbite-vue'
import SideBar from './SideBar.vue';
import Header from './Header.vue';
import Content from './Content.vue';

</script>

<template>
<div class="flex h-screen bg-gray-50 dark:bg-gray-900">
  <SideBar />

  <div class="flex flex-col flex-1 w-full">
    <Header />
    <Content>
      <slot />
    </Content>
  </div>
  
</div>
 
</template>