<template>
  <header class="sticky top-0 left-0 z-40 w-full border-b border-border bg-surface">
    <nav class="container flex items-center justify-between gap-x-2 h-14">
      <!-- Mobile Menu Button -->
      <div class="lg:hidden">
        <button
          @click="isMobileMenuOpen = true"
          class="h-10 w-10 inline-flex items-center justify-center rounded border border-border hover:bg-primary hover:border-primary transition-colors duration-200"
          aria-label="Open menu"
        >
          <Icon name="Bars3Icon" class="h-5 w-5" aria-hidden="true" />
        </button>
      </div>

      <!-- Desktop Navigation -->
      <div class="hidden lg:block">
        <nav>
          <ul class="flex items-center gap-x-5">
            <li
              v-for="item in navigationItems"
              :key="item.label"
            >
              <Link
                class="flex items-center gap-x-3 py-2 px-4 rounded transition-all duration-200 hover:bg-primary hover:text-white"
                :class="[
                  $page.component === item.component
                    ? 'bg-primary border-l-2 border-primary text-white'
                    : '',
                ]"
                :href="useRoute(item.route)"
              >
                <!-- <Icon v-if="item.icon" :name="item.icon" class="w-5" /> -->
                <span>{{ item.label }}</span>
              </Link>
            </li>
          </ul>
        </nav>
      </div>
    </nav>

    <!-- Mobile Drawer -->
    <MobileDrawer :show="isMobileMenuOpen" @close="isMobileMenuOpen = false">
      <template #header>
        <div class="flex items-center justify-between px-4 py-3">
          <span class="text-lg text-text-primary">Menu</span>
          <button
            @click="isMobileMenuOpen = false"
            class="h-10 w-10 inline-flex items-center justify-center rounded hover:bg-secondary transition-colors duration-200"
            aria-label="Close menu"
          >
            <Icon name="XMarkIcon" class="h-5 w-5" />
          </button>
        </div>
      </template>

      <!-- Nav Items -->
      <nav>
        <ul>
          <li v-for="item in navigationItems" :key="item.label">
            <button
              @click="handleNavClick(item.route)"
              class="w-full text-left min-h-[48px] px-4 py-3 transition-all duration-200 hover:bg-primary hover:text-white"
              :class="[
                $page.component === item.component
                  ? 'bg-primary text-white font-medium'
                  : 'text-text-primary',
              ]"
            >
              <span class="flex items-center gap-x-3">
                {{ item.label }}
                <span
                  v-if="item.badge"
                  class="ml-auto bg-error text-white text-xs font-bold px-2 py-0.5 rounded-full"
                >
                  {{ item.badge }}
                </span>
              </span>
            </button>
            <!-- Divider -->
            <!-- <hr v-if="item.divider" class="my-2 border-border" /> -->
          </li>
        </ul>
      </nav>
    </MobileDrawer>
  </header>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import { Icon } from '@/Components/common'
import MobileDrawer from '@/Components/MobileDrawer.vue'
import { useRoute } from '@/composables/route'
import { useNavigation } from '@/composables/navigation'

// Props
const props = defineProps({
  routes: {
    type: Array,
    default: null,
  },
})

// State
const isMobileMenuOpen = ref(false)

// Computed
const navigationItems = computed(() => {
  if (props.routes) return props.routes

  const nav = useNavigation()
  // Flatten main and secondary into single array
  return [...nav.main, ...nav.secondary]
})

// Methods
function handleNavClick(route) {
  isMobileMenuOpen.value = false
  // Small delay to allow close animation
  setTimeout(() => {
    router.get(useRoute(route))
  }, 150)
}
</script>
