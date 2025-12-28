<template>
  <section class="container py-10 lg:py-20">
    <AppHead title="Login" />

    <!-- <div class="py-14">
      <img
        :src="'/images/venuedapp-logo-web-white.png'"
        alt="venued.app logo"
        class="w-[278px] mx-auto"
      />
    </div> -->

    <!-- <h1 class="text-center mt-2 text-2xl font-semibold">Admin</h1> -->
    <p class="text-center mt-3">Input email and password in order to log in.</p>

    <div class="mt-4 w-[370px] mx-auto">
      <form @submit.prevent="form.post(useRoute('user.login'))">
        <div class="grid gap-y-2">
          <TextInput
            v-model="form.email"
            label="Email"
            input-class="w-full"
            name="email"
            :error="form.errors?.email"
          />

          <TextInput
            v-model="form.password"
            label="Password"
            input-class="w-full"
            type="password"
            name="password"
            :error="form.errors?.password"
          />
        </div>

        <small
          v-if="form.errors.message"
          class="text-gray-700 mt-2 block"
          v-text="form.errors.message"
        />

        <div class="flex items-center mt-3">
          <Button type="submit" class="w-full" :is-loading="isLoading">
            Log In
          </Button>
        </div>
      </form>
    </div>
  </section>
</template>

<script setup>
import AppHead from '@/Components/AppHead.vue'
import { useRoute } from '@/composables/route'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { TextInput } from '@/Components/form'
import { Button } from '@/Components/common'

defineProps({
  layout: {
    type: String,
    default: 'Auth',
  },
})

const isLoading = ref(false)
const form = useForm({
  email: null,
  password: null,
  remember: false,
})
</script>
