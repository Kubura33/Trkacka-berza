<script setup>
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import {ref, computed} from "vue";
const message = ref(null)
const fileInput = ref(null)
const props = defineProps(
    {
        ad:Object,
        isEditting : false
    }
)
const form = useForm({
    name: props.ad ? props.ad.title : "",
    vehicle_model: props.ad ? props.ad.advertisable.model : "",
    vehicle_class: props.ad ? props.ad.advertisable.vehicle_class : "",
    engine_displacement: props.ad ? props.ad.advertisable.engine_displacement : "",
    description: props.ad ? props.ad.advertisable.description : "",
    price: props.ad ? props.ad.price : "",
    discipline: props.ad ? props.ad.advertisable.discipline : 0,
    fixed: props.ad ? props.ad.fixed : 1,
    year: props.ad ? props.ad.advertisable.year : "",
    type: 'vehicle',
    images: [],

})

const openFileInput = () => {
    fileInput.value.click()
}
const handleFileChange = () => {
    const files = fileInput.value.files;
    if (files.length > 5) {
        message.value = "Maksimalan broj slika je 5"
    } else {
        for (let i = 0; i < files.length; i++) {
            form.images.push(files[i])
        }
    }
}
const useMessage = computed(() => {message ? message.value : null
})
const store = () => form.post(route('ads.store'))
const update = () => form.put(route('ads.update', {ad:props.ad.id}))
const ruta = computed(()=> {
    if(props.isEditting)
        return update()
    else
        return store()
})
</script>

<template>
    <div class="signupSection_top"
        style="display: flex;flex-direction: row;align-items: center;justify-content: center;justify-items: center; width: 100%;">


        <div class="signupSection">
            <div class="info">
                <div v-if="!isEditting" class="icon" @click="emitAction">
                    <div class="arrow"></div>
                </div>
                <img src="/images/toyota.jpg" alt="">
            </div>
            <form @submit.prevent="ruta" class="signupForm" name="signupform">
                <h2>Oglas za automobile</h2>
                <ul class="noBullet">
                    <li>
                        <label for="name"></label>
                        <input v-model="form.name" type="text" class="inputFields" id="name" name="name"
                               placeholder="Naslov oglasa"/>
                        <InputError v-if="form.errors.name" :message="form.errors.name"/>
                    </li>
                    <li>
                        <label for="model"></label>
                        <input v-model="form.vehicle_model" type="text" class="inputFields" id="model" name="model"
                               placeholder="Model"/>
                        <InputError v-if="form.errors.vehicle_model" :message="form.errors.vehicle_model"/>
                    </li>
                    <li>
                        <label for="klasa"></label>
                        <input v-model="form.vehicle_class" type="text" class="inputFields" id="klasa" name="klasa"
                               placeholder="Klasa"/>
                        <InputError v-if="form.errors.vehicle_class" :message="form.errors.vehicle_class"/>
                    </li>
                    <li>
                        <label for="kubikaza"></label>
                        <input v-model="form.engine_displacement" type="text" class="inputFields" id="kubikaza"
                               name="kubikaza" placeholder="Kubikaza    "/>
                        <InputError v-if="form.errors.engine_displacement" :message="form.errors.engine_displacement"/>
                    </li>
                    <li>
                        <label for="godiste"></label>
                        <input v-model="form.year" type="number" class="inputFields" id="kubikaza"
                               name="godiste" placeholder="Godiste    "/>
                        <InputError v-if="form.errors.year" :message="form.errors.year"/>
                    </li>
                    <li>
                        <label for="opis"></label>
                        <resize-textarea v-model="form.description" class="inputFields" name="opis" id="opis"
                                         placeholder="Opis"></resize-textarea>
                        <InputError v-if="form.errors.description" :message="form.errors.description"/>
                    </li>
                    <li>
                        <label for="cena"></label>
                        <input v-model="form.price" type="text" class="inputFields" id="cena" name="cena"
                               placeholder="Cena(€)" required/>
                        <InputError v-if="form.errors.price" :message="form.errors.price"/>
                    </li>
                    <li>
                        <label for="discipline"></label>
                        <select v-model="form.discipline" name="discipline" id="discipline" class="inputFields"
                                style="color: rgb(0, 0, 0); background-color: white; opacity: 0.5;">
                            <option value="0" selected>-- Izaberite disciplinu --</option>
                            <option value="Rally">
                                Reli
                            </option>
                            <option value="Brdske">
                                Brdske
                            </option>
                            <option value="Kruzne">
                                Kruzne
                            </option>
                            <option value="Slalom">
                                Slalom
                            </option>
                            <option value="Autokros">
                                Autokros
                            </option>
                            <option value="Drift">
                                Drift
                            </option>
                            <option value="Karting">
                                Karting
                            </option>
                        </select>
                        <InputError v-if="form.errors.discipline" :message="form.errors.discipline"/>
                    </li>

                    <li
                        style="display: flex; flex-direction: row; justify-items: center;align-items: center;justify-content: center; gap:0.4rem; margin-bottom: 30px;">
                        <label for="">Fiksna cena? </label>
                        <label for="da">Da</label>
                        <input v-model="form.fixed" type="radio" id="da" value="1" name="fixed"/>
                        <label for="ne">Ne</label>
                        <input v-model="form.fixed" type="radio" id="ne" value="0" name="fixed">
                        <InputError v-if="form.errors.fixed" :message="form.errors.fixed"/>
                    </li>

                    <li>
                        <div class="Neon Neon-theme-dragdropbox" v-if="!isEditting">
                            <input ref="fileInput" name="files[]" id="filer_input2" multiple="multiple" type="file" hidden @change="handleFileChange">
                            <div class="Neon-input-dragDrop">
                                <div class="Neon-input-inner">
                                    <div class="Neon-input-icon"><i class="fa fa-file-image-o"></i></div>
                                    <div class="Neon-input-text">
                                        <h3 v-if="form.images.length===0 && !message">*Prva slika je naslovna, max broj slika je 5</h3>
                                        <h3 v-if="useMessage" style="color: red">{{ useMessage }}</h3>

                                        <div v-else>
                                            <span v-for="image in form.images">
                                                {{image.name}}
                                            </span>

                                        </div>
                                        <span
                                            style="display:inline-block; margin: 20px 0"></span>
                                    </div>
                                    <a href="#" class="Neon-input-choose-btn blue" @click.prevent="openFileInput">Odaberi slike</a>
                                </div>
                            </div>
                        </div>
                        <div v-if="isEditting">
                            Za menjanje slika, obrisite oglas pa kreirajte opet!
                        </div>
                        <InputError v-if="form.errors.images" :message="form.errors.images"/>
                    </li>
                    <li id="center-btn">

                        <input :disabled="form.processing" type="submit" id="join-btn" name="join" alt="Join" :value="isEditting ? 'Edituj oglas' : 'Kreiraj oglas'">
                    </li>
                </ul>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    methods: {
        emitAction() {
            this.$emit('arrow-clicked');
        },
    }

};
</script>
