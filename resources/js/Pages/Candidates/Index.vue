<script setup>
import Candidates from '../../components/Candidates.vue';
import MvpCandidates from '../../components/MvpCandidates.vue';

const props = defineProps({
  candidates: Object,
  coins: Number
});
</script>
<template>
  <div>
    <div class="w-full p-6 bg-teal-100 text-right font-bold fixed top-0">Your wallet has: {{ props.coins ?? '?' }} coins</div>

    <div class="container mx-auto">
      <Candidates :candidates="props.candidates"></Candidates>
      <div class="border-t my-16"></div>
      <MvpCandidates></MvpCandidates>
    </div>
  </div>
</template>