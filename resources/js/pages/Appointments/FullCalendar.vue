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
    aspectRatio: 2,
    weekends: false,

    selectable: true,
    customButtons: {
        toggleWeekends: {
            text: 'Toggle Weekends',
            click: function () {
                calendarOptions.value.weekends = !calendarOptions.value.weekends;
            },
        },
    },
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek toggleWeekends',
    },
    // Add more options as needed
    events: props.dates,
});
</script>

<template>
    <div>
        <FullCalendar :options="calendarOptions" />
    </div>
</template>

<style>
:root {
    --fc-border-color: #333;
    --fc-daygrid-event-dot-width: 5px;
}
</style>
