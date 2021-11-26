<template>
    <div id="scafold">
        <div class="theme">
            <img class="background" src="/images/2020-10-04_0-57-00.png"/>
        </div>
        <div class="theme">
            <h1 class="page_title">
                <span style="font-weight: 800;color:#079400">S</span>ageh.ir

                <span style="margin: 8px 25px;font-size: 1rem;float: right;">
                    <a href="https://github.com/biilche">
                    github
                        <img style="width: 25px;color: #1a202c" src="data:image/svg+xml;base64,PHN2ZyBpZD0iQm9sZCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMjQgMjQiIGhlaWdodD0iNTEyIiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSI1MTIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0ibTEyIC41Yy02LjYzIDAtMTIgNS4yOC0xMiAxMS43OTIgMCA1LjIxMSAzLjQzOCA5LjYzIDguMjA1IDExLjE4OC42LjExMS44Mi0uMjU0LjgyLS41NjcgMC0uMjgtLjAxLTEuMDIyLS4wMTUtMi4wMDUtMy4zMzguNzExLTQuMDQyLTEuNTgyLTQuMDQyLTEuNTgyLS41NDYtMS4zNjEtMS4zMzUtMS43MjUtMS4zMzUtMS43MjUtMS4wODctLjczMS4wODQtLjcxNi4wODQtLjcxNiAxLjIwNS4wODIgMS44MzggMS4yMTUgMS44MzggMS4yMTUgMS4wNyAxLjgwMyAyLjgwOSAxLjI4MiAzLjQ5NS45ODEuMTA4LS43NjMuNDE3LTEuMjgyLjc2LTEuNTc3LTIuNjY1LS4yOTUtNS40NjYtMS4zMDktNS40NjYtNS44MjcgMC0xLjI4Ny40NjUtMi4zMzkgMS4yMzUtMy4xNjQtLjEzNS0uMjk4LS41NC0xLjQ5Ny4xMDUtMy4xMjEgMCAwIDEuMDA1LS4zMTYgMy4zIDEuMjA5Ljk2LS4yNjIgMS45OC0uMzkyIDMtLjM5OCAxLjAyLjAwNiAyLjA0LjEzNiAzIC4zOTggMi4yOC0xLjUyNSAzLjI4NS0xLjIwOSAzLjI4NS0xLjIwOS42NDUgMS42MjQuMjQgMi44MjMuMTIgMy4xMjEuNzY1LjgyNSAxLjIzIDEuODc3IDEuMjMgMy4xNjQgMCA0LjUzLTIuODA1IDUuNTI3LTUuNDc1IDUuODE3LjQyLjM1NC44MSAxLjA3Ny44MSAyLjE4MiAwIDEuNTc4LS4wMTUgMi44NDYtLjAxNSAzLjIyOSAwIC4zMDkuMjEuNjc4LjgyNS41NiA0LjgwMS0xLjU0OCA4LjIzNi01Ljk3IDguMjM2LTExLjE3MyAwLTYuNTEyLTUuMzczLTExLjc5Mi0xMi0xMS43OTJ6Ii8+PC9zdmc+" />
                    </a>
                </span>
            </h1>
            <hr style="margin-top: 0"/>

            <ul>
                <li>
                    What is <span class="name_starter">S</span>ageh?
                    <ul>
                        <li>
                            <span class="name_starter">S</span>ageh is an agricultural integration system. We call it:
                            the farmer secretary.
                        </li>
                    </ul>
                </li>
                <li>
                    <span class="name_starter">G</span>uide
                    <ul>
                        <li>
                            <a href="/admin/dashboard">Admin Panel</a>
                        </li>
<!--                        <li>-->
<!--                            <a href="/api/documentation">Api Documentation</a>-->
<!--                        </li>-->
                    </ul>
                </li>

                <li>
                    <span class="name_starter">D</span>evelopers
                    <ul>
                        <li>
                            <a href="https://github.com/ansaramman">
                                <span class="name_starter">A</span>nsar mirzayi
                            </a>
                        </li>
                        <li>
                            <a href="https://github.com/hosseinsohan">
                                <span class="name_starter">H</span>ossein sohan
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="name_starter">M</span>ilad yousefzadeh
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</template>

<script>
    export default {
        name: "HomePage",
        data() {

            return {
                style: {
                    height: 0,
                    backgroundColor: 'black',
                    width: '100%'
                }
            }
        },

        mounted() {
            // let scafold = window.$('#scafold');
            // let width = window.innerWidth;
            // let height = window.innerHeight;
            // console.log('w', width);
            // console.log('h', height);

            this.style.height = window.innerHeight;

        },
        methods: {}
    }
</script>

<style scoped>
    #scafold {

        width: 100%;
        height: 100%;
        background-color: #fff;
        /*background-color: white;*/
        position: relative;
    }

    .theme {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }

    .background {
        height: 100%;
        position: absolute;
        right: 0;
        top: 0;
    }

    .page_title {
        padding: 25px;
        margin-bottom: 0;

    }

    .name_starter {

        font-weight: 500;
        color: #079400
    }

    a {
        color: inherit !important;
    }

    .theme > ul > li {
        margin-top: 25px;
        font-size: 1.5rem;

    }

    .theme > ul > li > ul > li {
        color: dimgray;
        font-size: 1.2rem;
    }
</style>
