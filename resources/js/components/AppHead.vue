<template>
  <Head :title="title">
    <slot />
  </Head>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  title: {
    type: String,
    required: false,
    default: () => '',
  },
})

const title = computed(() =>
  props.title ? `${props.title} - Admin Venued.app` : 'Venued.app',
)
</script>
