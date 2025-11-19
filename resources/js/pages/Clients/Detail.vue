<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
// import the correct clients route or define it if missing
import clients from '@/routes/clients';
import { useForm } from '@inertiajs/vue3';
import { Sparkles } from 'lucide-vue-next';
import { computed, ref } from 'vue';

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
const form = useForm({});
const dialogOpen = ref(false);
const loading = ref(false);
var selectedAppointment = {} as Appointment;

const openAddNoteDialog = (appointment: Appointment) => {
    selectedAppointment = appointment;
    dialogOpen.value = true;
};

const generateSummary = () => {
    form.get(`/clients/${props.klijent.id}/aisummary`, {
        preserveScroll: true,
        onSuccess: () => {
            // toast('Event has been created', {
            //     description: 'Sunday, December 03, 2023 at 9:00 AM',
            //     action: {
            //         label: 'Undo',
            //         onClick: () => console.log('Undo'),
            //     },
            // });
        },
        onError: (errors) => {
            alert('Failed to generate summary');
        },
    });
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
        <header class="flex flex-wrap items-center justify-between gap-3 p-8">
            <h1 class="text-text-light text-4xl leading-tight font-black tracking-tight">{{ klijent.first_name }} {{ klijent.last_name }}</h1>
            <div class="flex gap-2">
                <Link :href="`/clients/${klijent.id}/edit`"
                    ><Button class="flex h-10 min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-primary px-4 text-sm leading-normal font-bold tracking-[0.015em]"> <span class="truncate">Edit Client</span></Button></Link
                >
            </div>
        </header>

        <div class="bg-card-light dark:bg-card-dark border-border-light dark:border-border-dark m-8 rounded-xl border p-6 shadow-sm">
            <!-- ProfileHeader -->
            <div class="mb-6 flex items-center gap-6">
                <div class="aspect-square h-24 w-24 rounded-full bg-cover bg-center bg-no-repeat" data-alt="Profile picture of John Doe" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC0lCLknNDLgNbgqulJXJapI3ykP38AEUE3gYGyitq_pb0rLlfhITAORmRfFlEAPw8X4qIBT14kDNWBeQofrlHO0hp1_Ps_s3ckf2VIGQ6GApQRplXXpfjs23sHtLObZA4Ax9wQ2VpwRU_7Aci6qopfwhyGWH5TpnAwVr-CtM966OiEwuwDaFF9eEvnKzACdm2uHyvhl_kvHPi3ScvUQSwxG9gfX3pMIGeJl0eZyJUrZAzT2-CAQoo29I4I2TjPkScchvqg2eg0G7o')"></div>
                <div class="flex flex-col">
                    <p class="text-text-light text-2xl leading-tight font-bold dark:text-white">{{ klijent.first_name }} {{ klijent.last_name }}</p>
                    <p class="text-base leading-normal font-normal text-gray-500 dark:text-gray-400">{{ klijent.email }}</p>
                </div>
            </div>
            <!-- DescriptionList -->
            <div class="grid grid-cols-1 gap-x-6 gap-y-4 md:grid-cols-2">
                <div class="border-border-light dark:border-border-dark flex flex-col gap-1 border-t py-4">
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">First Name</p>
                    <p class="text-text-light text-base font-medium dark:text-white">{{ klijent.first_name }}</p>
                </div>
                <div class="border-border-light dark:border-border-dark flex flex-col gap-1 border-t py-4">
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Last Name</p>
                    <p class="text-text-light text-base font-medium dark:text-white">{{ klijent.last_name }}</p>
                </div>
                <div class="border-border-light dark:border-border-dark flex flex-col gap-1 border-t py-4">
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Email</p>
                    <p class="text-text-light text-base font-medium dark:text-white">{{ klijent.email }}</p>
                </div>
                <div class="border-border-light dark:border-border-dark flex flex-col gap-1 border-t py-4">
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Phone Number</p>
                    <p class="text-text-light text-base font-medium dark:text-white">{{ klijent.phone }}</p>
                </div>
                <div class="border-border-light dark:border-border-dark flex flex-col gap-1 border-t py-4">
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Birthdate</p>
                    <p class="text-text-light text-base font-medium dark:text-white">{{ klijent.date_of_birth }}</p>
                </div>
                <div class="border-border-light dark:border-border-dark flex flex-col gap-1 border-t py-4">
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Association</p>
                    <p class="text-text-light text-base font-medium dark:text-white">{{ klijent.association }}</p>
                </div>
                <div class="border-border-light dark:border-border-dark col-span-1 flex flex-col gap-1 border-t py-4 md:col-span-2">
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Summary Biography</p>
                    <p class="text-text-light summary-detail text-base leading-relaxed font-medium dark:text-white" v-html="formattedSummary"></p>
                    <form @submit.prevent="generateSummary">
                        <Button
                            type="submit"
                            :disabled="form.processing"
                            :class="{
                                '': !form.processing,
                                'cursor-not-allowed bg-gray-400': form.processing,
                            }"
                        >
                            <Sparkles />
                            <div class="flex items-center">
                                <svg v-if="form.processing" class="mr-3 -ml-1 h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ form.processing ? 'Generating Summary...' : 'Generate AI Summary' }}
                            </div></Button
                        >
                    </form>
                </div>
            </div>
        </div>

        <div class="m-8">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-text-light text-2xl font-bold dark:text-white">Past Appointments</h2>
                <button class="text-text-light flex h-10 min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-secondary px-4 text-sm leading-normal font-bold tracking-[0.015em]">
                    <span class="truncate">Add Appointment</span>
                </button>
            </div>
            <!-- Appointments Table -->
            <div class="bg-card-light dark:bg-card-dark border-border-light dark:border-border-dark overflow-hidden rounded-xl border shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark border-b">
                            <tr>
                                <th class="p-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Date</th>
                                <th class="p-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Time</th>
                                <th class="p-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Notes</th>
                                <th class="p-4 text-right text-sm font-semibold text-gray-500 dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="appointment in pastAppointments" :key="appointment.id" class="border-border-light dark:border-border-dark border-b hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="p-4 text-sm text-nowrap">{{ new Date(appointment.date).toLocaleDateString('HR') }}</td>
                                <td class="p-4 text-sm text-nowrap">{{ appointment.time }}</td>
                                <td class="p-4 text-sm text-gray-600 dark:text-gray-300" v-if="appointment.note">{{ appointment.note }}</td>
                                <td class="p-4 text-sm text-gray-600 dark:text-gray-300" v-else>-</td>
                                <td class="p-4 text-center">
                                    <Button @click="openAddNoteDialog(appointment)" variant="outline" size="sm">
                                        <span v-if="appointment.note">Edit</span>
                                        <span v-else>Add note</span>
                                    </Button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="m-8">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-text-light text-2xl font-bold dark:text-white">Upcomming Appointments</h2>
                <button class="text-text-light flex h-10 min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg bg-secondary px-4 text-sm leading-normal font-bold tracking-[0.015em]">
                    <span class="truncate">Add Appointment</span>
                </button>
            </div>
            <!-- Appointments Table -->
            <div class="bg-card-light dark:bg-card-dark border-border-light dark:border-border-dark overflow-hidden rounded-xl border shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark border-b">
                            <tr>
                                <th class="p-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Date</th>
                                <th class="p-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Time</th>
                                <th class="p-4 text-sm font-semibold text-gray-500 dark:text-gray-400">Notes</th>
                                <th class="p-4 text-right text-sm font-semibold text-gray-500 dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="appointment in upcomingAppointments" :key="appointment.id" class="border-border-light dark:border-border-dark border-b hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="p-4 text-sm text-nowrap">{{ new Date(appointment.date).toLocaleDateString('HR') }}</td>
                                <td class="p-4 text-sm text-nowrap">{{ appointment.time }}</td>
                                <td class="p-4 text-sm text-gray-600 dark:text-gray-300" v-if="appointment.note">{{ appointment.note }}</td>
                                <td class="p-4 text-sm text-gray-600 dark:text-gray-300" v-else>-</td>
                                <td class="p-4 text-center">
                                    <Button @click="openAddNoteDialog(appointment)" variant="outline" size="sm">
                                        <span v-if="appointment.note">Edit</span>
                                        <span v-else>Add note</span>
                                    </Button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
