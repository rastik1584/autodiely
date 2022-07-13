<template>
    <div class="left-menu">
        <h1> Autodiely </h1>
        <ul>
            <li><router-link to="/cars">Autá</router-link></li>
            <li><router-link to="/car-parts">Autodiely</router-link></li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "LeftMenu"
}
</script>

<style lang="scss" scoped>
    .router-link-active {
        color: orange;
    }
</style>
