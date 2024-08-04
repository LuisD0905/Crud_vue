<script setup lang="ts">
import { ref, onMounted } from 'vue';
import PersonaService from '@/services/PersonaService';
import type { Persona } from "@/interfaces/PersonaInterface";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import DatePicker from 'primevue/datepicker';
import Divider from 'primevue/divider';
import Toast from 'primevue/toast';
import ConfirmPopup from 'primevue/confirmpopup';
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";

const toast = useToast();
const confirm = useConfirm();

const personaService = new PersonaService();

const showError = (msg: string) => {
    toast.add({ severity: 'error', summary: 'Error', detail: msg, life: 5000 });
};

const showSuccess = (msg: string) => {
    toast.add({ severity: 'success', summary: 'Information', detail: msg, life: 5000 });
};

onMounted(() => {
    actualizarLista();
});

const actualizarLista = () => {
    personaService.Lista()
        .then(data => {
            if (data.status) {
                persona.value = data.value
            }
            else {
                // Mensaje de error
                showError("Ocurrio un error al cargar la lista");
            }
        })
        .catch(error => {
            // Manejar errores
            showError("Ocurrio un error al cargar la lista, contactar con soporte tecnico");
            console.error(error);
        });
}

// Formulario
const nombres = ref<string>("");
const apellidos = ref<string>("");
const nacionalidad = ref<string>("");
const edad = ref<number>();
const fecha_nacimiento = ref<string>("");
const nombre_padre = ref<string>("");
const cedula_padre = ref<string>("");
const nombre_madre = ref<string>("");
const cedula_madre = ref<string>("");


const persona = ref<Persona>();
const personaDialogo = ref<Persona>();
const visible = ref(false);
const titulo = ref<string>("")

function openDialog(_titulo: string, _persona: Persona) {
    personaDialogo.value = _persona
    titulo.value = _titulo

    // Si se agrega una persona
    if (_persona == null) {

        // Se dejan todos los campos vacios
        nombres.value = "";
        apellidos.value = "";
        nacionalidad.value = "";
        edad.value = undefined;
        fecha_nacimiento.value = "";
        nombre_padre.value = "";
        cedula_padre.value = "";
        nombre_madre.value = "";
        cedula_madre.value = "";

        // Se muestra el dialogo
        visible.value = true;

    }
    else {
        // Se llenan todos los campos
        nombres.value = personaDialogo.value.nombre;
        apellidos.value = personaDialogo.value.apellido;
        nacionalidad.value = personaDialogo.value.nacionalidad;
        edad.value = personaDialogo.value.edad;
        fecha_nacimiento.value = personaDialogo.value.fecha_nacimiento;
        nombre_padre.value = personaDialogo.value.nombre_padre;
        cedula_padre.value = personaDialogo.value.cedula_padre;
        nombre_madre.value = personaDialogo.value.nombre_madre;
        cedula_madre.value = personaDialogo.value.cedula_madre;

        // Se muestra el dialogo
        visible.value = true;
    }
}

const confirmarSubmit = (event: any) => {
    confirm.require({
        target: event.currentTarget,
        message: '¿Deseas ' + titulo.value.toLocaleLowerCase() + ' el dato?',
        icon: 'pi pi-info-circle',
        position: 'center',
        rejectProps: {
            label: 'Cancelar',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Confirmar',
            severity: 'primary'
        },
        accept: () => {
            submitDatos();
        }
    });
};

const confirmarBorrarDato = (event: any, _persona: Persona) => {
    confirm.require({
        target: event.currentTarget,
        message: '¿Quieres borrar al usuario: ' + _persona.nombre + '?',
        icon: 'pi pi-info-circle',
        position: 'center',
        rejectProps: {
            label: 'Cancelar',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Eliminar',
            severity: 'danger'
        },
        accept: () => {
            eliminarDato(_persona._id!);
        }
    });
};

function eliminarDato(id: string) {
    personaService.Eliminar(id).then(data => {
            if (data.status == true) {
                showSuccess("El dato fue eliminado con exito");
                actualizarLista();
            }
            else {
                showError("Ocurrio un error al eliminar el usuario");
            }
        })
            .catch(error => {
                // Manejar errores
                showError("Ocurrio un error al eliminar el usuario, contactar con soporte");
                console.error(error);
            })
}

function submitDatos() {

    const nuevaPersona: Persona = {
        _id: personaDialogo.value === null ? "0" : personaDialogo.value?._id,
        nombre: nombres.value,
        apellido: apellidos.value,
        nacionalidad: nacionalidad.value,
        edad: edad.value,
        fecha_nacimiento: fecha_nacimiento.value,
        nombre_padre: nombre_padre.value,
        cedula_padre: cedula_padre.value,
        nombre_madre: nombre_madre.value,
        cedula_madre: cedula_madre.value
    }

    // Agregar usuario
    if (personaDialogo.value == null) {
        personaService.Guardar(nuevaPersona).then(data => {
            if (data.status == true) {
                showSuccess("El dato fue agregado con exito");
                visible.value = false;
                actualizarLista();
            }
            else {
                showError("Ocurrio un error al agregar el usuario");
            }
        })
            .catch(error => {
                // Manejar errores
                showError("Ocurrio un error al agregar el usuario, contactar con soporte");
                console.error(error);
            })
    }

    // Actualzar usuario
    else {
        personaService.Editar(nuevaPersona).then(data => {
            if (data.status == true) {
                showSuccess("El dato fue actualizado con exito");
                visible.value = false;
                actualizarLista();
            }
            else {
                showError("Ocurrio un error al actualizar el usuario");
            }
        })
            .catch(error => {
                // Manejar errores
                showError("Ocurrio un error al actualizar el usuario, contactar con soporte");
                console.error(error);
            })
    }
}

</script>

<template>
    <Toast />
    <ConfirmPopup></ConfirmPopup>

    <!-- Dialogo de Formulario -->
    <div class="card flex justify-center">
        <Dialog v-model:visible="visible" modal :header="titulo + ' Persona'">
            <table>
                <tr>
                    <td style="padding-right: 5px;">
                        <label for="nombre" class="font-semibold w-24">Nombres</label><br />
                        <InputText v-model="nombres" class="flex-auto" autocomplete="off" />
                    </td>
                    <td>
                        <label for="apellido" class="font-semibold w-24">Apellidos</label><br />
                        <InputText v-model="apellidos" class="flex-auto" autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 10px;">
                        <label for="nacionalidad" class="font-semibold w-24">Nacionalidad</label><br />
                        <InputText v-model="nacionalidad" class="flex-auto" autocomplete="off" />
                    </td>
                    <td style="padding-top: 10px;">
                        <label for="fecha_nacimiento" class="font-semibold w-24">Fecha de Nacimiento</label><br />
                        <DatePicker v-model="fecha_nacimiento" />
                    </td>
                </tr>
            </table>

            <div style="margin: 10px 20%;">
                <label for="edad" class="font-semibold w-24">Edad</label><br />
                <InputNumber v-model="edad" fluid />
            </div>
            <Divider />

            <table>
                <tr>
                    <td style="padding-right: 5px;">
                        <label for="nombre_padre" class="font-semibold w-24">Nombre del Padre</label><br />
                        <InputText v-model="nombre_padre" class="flex-auto" autocomplete="off" />
                    </td>
                    <td>
                        <label for="cedula_padre" class="font-semibold w-24">Cedula del Padre</label><br />
                        <InputText v-model="cedula_padre" class="flex-auto" autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 10px;">
                        <label for="nombre_madre" class="font-semibold w-24">Nombre de la Madre</label><br />
                        <InputText v-model="nombre_madre" class="flex-auto" autocomplete="off" />
                    </td>
                    <td style="padding-top: 10px;">
                        <label for="cedula_madre" class="font-semibold w-24">Cedula de la Madre</label><br />
                        <InputText v-model="cedula_madre" class="flex-auto" autocomplete="off" />
                    </td>
                </tr>
            </table>
            <div style="margin-top: 15px;">
                <Button type="button" label="Cancelar" severity="secondary" @click="visible = false"></Button>
                <Button type="button" style="margin-left: 15px;" :label="titulo" @click="confirmarSubmit"></Button>
            </div>
        </Dialog>
    </div>

    <!-- Contenido de pagina -->
    <div style="padding-top: 80px; width: 80%; margin: 0 10%;">
        <Card>
            <template #title>Lista de Personas</template>
            <template #content>
                <Button label="Agregar Persona" style="margin-top: 10px;" @click="openDialog('Agregar', null!)" />
                <div class="card">
                    <DataTable :value="persona" tableStyle="min-width: 50rem" style="margin-top: 15px;" paginator
                        :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]">
                        <Column field="nombre" header="Nombres"></Column>
                        <Column field="apellido" header="Apellidos"></Column>
                        <Column field="nacionalidad" header="Nacionalidad"></Column>
                        <Column field="edad" header="Edad"></Column>
                        <Column field="fecha_nacimiento" header="Fecha de Nacimiento"></Column>
                        <Column header="Acciones">
                            <template #body="slotProps">
                                <Button type="button" icon="pi pi-pencil" class="p-button-raised"
                                    style="margin-right: 10px;" @click="openDialog('Actualizar', slotProps.data)">
                                </Button>
                                <Button type="button" icon="pi pi-trash" class="p-button-raised p-button-danger"
                                @click="confirmarBorrarDato($event, slotProps.data)">
                                </Button>
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </template>
        </Card>
    </div>
</template>