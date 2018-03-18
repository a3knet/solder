<template>
    <div>
        <ul class="nav nav-tabs">
            <li v-for="tab in tabs" class="nav-item">
                <a :class="['nav-link', { 'active': tab.isActive }]" @click="toggleTab(tab)">
                    <span v-if="tab.icon" class="icon"><i :class="['fa', tab.icon]"></i></span>{{ tab.name }}
                </a>
            </li>
        </ul>
        <slot></slot>
    </div>
</template>

<script>
    export default{
        data() {
            return {
                tabs: []
            };
        },
        mounted() {
            this.tabs = this.$children;
            console.log(this);
        },
        methods: {
            toggleTab(selectedTab) {
                this.tabs.forEach(tab => {
                    tab.isActive = (tab.name == selectedTab.name);
            });
            }
        }
    }
</script>