<template>
    <AppLayout title="Estudiantes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <InertiaLink :href="route('course.index')">
                    <i
                        class="fas fa-arrow-left mr-3 cursor-pointer text-gray-500 hover:text-gray-800"
                    ></i>
                </InertiaLink>
                Estudiantes -
                <span class="text-indigo-700">{{ course.name }} </span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-5">
                    <form class="w-full p-4" @submit.prevent="onFinish">
                        <div class="flex mb-6">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-first-name"
                                >
                                    Estudiante
                                </label>

                                <select
                                    class="appearance-none block w-full bg-gray-100 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                    placeholder=""
                                    v-model="form.student_id"
                                >
                                    <option
                                        v-for="student in students"
                                        :key="student.id"
                                        :value="student.id"
                                    >
                                        {{ student.name }}
                                        {{ student.surname || "" }}
                                    </option>
                                    <option v-if="!students.length" disabled>
                                        No hay estudiantes que asignar
                                    </option>
                                </select>

                                <div class="flex justify-end">
                                    <button
                                        class="flex-shrink-0 bg-indigo-700 text-indigo-100 text-base font-semibold py-2 px-4 rounded-lg hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-indigo-200 cursor-pointer"
                                        type="submit"
                                    >
                                        Asignar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                    <table class="w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-2 text-xs text-gray-500">
                                    #
                                </th>
                                <th class="px-6 py-2 text-xs text-gray-500">
                                    Nombres
                                </th>
                                <th class="px-6 py-2 text-xs text-gray-500">
                                    Edad
                                </th>
                                <th class="px-6 py-2 text-xs text-gray-500">
                                    Email
                                </th>
                                <th class="px-6 py-2 text-xs text-gray-500">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-300">
                            <tr
                                v-for="student in courseStudents"
                                :key="student.id"
                                class="text-center whitespace-nowrap"
                            >
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ student.id }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ student.name }} {{ student.surname }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500">
                                        {{ student.age }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ student.email }}
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="flex flex-row justify-center items-center"
                                    >
                                        <a
                                            href="#"
                                            @click="deleteItem(student.id)"
                                        >
                                            <i
                                                class="fas fa-trash-alt text-lg text-red-400 hover:text-red-300"
                                            ></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="!courseStudents.length">
                                <td
                                    class="text-gray-300 text-center whitespace-nowrap p-4"
                                    colspan="10"
                                >
                                    No hay datos
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";

export default {
    props: ["course", "courseStudents", "students"],
    components: {
        AppLayout,
    },
    data() {
        return {
            form: {
                student_id: null,
            },
        };
    },
    methods: {
        onFinish() {
            this.$inertia.put(
                route("course.assignStudent", this.course.id),
                this.form
            );
        },
        deleteItem(id) {
            this.$swal({
                title: "¿Está seguro?",
                text: "No podrás revertir esto.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, desasignar.",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.resetForm();
                    this.$inertia.put(
                        route("course.unassignStudent", this.course.id),
                        {
                            student_id: id,
                        }
                    );
                }
            });
        },
        resetForm() {
            this.form = {
                student_id: null,
            };
        },
    },
};
</script>
