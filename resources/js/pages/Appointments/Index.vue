<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Form, Head } from '@inertiajs/vue3';
import type { DateValue } from '@internationalized/date';
import { getLocalTimeZone, today } from '@internationalized/date';
import type { Ref } from 'vue';
import { ref } from 'vue';

// import the correct clients route or define it if missing
import appointments from '@/routes/appointments';

interface Client {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    // Add other client properties as needed
}
interface Appointment {
    id: number;
    date: Date;
    time: string;
    client_id: number;
    // Add other appointment properties as needed
}

const props = defineProps<{
    appointment: Appointment[];
    klijenti: Client[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Appointments',
        href: appointments.index().url,
    },
];

const yearOptions = Array.from({ length: new Date().getFullYear() - 2010 }, (_, index) => 2025 + index);
const currentDate = ref(today(getLocalTimeZone())) as Ref<DateValue>;
const hours = ref(Array.from({ length: 24 }, (_, h) => h.toString().padStart(2, '0')));
const minutes = ref(Array.from([0, 15, 30, 45], (i) => i.toString().padStart(2, '0')));
</script>

<template>
    <Head title="Appointments" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <header class="p-8">
            <Dialog>
                <DialogTrigger as-child>
                    <Button> Add appointment </Button>
                </DialogTrigger>
                <DialogContent class="sm:max-w-[425px]">
                    <DialogHeader>
                        <DialogTitle>Add appointment</DialogTitle>
                        <DialogDescription> Enter the appointment details for scheduling </DialogDescription>
                    </DialogHeader>
                    <Form action="/appointments/store" method="post" :options="{ preserveScroll: true }" #default="{ errors, processing, wasSuccessful }">
                        <div class="flex flex-row">
                            <div>
                                <Label for="date">Date</Label>
                                <input type="date" id="day" name="day" v-model="currentDate" />
                            </div>

                            <div>
                                <Label for="time">Time</Label>
                                <select name="hour" id="hour">
                                    <option v-for="h in hours" :value="h">{{ h }}</option>
                                </select>
                                <select name="min" id="min">
                                    <option v-for="m in minutes" :value="m">{{ m }}</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <Label for="client">Client</Label>
                            <select id="client_id" name="client_id">
                                <option v-for="klijent in klijenti" :key="klijent.id" :value="klijent.id">{{ klijent.first_name }} {{ klijent.last_name }}</option>
                            </select>
                        </div>
                        <DialogFooter>
                            <button type="submit" :disabled="processing">
                                {{ processing ? 'Creating...' : 'Create User' }}
                            </button></DialogFooter
                        >
                    </Form>
                </DialogContent>
            </Dialog>
        </header>
        <div class="flex flex-row flex-wrap gap-4 overflow-x-auto rounded-xl p-4">lista</div>
    </AppLayout>
</template>
