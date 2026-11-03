<template>
    <div class="form">
        <div class="mb-3 form-title">
            <h2>Авторизация</h2>
        </div>

        <div class="form-floating mb-3">
            <input
                type="text"
                class="form-control focus-ring focus-ring-dark border"
                id="login"
                placeholder="login"
            />
            <label for="login">Логин</label>
        </div>
        <div class="form-floating mb-3">
            <input
                type="password"
                class="form-control focus-ring focus-ring-dark border"
                id="password"
                placeholder="password"
            />
            <label for="password">Пароль</label>
        </div>

        <button class="btn btn-dark btn-lg w-100 mb-3">Войти</button>

        <div class="link-form mb-1">
            Ещё не зарегистрированы?
            <a href="Registration.html" @click.prevent="page('RegistrationPage')"
                >Регистрация</a
            >
        </div>
    </div>
</template>
<script>
export default {
    name: "AuthPage",
    props: ["page"],
};
</script>
