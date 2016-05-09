<leaderboard></leaderboard>

<template id="leaderboard-template">
    <div class="text-center" v-if="found">
        <a href="@{{ advertisement.website }}" target="_blank" @click="addClick(advertisement)">
            <img v-bind:src="advertisement.picture_path" alt="" width="728" height="90px" style="margin-top: 10px;">
        </a>
    </div>
</template>
