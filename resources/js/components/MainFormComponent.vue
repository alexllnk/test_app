<template>
    <div>
        <form v-on:submit.prevent>
            <div class="form-group">
                <input name="name" type="text" class="form-control" placeholder="название дома (содержит символы)" value="" v-model="name">
            </div>
            <div class="form-group">
                <input name="price_starts_at" type="text" class="form-control" placeholder="цена (не менее)" value="" v-model="price_starts_at">
            </div>
            <div class="form-group">
                <input name="price_ends_at" type="text" class="form-control" placeholder="цена (не более)" value="" v-model="price_ends_at">
            </div>
            <div class="form-group">
                <input name="bedrooms" type="text" class="form-control" placeholder="спальни" value="" v-model="bedrooms">
            </div>
            <div class="form-group">
                <input name="bathrooms" type="text" class="form-control" placeholder="ванные комнаты" value="" v-model="bathrooms">
            </div>
            <div class="form-group">
                <input id="storeys" name="storeys" type="text" class="form-control" placeholder="этажи" value="" v-model="storeys">
            </div>
            <div class="form-group">
                <input name="garages" type="text" class="form-control" placeholder="гаражи" value="" v-model="garages">
            </div>
            <button type="submit" class="btn btn-primary mb-2" @click="performRequest">Найти</button>

        </form>
        <hr>
        <div v-show="req_in_process">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="results" v-show="req_finished">
            <h3>Результаты поиска</h3>
            <div id="result_box">{{ zero_search_result }}</div>
            <table class="table" v-show="res_data.length">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">название</th>
                    <th scope="col">цена</th>
                    <th scope="col">спальни</th>
                    <th scope="col">ванные</th>
                    <th scope="col">этажи</th>
                    <th scope="col">гаражи</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row_data in res_data">
                    <td v-for="td_data in row_data">{{td_data}}</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

</template>

<script>
    export default {
        name: "MainFormComponent",
        data() {
            return {
                name: '',
                price_starts_at: '',
                price_ends_at: '',
                bedrooms: '',
                bathrooms: '',
                storeys: '',
                garages: '',
                zero_search_result: '',
                req_in_process: false,
                req_finished: false,
                res_data: []
            };
        },
        /*props: ['mainsettings'],*/
        created: function () {
            // `this` points to the vm instance
            //console.log(this.mainsettings.price_starts_at);
        },
        mounted: function () {
        },
        methods: {
            performRequest() {
                this.req_in_process = true;
                axios.post('/api/houses', {
                    name: this.name,
                    price_starts_at: this.price_starts_at,
                    price_ends_at: this.price_ends_at,
                    bedrooms: this.bedrooms,
                    bathrooms: this.bathrooms,
                    storeys: this.storeys,
                    garages: this.garages,
                }).then(response => {
                    this.req_in_process = false;
                    this.req_finished = true;
                    //console.log(response);
                    if (response.data.data.length) {

                        //this.search_result = response.data.data;
                        this.res_data = response.data.data;
                        this.zero_search_result = '';
                        //this.drawResultTable(response.data.data);

                    } else {
                        this.res_data = [];
                        this.zero_search_result = 'По Вашему запросу ничего не найдено.';
                    }
                });


            }
        }
    }
</script>

<style scoped>
    #result_box {
        padding: 10px;
        word-break: break-word;
    }
</style>
