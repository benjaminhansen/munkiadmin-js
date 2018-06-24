<template>
    <div>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Catalogs</th>
                        <th>Filename</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="loading">
                        <td colspan="3">Loading Manifests...</td>
                    </tr>
                    <tr v-else v-for="manifest in manifests" class="clickable-row" @click="viewManifest(manifest)">
                        <td>{{ plistParse(manifest.content).display_name != null ? plistParse(manifest.content).display_name : manifest.file.split('/')[manifest.file.split('/').length - 1] }}</td>
                        <td>{{ plistParse(manifest.content).catalogs.join(", ") }}</td>
                        <td>{{ manifest.file.split('/')[manifest.file.split('/').length - 1] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        ready() {
            this.prepare();
        },

        mounted() {
            this.prepare();
        },

        data() {
            return {
                manifests:[],
                loading:true
            };
        },

        methods: {
            prepare() {
                this.getManifests();
            },

            getManifests() {
                axios.get(window.laravel.app_url + "/api/v1/manifests/content")
                    .then(response => {
                        if(response.data.success == null || response.data.success != false) {
                            this.manifests = response.data;
                            this.loading = false;
                            console.log(this.plistParse(this.manifests[0].content))
                        } else {
                            alert(response.data.message);
                        }
                    });
            },

            viewManifest(manifest) {

            },

            plistParse(contents) {
                return plist.parse(contents);
            },

            dateParse(date) {
                return moment(date).format('MMMM Do YYYY, h:mm:ss a');
            }
        }
    }
</script>
