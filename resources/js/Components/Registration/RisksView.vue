<script>
import { useForm } from "@inertiajs/vue3";
import { initFlowbite } from "flowbite";
import InfosModal from "@/Components/InfosModal.vue";

export default {
    props: {
        risks: {
            type: Array,
            required: true,
        },
        companyRisks: {
            type: Object,
            required: false,
            default: null,
        },
        category: {
            type: Object,
            required: true,
        },
        nextCategory: {
            type: Object,
            required: false,
            default: null,
        },
        previousCategory: {
            type: Object,
            required: false,
            default: null,
        },
    },
    emits: ["newRiskSelected", "newCategorySelected", "validateSelection"],
    components: {
        InfosModal,
    },
    methods: {
        insertRisk(risk) {
            const form = useForm({
                id: risk.id,
                category: risk.category_id,
                name: risk.name,
                description: risk.description,
                probability: 1,
                impact: 1,
            });

            form.post("/register/risks", {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => this.$emit("newRiskSelected"),
                onError: (errors) => console.error(errors),
            });
        },
        updateRisk(evaluation, selector, newValue) {
            switch (selector) {
                case "probability":
                    evaluation.probability = newValue;
                    break;
                case "impact":
                    evaluation.impact = newValue;
                    break;
            }
            const form = useForm({
                id: evaluation.id,
                probability: evaluation.probability,
                impact: evaluation.impact,
            });

            form.patch("/register/risks", {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => this.$emit("newRiskSelected"),
                onError: (errors) => console.error(errors),
            });
        },
    },
    mounted() {
        initFlowbite();
    },
};
</script>
<template>
    <div class="px-2 py-5 w-3/4 mx-auto flex flex-wrap gap-4">
        <div class="w-full flex justify-between">
            <div class="flex gap-4 items-center">
                <span
                    class="w-4 h-4 block rounded-full"
                    :style="`background-color: ${category.color}`"
                ></span>
                <h2
                    class="text-xl text-center md:text-left font-extrabold leading-none tracking-tight md:text-3xl lg:text-3xl text-gray-900 dark:text-white"
                >
                    {{ category.name }}
                </h2>
            </div>

            <InfosModal
                title="Fonctionnement de cette page"
                id="risks-infos-modal"
            >
                    <p
                        class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                    >
                        Pour une gestion efficace des risques, suivez ces étapes
                        :
                    </p>
                    <ol class="list-decimal list-inside">
                    <li
                        class="text-base leading-relaxed text-gray-500 dark:text-gray-400 mb-2"
                    >
                        Identifiez les risques pertinents en cochant la case
                        correspondante 
                    </li>
                    <li
                        class="text-base leading-relaxed text-gray-500 dark:text-gray-400 mb-2"
                    >
                        Indiquez la probabilité de survenue du risque sur une
                        échelle de "Peu probable" à "Très probable".
                    </li>
                    <li
                        class="text-base leading-relaxed text-gray-500 dark:text-gray-400 mb-2"
                    >
                        Indiquez l'impact potentiel du risque sur une échelle de
                        "Mineur" à "Majeur".
                    </li>
                    <p
                        class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                    >
                        L'évaluation de la probabilité et de l'impact permet de
                        prioriser les mesures de prévention et de préparer des
                        stratégies adaptées pour protéger votre entreprise.
                    </p>
                </ol>
            </InfosModal>
        </div>
        <p
            class="mb-6 text-lg text-center md:text-left font-normal text-gray-700 dark:text-gray-400 lg:text-xl"
        >
            {{ category.description_long }}
        </p>
        <div class="w-full grid grid-cols-3 mt-4 mb-4 pt-4">
            <div class="flex justify-start">
                <button
                    type="button"
                    v-if="previousCategory"
                    @click="$emit('newCategorySelected', previousCategory.id)"
                    class="text-gray-900 dark:text-white hover:bg-gray-200 focus:outline-none font-medium rounded-lg text-sm px-6 py-4 text-center inline-flex items-center dark:hover:bg-gray-800 duration-300"
                >
                    <svg
                        class="rtl:rotate-180 rotate-180 w-3.5 h-3.5 mr-2"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 14 10"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9"
                        />
                    </svg>
                    {{ previousCategory.name }}
                </button>
            </div>
            <div class="flex justify-center">
                <button
                    class="text-gray-600 border border-gray-900 hover:bg-gray-600 hover:text-white focus:outline-none font-medium rounded-lg text-sm px-6 py-4 text-center inline-flex items-center dark:text-gray-300 dark:border-gray-600 dark:hover:border-gray-800 dark:hover:bg-gray-800 dark:hover:text-white duration-300"
                    @click="$emit('newCategorySelected', null)"
                >
                    Vue d'ensemble des catégories
                </button>
            </div>
            <div class="flex justify-end">
                <button
                    type="button"
                    v-if="nextCategory"
                    @click="$emit('newCategorySelected', nextCategory.id)"
                    class="text-gray-900 dark:text-white hover:bg-gray-200 focus:outline-none font-medium rounded-lg text-sm px-6 py-4 text-center inline-flex items-center dark:hover:bg-gray-800 duration-300"
                >
                    {{ nextCategory.name }}
                    <svg
                        class="rtl:rotate-180 w-3.5 h-3.5 ms-2"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 14 10"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9"
                        />
                    </svg>
                </button>
                <button
                    v-else
                    @click="$emit('validateSelection')"
                    class="text-white bg-primary-700 hover:bg-primary-800 focus:outline-none font-medium rounded-lg text-sm px-10 text-center inline-flex items-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 duration-300"
                >
                Terminer la sélection de risques
                </button>
            </div>
        </div>
        <div
            class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-800"
            v-for="risk in risks"
        >
            <label class="flex">
                <div class="w-full">
                    <p
                        class="font-normal text-lg text-gray-900 dark:text-white"
                    >
                        {{ risk.name }}
                    </p>
                    <p class="font-normal text-gray-700 dark:text-gray-400">
                        {{ risk.description }}
                    </p>
                </div>
                <div class="h-full flex justify-end items-center w-16">
                    <input
                        id="red-checkbox"
                        type="checkbox"
                        :checked="
                            companyRisks.find((r) => r.risk_id === risk.id)
                        "
                        value=""
                        @click="insertRisk(risk)"
                        class="w-6 h-6 text-red-600 bg-gray-100 border-gray-300 rounded dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 hover:cursor-pointer"
                    />
                </div>
            </label>
            <div
                v-if="companyRisks.find((r) => r.risk_id === risk.id)"
                class="w-full mt-4 pt-4"
            >
                <div class="relative mb-12">
                    <label
                        for="labels-range-input"
                        class="font-normal text-lg text-gray-700 dark:text-white"
                        >Probabilité
                    </label>
                    <input
                        id="labels-range-input"
                        type="range"
                        :value="
                            companyRisks.find((r) => r.risk_id === risk.id)
                                .evaluations[0].probability
                        "
                        @input="
                            updateRisk(
                                companyRisks.find((r) => r.risk_id === risk.id)
                                    .evaluations[0],
                                'probability',
                                $event.target.value
                            )
                        "
                        min="1"
                        max="4"
                        class="w-full h-1 bg-gray-200 h1 rounded-lg appearance-none cursor-pointer range-sm dark:bg-gray-700"
                    />
                    <span
                        class="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6"
                        >Peu probable</span
                    >
                    <span
                        class="text-sm text-gray-500 dark:text-gray-400 absolute start-1/3 -translate-x-1/2 rtl:translate-x-1/2 -bottom-6"
                        >Possible</span
                    >
                    <span
                        class="text-sm text-gray-500 dark:text-gray-400 absolute start-2/3 -translate-x-1/2 rtl:translate-x-1/2 -bottom-6"
                        >Probable</span
                    >
                    <span
                        class="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6"
                        >Très probable</span
                    >
                </div>
                <div class="relative mb-6">
                    <label
                        for="labels-range-input"
                        class="font-normal text-lg text-gray-700 dark:text-white"
                        >Impact</label
                    >
                    <input
                        id="labels-range-input"
                        type="range"
                        :value="
                            companyRisks.find((r) => r.risk_id === risk.id)
                                .evaluations[0].impact
                        "
                        @input="
                            updateRisk(
                                companyRisks.find((r) => r.risk_id === risk.id)
                                    .evaluations[0],
                                'impact',
                                $event.target.value
                            )
                        "
                        min="1"
                        max="4"
                        class="w-full h-1 bg-gray-200 h1 rounded-lg appearance-none cursor-pointer range-sm dark:bg-gray-700"
                    />
                    <span
                        class="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6"
                        >Mineur</span
                    >
                    <span
                        class="text-sm text-gray-500 dark:text-gray-400 absolute start-1/3 -translate-x-1/2 rtl:translate-x-1/2 -bottom-6"
                        >Significatif</span
                    >
                    <span
                        class="text-sm text-gray-500 dark:text-gray-400 absolute start-2/3 -translate-x-1/2 rtl:translate-x-1/2 -bottom-6"
                        >Important</span
                    >
                    <span
                        class="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6"
                        >Majeur</span
                    >
                </div>
            </div>
        </div>
    </div>
</template>
