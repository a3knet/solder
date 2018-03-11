<template>
    <div>
        <div class="tabs is-boxed is-medium">
            <ul>
                <li v-for="tab in tabs" :class="{ 'is-active': tab.isActive }">
                    <a @click="toggleTab(tab)">
                        <span v-if="tab.icon" class="icon is-small"><i :class="['fa', tab.icon]"></i></span>
                        <span><h1>{{ tab.name }}</h1></span>
                    </a>
                </li>
            </ul>
        </div>
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