<template>
    <div class="auto-div">
        <button id="filtriraj" class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseWidthExample"
                aria-expanded="false" aria-controls="collapseWidthExample">
            Filtriraj pretragu
        </button>
        <div class="wrapper">
            <div class="filteri collapse collapse-horizontal" id="collapseWidthExample">
                <h5>Filtriraj pretragu</h5>

                <form @submit.prevent="filter">
                    <div class="box">
                        <div name="search">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                <path
                                    d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                            </svg>
                            <input v-model="filterForm.search" type="text" class="input" name="txt"
                                   placeholder="Search">
                        </div>
                    </div>
                    <div class="accordion" id="accordionExample">

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Odaberi cenu
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <input type="number" id="min-price" name="min-price" min="0"
                                           v-model="filterForm.priceFrom">
                                    <label for="min-price">Min</label> <br>
                                    <input type="number" id="max-price" name="max-price" v-model="filterForm.priceTo">
                                    <label for="max-price">Max</label> <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-outline-secondary" value="Pretraži">
                    <input type="submit" class="btn btn-outline-danger" value="Poništi" @click.prevent="clear">
                </form>
            </div>
            <div class="oglasi">
                <div class="wrap" v-for="ad in ads.data" :key="ad.id" v-if="ads.data.length">
                    <div class="slika">
                        <Link :href="route('ads.show', {ad : ad.id})">
                            <img :src="ad.image_path[0]" alt="Trkački delovi">
                        </Link>
                        <div class="data">
                            <h4>
                                {{ ad.title }} <span v-if="ad.isSold==1"
                                                     style="font-weight: bold;color: red; font-size: 8px; display: inline;">(PRODATO)</span>
                            </h4>
                        </div>
                        <span class="cena_traka" id="traka_cena">{{ ad.price }} &euro;</span>
                    </div>
                </div>
                <div v-else style="text-align: center; font-size: 50px; width: 100%; height: 500px; margin-top: 30%;">
                    <h1 style="text-align: center;">Trenutno nema oglasa</h1>
                </div>
                <div v-if="ads.data.length" style="width: 100%; display: flex;  justify-items: center; justify-content: center; align-content: center; align-items: center; margin-top: 10px;" >
                    <Pagination :links="ads.links"/>

                </div>

            </div>

        </div>
    </div>
</template>
<script setup>
import {Link, useForm} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps(
    {
        ads: Object,
        filters: Object,
    }
)
const filterForm = useForm({
    priceFrom: props.filters ? props.filters.priceFrom : null,
    priceTo: props.filters ? props.filters.priceTo : null,
    search: props.filters ? props.filters.search : null,


})
const filter = () => filterForm.get(route('parts'), {
    preserveState: true,
    preserveScroll: true,
})
const clear = () => {
    filterForm.priceTo = null
    filterForm.priceFrom = null
    filterForm.search = null

    filter()
}
</script>
