<script setup>
//https://fullcalendar.io/docs/vue

import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import FullCalendar from '@fullcalendar/vue3';
import { ref } from 'vue';

const props = defineProps({
    dates: {
        type: Object,
        required: true,
    },
});

//console.log(props.dates);

const calendarOptions = ref({
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    weekends: false,
    selectable: true,
    // Add more options as needed
    events: props.dates,
});

const toggleWeekends = () => {
    calendarOptions.value.weekends = !calendarOptions.value.weekends;
};
</script>

<template>
    <div>
        <button @click="toggleWeekends" class="mb-4 rounded bg-blue-500 px-4 py-2 text-white">Toggle Weekends</button>
        <FullCalendar :options="calendarOptions" />
    </div>
</template>
