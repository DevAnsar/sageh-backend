<template>
    <div>
        <div class="badge badge-pill badge-success cursor" @click="showList=true">
            <i class="fa fa-briefcase fa-2x "></i>
            <span class="px-1" style="font-size: 15px;line-height: 17px;">
                {{oneManyLength}}
            </span>

        </div>


        <div class="message_div" style="display: block" v-if="showList">
            <div class="message_box" style="width: 600px">
                <p id="msg">
                    {{this.title}}

                    <span style="float: left" @click="showList=false">
                        <i class="fa fa-reply text-pink"></i>
                    </span>
                </p>
                <div class="row">
                    <div class="col-12 many_box">
                        <div v-for="item in many"
                             :class="checkHasMany(item.id) ? 'many_item active' : 'many_item'"
                             @click="many_click(item)"
                             :key="item.id">
                            <span class="many_icon">
                                <img style="width: 100%;padding:4px" v-if="item.icon != null"
                                     :src="'/storage/'+item.icon.url"/>
                            </span>
                            <span class="many_title">
                                {{item.title}}
                            </span>
                        </div>
                    </div>
                </div>

                <div id="many_footer " class="mt-4">
                    <div class="btn btn-sm btn-info mt-2" @click="handleMany()">
                        {{this.submit_title}}
                    </div>
                    <div class=" mt-2">
                        <div class="alert alert-info" v-if="loading">
                            <div class="spinner-border spinner-border-sm text-info" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            در حال ثبت
                        </div>
                        <div class="alert alert-success" v-if="!loading && stored">
                            <div class="text-info">
                                <i class="fa fa-check"></i>
                                ثبت انجام شد
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "OneToMany",
        props: ['one', 'one_many', 'many', 'title', 'submit_url', 'submit_title'],

        data() {

            return {
                loading: false,
                showList: false,
                oneMany: [],
                stored: false,
                oneManyLength: 0

            }
        },
        mounted() {
            this.oneMany = this.one_many;
            this.oneManyLength = this.one_many.length;
        },
        destroyed() {
            this.oneMany = this.one_many;
        },
        methods: {
            checkHasMany(many_id, index_return = false) {
                let index = 0;
                let selected_many=[];
                this.oneMany.map((one_many, i) => {
                    if (one_many.id === many_id) {
                        index = i;
                        selected_many.push(one_many);
                    }
                });
                console.log('selected_many',selected_many.length);
                if (index_return) {
                    return {
                        'checked': selected_many.length > 0 ? true : false,
                        'index': index
                    }
                } else {
                    return selected_many.length > 0 ? true : false;
                }

            },
            many_click(many) {
                this.many.map((many_item) => {
                    if (many_item.id === many.id) {
                        let result = this.checkHasMany(many.id, true);
                        if (result.checked) {
                            this.oneMany.splice(result.index, 1);
                        } else {
                            this.oneMany.push(many);
                        }
                    }
                });
            },
            handleMany() {
                if (!this.loading) {
                    this.loading = true;
                    let many = this.oneMany.map(selected_many => selected_many.id);
                    let formData = new FormData();
                    formData.append('data', many);
                    window.axios.post(this.submit_url, formData).then(res => {
                        console.log(res);
                        this.loading = false;
                        if (res.status) {
                            this.oneManyLength = this.oneMany.length;
                            this.stored = true;
                        }


                    }).catch(err => console.log(err));
                }
            }
        },
        computed: {},
        watch: {
            showList() {
                this.stored = false;
            }
        }
    }
</script>

<style scoped>
    .cursor {
        cursor: pointer;
    }

    .message_box {
        max-height: 550px !important;
    }

    .many_box {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: flex-start;
        align-items: baseline;
        align-content: stretch;
        height: 100%;
        overflow-y: auto;
    }

    .many_item {
        width: 31%;
        margin: 5px;
        height: 50px;
        border-radius: 25px;
        border: 1px solid #eee;

        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: flex-start;
        align-items: center;
        align-content: stretch;
        cursor: pointer;
    }

    .many_item:hover {
        border: 1px solid #eee;
        box-shadow: 0 0 5px 2px #eee !important;
    }

    .many_icon {
        width: 50px;
        height: 50px;
        display: block;
        border-radius: 25px;
        /*border: 1px solid #eee;*/
    }

    .many_title {
        font-size: 10px;
    }

    .many_item.active {
        border: 1px solid #159616 !important;
        box-shadow: 0 0 5px 2px #eee !important;
    }

</style>