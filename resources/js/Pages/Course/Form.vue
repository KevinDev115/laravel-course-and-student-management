<template>
    <AppLayout title="Cursos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-indigo-700">{{
                    action === "create" ? "Crear" : "Actualizar"
                }}</span>
                - curso
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form class="w-full p-6" @submit.prevent="onFinish">
                        <div class="flex mb-6">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-first-name"
                                >
                                    Nombre
                                </label>
                                <input
                                    class="appearance-none block w-full bg-gray-100 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                    type="text"
                                    placeholder="Ingrese nombre(s)"
                                    v-model="form.name"
                                />
                            </div>
                        </div>

                        <div class="flex mb-6">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-first-name"
                                >
                                    Horario
                                </label>
                                <select
                                    class="appearance-none block w-full bg-gray-100 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                    placeholder="Ingrese un horario"
                                    v-model="form.schedule"
                                    multiple
                                    style="height: 145px"
                                >
                                    <option
                                        v-for="(day, index) in daysWeek"
                                        :key="index"
                                    >
                                        {{ day }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="flex mb-6">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-first-name"
                                >
                                    Fecha Inicio
                                </label>
                                <input
                                    class="appearance-none block w-full bg-gray-100 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                    type="date"
                                    placeholder="Ingrese fecha de inicio del curso"
                                    v-model="form.start_date"
                                />
                            </div>

                            <div class="w-full px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-first-name"
                                >
                                    Fecha Fin
                                </label>
                                <input
                                    class="appearance-none block w-full bg-gray-100 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                    type="date"
                                    placeholder="Ingrese fecha de fin del curso"
                                    v-model="form.end_date"
                                />
                            </div>
                        </div>

                        <div class="flex justify-end mb-6">
                            <div
                                class="w-full px-3 mb-6 md:mb-0 flex justify-end"
                            >
                                <InertiaLink
                                    :href="route('course.index')"
                                    class="mr-3 bg-gray-500 hover:bg-gray-700 rounded-lg font-medium text-white px-4 py-2 cursor-pointer"
                                    type="button"
                                >
                                    Cancelar
                                </InertiaLink>
                                <button
                                    class="flex-shrink-0 bg-indigo-700 text-indigo-100 text-base font-semibold py-2 px-4 rounded-lg hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-indigo-200 cursor-pointer"
                                    type="submit"
                                >
                                    {{
                                        action === "create"
                                            ? "Crear"
                                            : "Actualizar"
                                    }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";

export default {
    props: ["action", "course"],
    components: {
        AppLayout,
    },
    data() {
        return {
            form: {
                id: null,
                name: null,
                schedule: null,
                start_date: null,
                end_date: null,
            },
            daysWeek: ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes"],
        };
    },
    methods: {
        onFinish() {
            if (this.action === "create") {
                this.$inertia.post(route("course.store"), {
                    ...this.form,
                    schedule: this.form.schedule.join(", "),
                });
            } else {
                this.$inertia.put(route("course.update", this.form.id), {
                    ...this.form,
                    schedule: this.form.schedule.join(", "),
                });
            }
        },
    },
    created() {
        if (this.action === "update") {
            this.form = {
                ...this.$props.course,
                schedule: this.$props.course.schedule
                    .replace(/\s/g, "")
                    .split(","),
            };
        }
    },
};
</script>
