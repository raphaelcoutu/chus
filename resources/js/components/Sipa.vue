<template>
    <div class="col-sm-12">
        <select v-model="form.selectedName">
            <option v-for="name in antibioticNames" v-bind:value="name">
                {{ name }}
            </option>
        </select>
        <input type="text" placeholder="ClCr" v-model="form.crCl" size="5">
        <select v-model="form.patientType">
            <option value="Normal">Normal</option>
            <option value="Pseudo">Pseudo</option>
            <option value="Hémodialyse">Hemodialyse</option>
            <option value="HemoPseudo">HemoPseudo</option>
        </select>

        <select v-model="form.obesity">
            <option value="0">Poids normal</option>
            <option value="1">Obèse</option>
        </select>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>CrCl</th>
                <th>Route</th>
                <th>WeightMin</th>
                <th>WeightMax</th>
                <th>WeightType</th>
                <th>DoseMin</th>
                <th>DoseMax</th>
                <th>FreqMin</th>
                <th>FreqMax</th>
                <th>MinDailyDose</th>
                <th>MaxDailyDose</th>
            </tr>
            </thead>
            <tbody v-if="selectedAdjustments.length">
            <tr v-for="adjustment in selectedAdjustments">
                <td>{{ adjustment.crClMin }} - {{ adjustment.crClMax }}</td>
                <td>{{ adjustment.route }}</td>
                <td>{{ adjustment.weightMin }}</td>
                <td>{{ adjustment.weightMax }}</td>
                <td>{{ adjustment.weightType }}</td>
                <td>{{ adjustment.doseMin }} {{ adjustment.doseUnit }}</td>
                <td>{{ adjustment.doseMax }} {{ adjustment.doseUnit }}</td>
                <td>{{ adjustment.freqMin }}h</td>
                <td>{{ adjustment.freqMax }}h</td>
                <td>{{ adjustment.minDailyDose }}</td>
                <td>{{ adjustment.maxDailyDose }}</td>
            </tr>
            </tbody>
            <tbody v-else>
            <tr>
                <td>Aucun résultat.</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import Adjustements from './../data.json'

    export default {
        created() {
            this.getAntibioticNames();
        },

        data() {
            return {
                antibioticNames: [],
                form: {
                    name: '',
                    crCl: null,
                    patientType: "Normal",
                    obesity: 0
                }
            }
        },

        methods: {
            getAntibioticNames() {
                let list = [];

                _.forEach(Adjustements, function(adj) {
                    if(!list.includes(adj.name)) {
                        list.push(adj.name)
                    }
                });

                this.antibioticNames = _.sortBy(list);
            }
        },

        computed: {
            selectedAdjustments() {
                let result = [];
                let form = this.form;

                if(this.form.selectedName) {
                    result = _.filter(Adjustements, {
                        name: form.selectedName,
                        patientType: form.patientType,
                        obesity: !!parseInt(form.obesity)
                    });

                    if(this.form.crCl !== null && this.form.crCl > 0) {
                        result = _.filter(result, function(adj) {
                            return form.crCl >= adj.crClMin && form.crCl < adj.crClMax;
                        })
                    }
                }

                return result;
            }
        }

    }
</script>
