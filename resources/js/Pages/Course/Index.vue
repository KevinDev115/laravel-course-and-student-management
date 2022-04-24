<template>
    <AppLayout title="Cursos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cursos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <TopCard />

                <div class="flex justify-end my-3">
                    <InertiaLink
                        :href="route('course.create')"
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
                                    Nombre
                                </th>
                                <th class="px-6 py-2 text-xs text-gray-500">
                                    Horario
                                </th>
                                <th class="px-6 py-2 text-xs text-gray-500">
                                    Fecha Inicio
                                </th>
                                <th class="px-6 py-2 text-xs text-gray-500">
                                    Fecha Fin
                                </th>
                                <th class="px-6 py-2 text-xs text-gray-500">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-300">
                            <tr
                                v-for="course in courses.data"
                                :key="course.id"
                                class="whitespace-nowrap"
                            >
                                <td
                                    class="px-6 py-4 text-sm text-gray-500 text-center"
                                >
                                    {{ course.id }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ course.name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="text-sm text-gray-500 text-center"
                                    >
                                        {{ course.schedule }}
                                    </div>
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-500 text-center"
                                >
                                    {{ course.start_date }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-500 text-center"
                                >
                                    {{ course.end_date }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-row justify-center">
                                        <InertiaLink
                                            :href="
                                                route(
                                                    'course.students',
                                                    course.id
                                                )
                                            "
                                        >
                                            <i
                                                class="fas fa-user-plus text-lg text-gray-500 hover:text-gray-700"
                                            ></i>
                                        </InertiaLink>
                                        <InertiaLink
                                            :href="
                                                route('course.edit', course.id)
                                            "
                                            class="mx-3"
                                        >
                                            <i
                                                class="fas fa-edit text-lg text-indigo-400 hover:text-indigo-300"
                                            ></i>
                                        </InertiaLink>

                                        <a
                                            href="#"
                                            @click="deleteItem(course.id)"
                                        >
                                            <i
                                                class="fas fa-trash-alt text-lg text-red-400 hover:text-red-300"
                                            ></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="!courses.data.length">
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
                    <Pagination :config="courses" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "../../components/utils/Pagination.vue";
import TopCard from "../../components/cards/TopCard.vue";

export default {
    props: ["courses"],
    components: {
        AppLayout,
        Pagination,
        TopCard,
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
                    this.$inertia.delete(route("course.destroy", id));
                }
            });
        },
    },
};
</script>
