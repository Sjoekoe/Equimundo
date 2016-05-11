<rectangle></rectangle>

<template id="rectangle-template">
    <a v-bind:href="advertisement.website" target="_blank" v-if="found" @click="addClick(advertisement)">
        <img v-bind:src="advertisement.picture_path" alt="" width="180px" height="150px" style="margin-bottom: 1em;">
    </a>
</template>
