<template>
  <main class="flex flex-col h-screen font-sans text-sm text-dark-text bg-dark-body">
    <Header />
    
    <div class="container flex-1 overflow-y-auto py-12">
      <router-view></router-view>
    </div>
  </main>
</template>

<script setup>
import Header from '@/components/Header.vue'
</script>
