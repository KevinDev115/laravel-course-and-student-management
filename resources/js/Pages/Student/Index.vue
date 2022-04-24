<template>
    <AppLayout title="Estudiantes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Estudiantes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end my-3">
                    <InertiaLink
                        :href="route('student.create')"
                        class="flex-shrink-0 bg-indigo-700 text-indigo-100 text-base font-semibold py-2 px-4 rounded-lg hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-indigo-200 cursor-pointer"
                        type="button"
                    >
                        Nuevo
                    </InertiaLink>
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
                                    Cursos
                                </th>
                                <th class="px-6 py-2 text-xs text-gray-500">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-300">
                            <tr
                                v-for="student in students.data"
                                :key="student.id"
                                class="whitespace-nowrap"
                            >
                                <td
                                    class="px-6 py-4 text-sm text-gray-500 text-center"
                                >
                                    {{ student.id }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ student.name }} {{ student.surname }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-500">
                                        {{ student.age }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ student.email }}
                                </td>
                                <td
                                    class="px-6 py-4 text-left text-sm text-gray-500"
                                >
                                    <ul class="divide-y-2 divide-gray-200">
                                        <li
                                            v-for="course in student.courses.slice(
                                                0,
                                                3
                                            )"
                                            :key="course.id"
                                            class="p-1"
                                        >
                                            {{ course.name }}
                                        </li>
                                        <li
                                            v-if="student.courses.length > 3"
                                            class="text-blue-500 hover:text-blue-300"
                                        >
                                            <InertiaLink
                                                :href="
                                                    route(
                                                        'student.courses',
                                                        student.id
                                                    )
                                                "
                                            >
                                                Ver mas +
                                            </InertiaLink>
                                        </li>
                                    </ul>
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="flex flex-row justify-center items-center"
                                    >
                                        <InertiaLink
                                            :href="
                                                route(
                                                    'student.courses',
                                                    student.id
                                                )
                                            "
                                        >
                                            <i
                                                class="fas fa-book text-lg text-gray-500 hover:text-gray-700"
                                            ></i>
                                        </InertiaLink>
                                        <InertiaLink
                                            :href="
                                                route(
                                                    'student.edit',
                                                    student.id
                                                )
                                            "
                                            class="mx-3"
                                        >
                                            <i
                                                class="fas fa-edit text-lg text-indigo-400 hover:text-indigo-300"
                                            ></i>
                                        </InertiaLink>

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

                            <tr v-if="!students.data.length">
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

                <div class="mt-5 flex justify-end">
                    <Pagination :config="students" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "../../components/utils/Pagination.vue";

export default {
    props: ["students"],
    components: {
        AppLayout,
        Pagination,
    },
    methods: {
        deleteItem(id) {
            this.$swal({
                title: "¿Está seguro?",
                text: "No podrás revertir esto.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, bórralo.",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(route("student.destroy", id));
                }
            });
        },
    },
};
</script>
