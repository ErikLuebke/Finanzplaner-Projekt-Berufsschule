<template>
  <Pie v-if="chartData" :data="chartData" :options="chartOptions" style="width: 600px; height: 600px;"
/>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Pie } from 'vue-chartjs'
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import api from '@/api/axios'

ChartJS.register(ArcElement, Tooltip, Legend)

const chartData = ref(null)
const chartOptions = { responsive: true, plugins: { legend: { display: false } } }

async function fetchChartData() {
  const { data } = await api.get('/PieChart')

  chartData.value = {
    labels: data.map(item => item.name),
    datasets: [{
      data: data.map(item => item.value),
      backgroundColor: ['#239e9e', '##bf4b49', '#114d4d', '#803330', '#186b6b', '#ff6361'],
    }],
  }
}

onMounted(fetchChartData)
</script>