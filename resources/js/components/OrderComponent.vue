<template>
    <tr>
        <th>
            {{ keys + 1 }}
        </th>
        <td>
            {{ order.course.name }}
        </td>
        <td>
            {{ order.user.fio }}
        </td>
        <td>
            {{ new Date(order.date).toLocaleDateString("ru-RU") }}
        </td>
        <td>
            {{ payMethod[order.pay] }}
        </td>
        <td>
            <select class="form-select mb-3" v-model="status">
                <option value="new">Новая</option>
                <option value="active">Идет обучение</option>
                <option value="completed">Обучение завершено</option>
            </select>
        </td>
        <td>
            <button
                class="btn btn-dark"
                data-bs-toggle="modal"
                data-bs-target="#exampleModalComent"
                @click="OrderGet(keys)"
                :disabled="!order.comment"
            >
                Прочитать отзыв
            </button>
        </td>
        <td>
            <button
                @click="UpdateOrder"
                class="btn btn-dark"
                :disabled="isLoading"
            >
                Сохранить
            </button>
        </td>
    </tr>
</template>
<script>
export default {
    name: "OrderComponent",
    props: ["order", "OrdersGet", "server", "OrderGet", "keys"],

    data() {
        return {
            status: this.order.status,
            isLoading: false,
            payMethod: {
                cash: "наличными",
                translation: "переводом по номеру телефона",
            },
        };
    },

    methods: {
        UpdateOrder() {
            this.isLoading = true;
            let formdata = new FormData();
            formdata.append("status", this.status);
            this.server(`order/${this.order.id}`, "PATCH", formdata)
                .then((result) => {
                    this.OrdersGet();
                    this.isLoading = false;
                })
                .catch((error) => console.error(error));
        },
    },
};
</script>
