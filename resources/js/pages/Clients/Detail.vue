<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
// import the correct clients route or define it if missing
import clients from '@/routes/clients';
import { Sparkles } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import AddNoteDialog from '../Appointments/AddNoteDialog.vue';

interface Client {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    phone: string;
    date_of_birth: Date; // or Date, depending on how you
    gender: string;
    summary: string;
    supervisor: string;
    association: string;
    // Add other client properties as needed
}
interface Appointment {
    id: number;
    date: Date;
    time: string;
    client_id: number;
    note: string;
    // Add other appointment properties as needed
}
const props = defineProps<{
    klijent: Client;
    appointments: Appointment[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Clients',
        href: clients.index().url,
    },
    {
        title: 'Details',
        href: clients.index().url,
    },
];

const pastAppointments = props.appointments.filter((app) => new Date(`${app.date}T${app.time}`) < new Date());
const upcomingAppointments = props.appointments.filter((app) => new Date(`${app.date}T${app.time}`) >= new Date());

const dialogOpen = ref(false);
var selectedAppointment = {} as Appointment;

const openAddNoteDialog = (appointment: Appointment) => {
    selectedAppointment = appointment;
    dialogOpen.value = true;
};

const closeDialog = () => {
    dialogOpen.value = false;
};

const formattedSummary = computed(() => {
    if (!props.klijent.summary) {
        return 'No summary available.';
    }
    return props.klijent.summary.replace('\n\g', '<br />');
});
</script>

<template>
    <Head title="Client Detail Page" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <header class="mb-4 flex items-center justify-end p-4">
            <Link :href="`/clients/${klijent.id}/edit`"><Button>Edit Client</Button></Link>
        </header>

        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <h2>Detalji klijenta</h2>

            {{ klijent.first_name }} {{ klijent.last_name }} <br />
            {{ klijent.email }} <br />
            {{ klijent.phone }} <br />
            {{ klijent.date_of_birth }} <br />
            {{ klijent.gender }} <br />
            {{ klijent.supervisor }} <br />
            {{ klijent.association }} <br />
        </div>

        <div class="p-4">
            <h4>summary</h4>
            <Link :href="`/clients/${klijent.id}/aisummary`"
                ><Button> <Sparkles />AI summary</Button></Link
            >
            <div v-html="formattedSummary" class="summary-detail"></div>
        </div>

        <div class="p-8">
            <Table>
                <TableCaption>List of past appointments</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[140px]">Date</TableHead>
                        <TableHead class="w-[140px]">Time</TableHead>
                        <TableHead>Client</TableHead>
                        <TableHead class="w-[140px]">Action</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="appointment in pastAppointments" :key="appointment.id">
                        <TableCell>{{ new Date(appointment.date).toLocaleDateString('HR') }}</TableCell>
                        <TableCell>{{ appointment.time }}</TableCell>
                        <TableCell v-if="appointment.note"> {{ appointment.note }} </TableCell>
                        <TableCell v-else> No note </TableCell>
                        <TableCell>
                            <Button @click="openAddNoteDialog(appointment)" variant="outline" size="sm">
                                <span v-if="appointment.note">Edit</span>
                                <span v-else> Add note</span>
                            </Button>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <div class="p-8">
            <Table>
                <TableCaption>List of upcoming appointments</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[140px]">Date</TableHead>
                        <TableHead class="w-[140px]">Time</TableHead>
                        <TableHead>Client</TableHead>
                        <TableHead class="w-[140px]">Action</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="appointment in upcomingAppointments" :key="appointment.id">
                        <TableCell>{{ new Date(appointment.date).toLocaleDateString('HR') }}</TableCell>
                        <TableCell>{{ appointment.time }}</TableCell>
                        <TableCell>
                            {{ klijent.first_name + ' ' + klijent.last_name }}
                        </TableCell>
                        <TableCell>...</TableCell>
                    </TableRow>
                </TableBody>
            </Table>
            <AddNoteDialog :open="dialogOpen" :singleAppointment="selectedAppointment" @close="closeDialog" />
        </div>
    </AppLayout>
</template>
<style scoped>
.summary-detail * {
    margin-top: 1rem;
}
.summary-detail li {
    display: block;
}
</style>
