<template>
    <div class="container mx-auto px-20">
        <div class="flex flex-row justify-around">
            <div
                v-for="courseIndex in quantityCards"
                :key="courseIndex"
                class="w-72 bg-white rounded-lg shadow-md p-6"
                style="cursor: auto"
            >
                <div class="w-16 mx-auto relative -mt-10 mb-3">
                    <i
                        class="fas fa-trophy -mt-1 text-4xl"
                        :class="trophyColor[courseIndex]"
                    ></i>
                </div>

                <div v-if="!loading">
                    <div class="my-4 flex justify-center flex-col items-center">
                        <span
                            class="w-full sm:w-48 block leading-normal text-indigo-700 text-base font-bold"
                            >{{ topCourses[courseIndex]?.name }}</span
                        >

                        <span
                            class="w-full sm:w-48 block leading-normal text-gray-600 text-md"
                            >Estudiantes:
                            {{
                                topCourses[courseIndex]?.numberOfStudents
                            }}</span
                        >

                        <div class="w-1/2 mt-5">
                            <InertiaLink
                                :href="
                                    route(
                                        'course.students',
                                        topCourses[courseIndex]?.id || 0
                                    )
                                "
                                class="py-2 px-4 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg"
                                type="button"
                            >
                                Ver curso
                            </InertiaLink>
                        </div>
                    </div>
                </div>

                <div v-else>
                    <div class="flex justify-center p-9">
                        <i class="fas fa-spinner fa-spin mr-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            trophyColor: {
                0: "text-yellow-500",
                1: "text-neutral-500",
                2: "text-yellow-800",
            },
            quantityCards: [1, 0, 2],
            topCourses: [],
            loading: true,
        };
    },
    methods: {
        init() {
            fetch(route("course.tops"))
                .then((response) => response.json())
                .then((data) => {
                    this.topCourses = data;
                    this.loading = false;
                });
        },
    },
    created() {
        this.init();
    },
};
</script>
