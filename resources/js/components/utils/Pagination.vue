<template>
    <nav>
        <ul class="inline-flex -space-x-px sm:rounded-lg">
            <li v-for="(link, index) in config.links" :key="index">
                <InertiaLink
                    :href="link.url"
                    class="py-2 px-3 leading-tight border border-white-300"
                    :class="
                        link.active
                            ? 'bg-indigo-700 hover:bg-white text-white hover:text-black'
                            : 'bg-white hover:bg-indigo-700 text-black hover:text-white'
                    "
                >
                    <span v-html="link.label"></span>
                </InertiaLink>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: ["config"],
};
</script>
