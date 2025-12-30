<template>
  <div class="container px-0">
    <DateScroller />

    <div class="p-4">
      <div
        class="bg-surface border border-border rounded-md p-4 active:scale-[0.98] transition"
      >
        <div class="flex justify-between">
          <div>
            <p class="font-medium">Chicken Salad</p>
            <p class="text-text-muted text-sm">
              Lunch • 12:30 PM
            </p>
          </div>

          <button class="text-text-muted text-lg">⋮</button>
        </div>

        <!-- assignment -->
        <div class="mt-2 flex gap-2">
          <span class="bg-secondary text-xs px-2 py-1 rounded">
            Mom
          </span>
          <span class="bg-primary/20 text-primary text-xs px-2 py-1 rounded">
            Low-Carb
          </span>
        </div>
      </div>

      <button
        class="fixed bottom-5 right-5 bg-primary text-white
              w-14 h-14 rounded shadow-lg text-2xl"
      >
        +
      </button>
    </div>
  </div>
</template>

<script setup>
import { Card } from '@/Components/common'
import DateScroller from '@/Components/DateScroller.vue'
</script>
