<rectangle></rectangle>

<template id="rectangle-template">
    <a v-bind:href="advertisement.website" target="_blank" v-if="found" @click="addClick(advertisement)">
        <div class="panel">
            <div class="panel-bg-cover" style="height: 150px; background-image: url(@{{ advertisement.picture_path }})"></div>
        </div>
    </a>
</template>
