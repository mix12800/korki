<template>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="@/img/logo.webp" class="logo" alt="" />
                Корочки.есть
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-underline">
                    <template v-if="user.role == 'admin'">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Заявки</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Курсы</a>
                        </li>
                    </template>
                    <template v-else>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                :class="{ active: page == 'MyOrdersPage' }"
                                href="#"
                                @click.prevent="ChangePage('MyOrdersPage')"
                                >Мои заявки</a
                            >
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link"
                                :class="{ active: page == 'OrderAddPage' }"
                                href="#"
                                @click.prevent="ChangePage('OrderAddPage')"
                                >Сформировать заявку</a
                            >
                        </li>
                    </template>
                </ul>
                <button
                    class="btn btn-dark"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                >
                    <i class="bi bi-box-arrow-in-right"></i> Выход
                </button>
            </div>
        </div>
    </nav>

    <!-- Модальное окно выхода -->
    <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Выйти из аккаунта?
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Закрыть"
                    ></button>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-danger btn-lg w-100"
                        data-bs-dismiss="modal"
                        @click="logout"
                    >
                        Выйти
                    </button>
                    <button
                        type="button"
                        class="btn btn-secondary btn-lg w-100"
                        data-bs-dismiss="modal"
                    >
                        Отмена
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "HeaderComponent",
    props: ["logout", "user", "page", "ChangePage"],
};
</script>
