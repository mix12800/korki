<template>
    <div class="p-5">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Курс</th>
                    <th scope="col">Дата обучения</th>
                    <th scope="col">Способ оплаты</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Отзыв</th>
                    <th scope="col">Действие</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(order, key) in Orders" :key="key">
                    <th>{{ key + 1 }}</th>
                    <td>{{ order.course.name }}</td>
                    <td>
                        {{ new Date(order.date).toLocaleDateString("ru-RU") }}
                    </td>
                    <td>
                        {{ payMethod[order.pay] }}
                    </td>
                    <td>
                        <span
                            class="badge"
                            :class="status.class[order.status]"
                            >{{ status.text[order.status] }}</span
                        >
                    </td>
                    <td>
                        <button
                            class="btn btn-dark"
                            data-bs-toggle="modal"
                            data-bs-target="#exampleModalComent"
                            @click="OrderGet(key)"
                            :disabled="
                                order.status != 'completed' || order.comment
                            "
                        >
                            Написать отзыв
                        </button>
                    </td>
                    <td>
                        <button
                            class="btn btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#exampleModalDelOrder"
                            @click="OrderGet(key)"
                            :disabled="order.status != 'new'"
                        >
                            <i class="bi bi-x-octagon"></i> Отменить заявку
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Модальное окно Отмена -->
    <div
        class="modal fade"
        id="exampleModalDelOrder"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1
                        v-if="order.course"
                        class="modal-title fs-5"
                        id="exampleModalLabel"
                    >
                        Отменить заявку на курс: {{ order.course.name }}?
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        id="closeDelOrede"
                        data-bs-dismiss="modal"
                        aria-label="Закрыть"
                    ></button>
                </div>
                <div class="modal-body">
                    <label for="exampleFormControlTextarea1" class="form-label"
                        >Вы можете отменить заявку на курс, пока её не принял
                        администратор.</label
                    >
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-danger btn-lg w-100"
                        @click="OrderDel"
                    >
                        Да отменить
                    </button>
                    <button
                        type="button"
                        data-bs-dismiss="modal"
                        class="btn btn-dark btn-lg w-100"
                    >
                        Закрыть окно
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно отзыв -->
    <div
        class="modal fade"
        id="exampleModalComent"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1
                        v-if="order.course"
                        class="modal-title fs-5"
                        id="exampleModalLabel"
                    >
                        Оставьте отзыв о курсе: {{ order.course.name }}
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        id="closeCommebtAdd"
                        data-bs-dismiss="modal"
                        aria-label="Закрыть"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label
                            for="exampleFormControlTextarea1"
                            class="form-label"
                            >Текст отзыва</label
                        >
                        <textarea
                            class="form-control focus-ring focus-ring-dark border"
                            :class="{ 'is-invalid': errors.comment }"
                            v-model="comment"
                            id="exampleFormControlTextarea1"
                            placeholder="Отзыв..."
                            rows="3"
                        ></textarea>
                        <div v-if="errors.comment" class="invalid-feedback">
                            {{ errors.comment.join(". ") }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-dark btn-lg w-100"
                        @click="CommentAdd()"
                    >
                        Отправить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "MyOrders",
    props: ["server"],

    data() {
        return {
            comment: "",
            Orders: [],

            payMethod: {
                cash: "наличными",
                translation: "переводом по номеру телефона",
            },

            status: {
                text: {
                    new: "Новая",
                    active: "Идет обучение",
                    completed: "Обучение завершено",
                },
                class: {
                    new: "text-bg-primary",
                    active: "text-bg-success",
                    completed: "text-bg-secondary",
                },
            },

            order: {},
            isLoading: false,
            errors: {},
        };
    },

    mounted() {
        this.OrdersGet();
    },

    methods: {
        OrdersGet() {
            this.server(`myorder`)
                .then((result) => {
                    this.Orders = result.Orders;
                })
                .catch((error) => console.error(error));
        },

        OrderGet(key) {
            this.order = this.Orders[key];
        },

        OrderDel() {
            this.server(`order/${this.order.id}`, "DELETE")
                .then((result) => {
                    this.OrdersGet();
                    document.querySelector("#closeDelOrede").click();
                })
                .catch((error) => console.error(error));
        },

        CommentAdd() {
            this.isLoading = true;
            let formdata = new FormData();
            formdata.append("comment", this.comment);
            this.server(`commentAdd/${this.order.id}`, "PATCH", formdata)
                .then((result) => {
                    if (result.errors) {
                        this.errors = result.errors;
                    } else {
                        this.OrdersGet();
                        document.querySelector("#closeCommebtAdd").click();
                    }
                    this.isLoading = false;
                })
                .catch((error) => console.error(error));
        },
    },
};
</script>
