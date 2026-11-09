<template>
    <div class="p-5">
        <select
            class="form-select mb-3"
            v-model="status_filter"
            @change="OrdersGet"
            aria-label=".form-select-lg пример"
        >
            <option value="" selected>Фильтр</option>
            <option v-for="value in statusOption" :value="value.value">
                {{ value.text }}
            </option>
        </select>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Курс</th>
                    <th scope="col">Ученик</th>
                    <th scope="col">Дата обучения</th>
                    <th scope="col">Способ оплаты</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Отзыв</th>
                    <th scope="col">Действие</th>
                </tr>
            </thead>
            <tbody>
                <OrderComponent
                    v-for="(order, key) in dataPage.data"
                    :order="order"
                    :OrdersGet="OrdersGet"
                    :server="server"
                    :OrderGet="OrderGet"
                    :keys="key"
                />
            </tbody>
        </table>
        <div class="btn-group btn-group-lg w-50">
            <button
                type="button"
                class="btn btn-dark"
                @click="OrdersGet(dataPage.current_page - 1)"
                :disabled="dataPage.current_page == 1"
            >
                <i class="bi bi-chevron-double-left"></i>
            </button>
            <button
                type="button"
                class="btn btn-dark"
                @click="OrdersGet(dataPage.current_page + 1)"
                :disabled="dataPage.last_page == dataPage.current_page"
            >
                <i class="bi bi-chevron-double-right"></i>
            </button>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Отзыв от:
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Закрыть"
                    ></button>
                </div>
                <div class="modal-body">{{ order.comment }}</div>
            </div>
        </div>
    </div>
</template>
<script>
import OrderComponent from "../components/OrderComponent.vue";

export default {
    name: "OrdersPage",
    props: ["server"],

    data() {
        return {
            dataPage: [],
            order: {},
            statusOption: [
                {
                    text: "Новые заявки",
                    value: "new",
                },
                {
                    text: "Идет обучение",
                    value: "active",
                },
                {
                    text: "Обучение завершено",
                    value: "completed",
                },
            ],
            status_filter: "",
            sortOptons: {},
        };
    },

    mounted() {
        this.OrdersGet();
    },

    methods: {
        OrdersGet(page = 1) {
            let formdata = new FormData();
            formdata.append("status_filter", this.status_filter);
            this.server(`orders?page=${page}`, "POST", formdata)
                .then((result) => {
                    console.log(result.orders.data);
                    this.dataPage = result.orders;
                })
                .catch((error) => console.error(error));
        },

        OrderGet(key) {
            this.order = this.dataPage.data[key];
        },
    },

    components: {
        OrderComponent,
    },
};
</script>
