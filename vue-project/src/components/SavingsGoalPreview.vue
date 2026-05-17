<template>
  <v-card class="bg text-white" @click="goToSavingsGoal" hover>
    <v-card-title>
      <span>Sparziel</span>
      <v-spacer />
      <v-icon>mdi-arrow-right</v-icon>
    </v-card-title>
    <v-card-item class="text-white" width="80%">
       <v-card-title class="text-center"> Noch {{ goal }} sparen!</v-card-title>
  
  <v-progress-linear
    :model-value="restPct" 
    :buffer-value="100"          
    color="#ff6361"
    buffer-color="#239e9e"
    :height="30"
    rounded
    :buffer-opacity="1"
    class="mb-15"
  />
    </v-card-item>
  </v-card>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { ref, onMounted, computed } from 'vue'
import api from '@/api/axios'

const router = useRouter()

function goToSavingsGoal() {
  router.push({ name: 'savings-goal' })
}

const restbetrag = ref(0)
const zielbetrag = ref(0)

const goal = computed(() => 
  Math.round(zielbetrag.value - restbetrag.value).toLocaleString('de-DE', { style: 'currency', currency: 'EUR' })
)

const restPct = computed(() => 
  restbetrag.value > 0 ? Math.round((restbetrag.value / zielbetrag.value) * 100) : 0
)

onMounted(async () => {
  try {
    const { data } = await api.get('/sparziel/preview')
    restbetrag.value = Number((data.restbetrag) || 0)
    zielbetrag.value = Number((data.zielbetrag) || 0)
    console.log('Daten:', { restbetrag: restbetrag.value, zielbetrag: zielbetrag.value, restPct: restPct.value })
  } catch (e) {
    console.error('Fehler beim Laden der Sparziel Preview', e)
  }
})
</script>

<style scoped>
.savings-goal-preview {
  cursor: pointer;
  transition: box-shadow 0.2s;
}

.savings-goal-preview:hover {
  box-shadow: 0 4px 24px rgba(0,0,0,0.25);
}

.bg {
  background-color: #142933;
}
</style>
