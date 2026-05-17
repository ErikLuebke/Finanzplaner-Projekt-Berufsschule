<template>
    <v-container flat class="text-white">
      <v-card-title class="text-center">
        {{ formatCurrency(sumPos) }}
      </v-card-title>
  
      <v-progress-linear
        :model-value="negPct" 
        :buffer-value="100"          
        color="#ff6361"
        buffer-color="#239e9e"
        :height="30"
        rounded
        :buffer-opacity="1"
      />
      <div class="text-caption mt-1">
      </div>
    </v-container>
  </template>
  
  <script setup>
  import { ref, onMounted, computed } from 'vue'
  import api from '@/api/axios'
  
  const sumPos = ref(0)
  const sumNeg = ref(0)
  
  const totalAbs = computed(() => Math.abs(sumPos.value) + Math.abs(sumNeg.value))
  const negPct = computed(() =>
    totalAbs.value > 0 ? Math.round((Math.abs(sumNeg.value) / totalAbs.value) * 100) : 0
  )
  
  const formatCurrency = n =>
    Number(n || 0).toLocaleString('de-DE', { style: 'currency', currency: 'EUR' })
  
  onMounted(async () => {
    try {
      const { data } = await api.get('/progress')
  
      sumPos.value = Number((data.sumPos ?? data.sum_pos) || 0)
      sumNeg.value = Number((data.sumNeg ?? data.sum_neg) || 0)
  
    } catch (e) {
      console.error('Fehler beim Laden des Progress', e)
    }
  })
  </script>
  