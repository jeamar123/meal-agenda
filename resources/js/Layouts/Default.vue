<template>
  <main class="app-container flex flex-col body-text h-dvh md:h-screen overflow-y-auto">
    <div class="sticky top-0 left-0 z-10">
      <Header />
    </div>

    <div class="flex-1">
      <slot />
    </div>
  </main>

  <NotificationAlert :show="showNotif" @hide="showNotif = false" />
</template>

<script setup>
import { ref } from 'vue'
import Header from '@/Components/Header.vue'
import { NotificationAlert } from '@/Components/common'

const browserWidth = window.innerWidth
const showNotif = ref(false)
</script>
