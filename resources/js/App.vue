<template>
    <AuthPage v-if="Page == 'AuthPage'" :page="page" :server="server" />
    <RegistrationPage
        v-if="Page == 'RegistrationPage'"
        :page="page"
        :server="server"
    />
</template>
<script>
import AuthPage from "./Page/AuthPage.vue";
import RegistrationPage from "./Page/RegistrationPage.vue";

export default {
    name: "App",

    data() {
        return {
            Page: localStorage.getItem("page") || "RegistrationPage",
            server_URL: "http://127.0.0.1:8000/api/",
        };
    },

    methods: {
        page(page) {
            this.Page = page;
            localStorage.setItem("page", page);
        },

        async server(route, method = "GET", formdata = null) {
            const myHeaders = new Headers();
            myHeaders.append("Accept", "accept/json");

            const requestOptions = {
                method: method,
                headers: myHeaders,
                redirect: "follow",
            };

            if (method != "GET" && method != "DELETE") {
                requestOptions.body = formdata;
            }

            return await fetch(this.server_URL + route, requestOptions).then(
                (response) => {
                    return response.json();
                },
            );
        },
    },

    components: {
        AuthPage,
        RegistrationPage,
    },
};
</script>
