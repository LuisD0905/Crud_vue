<script setup>
import Menubar from 'primevue/menubar';
import { RouterView, useRouter } from 'vue-router'
import { ref } from "vue";

const router = useRouter();

const items = ref([
    {
        label: 'Inicio',
        icon: 'pi pi-home',
        command: () => {
            router.push('/');
        }
    },
    {
        label: 'Personas',
        icon: 'pi pi-user',
        command: () => {
            router.push('/persona');
        }
    }
]);
</script>

<template>
    <div style="position: fixed; width: 90%; margin: 10px 5%;">
        <Menubar :model="items" />
    </div>
    <RouterView />
</template>
