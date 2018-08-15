<template>
    <transition name="slide-fade" mode="out-in">
        <div v-if="show" class="alert alert-info" role="alert" key="show">
            <button type="button" class="close pull-right" @click="dismiss()" v-if="hasLocalStorage" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <!--<button class="btn btn-light pull-right" @click="dismiss()" v-if="hasLocalStorage"><i class="fa fa-times-circle"></i></button>-->
            <nav class="row">
                <div class="col-sm-1">
                    <div class="image pull-left">
                        <img width="64px" height="64px" src="/img/book.png" />
                    </div>
                </div>
                <div class="col-sm-11">
                    <slot></slot>
                </div>
            </nav>
        </div>
        <div v-else key="hide">
            <button class="close pull-right" @click="recall()" v-if="hasLocalStorage"><i class="fa fa-question-circle"></i></button>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "assistant",
        props: ['id'],

        data() {
            return {
                show: null,
            };
        },

        mounted() {
            if (this.storageAvailable('localStorage')) {
                this.show = localStorage.getItem(`dismissable.${this.id}`) === "true";
            } else {
                this.show = true;
            }
        },

        computed: {
            hasLocalStorage: function () {
                return this.storageAvailable('localStorage');
            }
        },

        watch: {
            show: function (val) {
                if(this.storageAvailable('localStorage')) {
                    localStorage.setItem(`dismissable.${this.id}`, this.show.toString());
                }
            }
        },

        methods: {
            dismiss () {
                this.show = false;
            },

            recall () {
                this.show = true;
            },

            storageAvailable(type) {
                try {
                    var storage = window[type],
                        x = '__storage_test__';
                    storage.setItem(x, x);
                    storage.removeItem(x);
                    return true;
                }
                catch(e) {
                    return e instanceof DOMException && (
                            // everything except Firefox
                        e.code === 22 ||
                        // Firefox
                        e.code === 1014 ||
                        // test name field too, because code might not be present
                        // everything except Firefox
                        e.name === 'QuotaExceededError' ||
                        // Firefox
                        e.name === 'NS_ERROR_DOM_QUOTA_REACHED') &&
                        // acknowledge QuotaExceededError only if there's something already stored
                        storage.length !== 0;
                }
            }
        }
    }
</script>