<followhorse></followhorse>

<template id="follow-form">
    <button class="btn btn-sm btn-info" v-if="is_followed_by_user" @click="toggle">{{ trans('copy.a.unfollow') }}</button>
    <button class="btn btn-sm btn-info" v-else @click="toggle">{{ trans('copy.a.follow') }}</button>
</template>

<script>
    var horse_id = "{{ $horse->id() }}"
</script>
