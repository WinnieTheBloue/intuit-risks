<script>
export default {
    props: {
        width: {
            type: String,
            default: "w-6",
        },
        height: {
            type: String,
            default: "h-6",
        },
        img: {
            type: String,
        },
    },
    data() {
        return {
            fileUrl: null,
        };
    },
    mounted() {
        if (this.img) {
            this.fileUrl = `/storage/images/${this.img.substring(14)}`;
        }
    },
};
</script>

<template>
    <svg
        v-if="!img"
        :class="`${width} ${height} text-gray-500`"
        fill="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            fill-rule="evenodd"
            d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
            clip-rule="evenodd"
        />
    </svg>
    <img
        v-else
        :src="fileUrl"
        :class="`${width} ${height} rounded-full object-cover`"
        alt="User Image"
    />
</template>
