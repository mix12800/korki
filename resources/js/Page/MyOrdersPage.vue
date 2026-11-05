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
                            :disabled="order.status != 'completed'"
                        >
                            Написать отзыв
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Оставьте отзыв о курсе
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
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
                            id="exampleFormControlTextarea1"
                            placeholder="Отзыв..."
                            rows="3"
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-lg w-100">
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
    },
};
</script>
