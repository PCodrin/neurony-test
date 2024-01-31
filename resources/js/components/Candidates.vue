<script setup>
import { router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import { ref } from 'vue';

const { candidates } = defineProps(['candidates']);
const toast = useToast();
const loading = ref(false);
const desiredStrengths = ref(['Vue.js', 'Laravel', 'PHP', 'TailwindCSS']);
const desiredSkills = ref(['Team player', 'Diplomacy']);

const isDesiredItem = (item, desiredArray) => desiredArray.includes(item) ? 'bg-green-400' : '';
const isCandidateKnowingWordpress = (candidate) => JSON.parse(candidate.strengths).includes('Wordpress');

const handleRequest = (action, candidate) => {
  loading.value = true;

  const tense = action === 'contact' ? 'ed' : 'd';

  return router.post(route(`candidates.${action}`, { candidate: candidate.id }), {}, {
    preserveScroll: true,
    onStart: () => loading.value = true,
    onSuccess: () => { toast.success('Candidate ' + candidate.name + ' ' + action + tense + ' successfully.'); loading.value = false; },
    onError: (error) => { toast.error(error[0] + ' ' + candidate.name); loading.value = false; },
  });
};

const isContacted = (candidate) => candidate.contacted;
const isHired = (candidate) => candidate.hired;
</script>
<template>
  <div class="my-8">
    <h1 class="text-4xl font-bold">Candidates</h1>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
    <div v-for="candidate in candidates" :key="candidate.id" class="rounded overflow-hidden shadow-lg"
      v-show="!isCandidateKnowingWordpress(candidate) && !isHired(candidate)">
      <img class="w-full" src="/avatar.png" alt="">
      <div class="px-6 py-4">
        <div class="font-bold text-xl mb-2">{{ candidate.name }}</div>
        <p class="text-gray-700 text-base">{{ candidate.description }}</p>
      </div>
      <div class="px-6 pt-4 pb-2">
        <span v-for="strength in JSON.parse(candidate.strengths)"
          :class="['inline-block', 'rounded-full', 'px-3', 'py-1', 'text-sm', 'font-semibold', 'text-gray-700', 'mr-2', 'mb-2', isDesiredItem(strength, desiredStrengths)]">{{
            strength }}</span>
      </div>
      <div class="px-6 pb-2">
        <span v-for="skill in JSON.parse(candidate.soft_skills)"
          :class="['inline-block', 'bg-gray-200', 'rounded-full', 'px-3', 'py-1', 'text-sm', 'font-semibold', 'text-gray-700', 'mr-2', 'mb-2', isDesiredItem(skill, desiredSkills)]">{{
            skill }}</span>
      </div>
      <div class="p-6 float-right">
        <button @click="handleRequest('contact', candidate)" :disabled="loading"
          class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border disabled:bg-gray-200 disabled:cursor-not-allowed border-gray-400 rounded shadow">Contact</button>
        <button @click="handleRequest('hire', candidate)"
          :disabled="loading || isHired(candidate) || !isContacted(candidate)"
          class="bg-green-400 hover:bg-green-500 text-white font-semibold py-2 px-4 border disabled:bg-gray-200 disabled:text-black disabled:cursor-not-allowed border-gray-400 rounded shadow">Hire</button>
      </div>
    </div>
  </div>
</template>
