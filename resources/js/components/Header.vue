<template>
  <header class="sticky top-0 left-0 z-40 w-full border-b border-slate-50/[0.06] text-white">
    <Disclosure as="nav" v-slot="{ open }">
      <div class="container flex items-center justify-between gap-x-2 h-14">
        <div class="flex items-center gap-x-2">
          <div class="relative lg:hidden">
            <span class="hidden text-base font-semibold">Logo</span>

            <div class="absolute inset-y-0 left-0 flex items-center lg:hidden">
              <!-- Mobile menu button-->
              <DisclosureButton
                class="relative inline-flex items-center justify-center rounded p-2 text-[#27272a] hover:bg-primary hover:text-white outline-none border border-gray-400"
              >
                <Bars3Icon v-if="!open" class="block h-5 w-5" aria-hidden="true" />
                <XMarkIcon v-else class="block h-5 w-5" aria-hidden="true" />
              </DisclosureButton>
            </div>
          </div>

          <div class="hidden lg:block">
            <ul class="flex items-center gap-x-5">
              <li v-for="{ label, routeName } in menuItems" :key="label" class="">
                <router-link
                  :to="{ name: routeName }"
                  class="transition duration-[0.5s] ease-in-out"
                  :class="
                    $route.name === routeName
                      ? 'underline text-white'
                      : 'text-gray-400 hover:text-white'
                  "
                  >{{ label }}</router-link
                >
              </li>
            </ul>
          </div>
        </div>
      </div>

      <DisclosurePanel class="lg:hidden">
        <DisclosureButton
          v-for="{ label, routeName } in menuItems"
          :key="label"
          as="button"
          @click="$router.push({ name: routeName })"
          :class="[
            routeName === $route.name ? 'underline' : 'text-[#71717a] hover:underline',
            'block px-4 lg:px-6 py-3 text-sm w-full text-left'
          ]"
        >
          {{ label }}
        </DisclosureButton>
      </DisclosurePanel>
    </Disclosure>
  </header>
</template>

<script setup lang="ts">
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { useRouter } from 'vue-router'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'

const router = useRouter()
const excludedRoutes = ['Auth', 'Login']
const menuItems = router.getRoutes().reduce((arr, { name }) => {
  if (!excludedRoutes.includes(name))
    arr.push({
      label: name,
      routeName: name
    })
  return arr
}, [])
</script>
