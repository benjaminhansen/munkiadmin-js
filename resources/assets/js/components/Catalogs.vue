<template>
    <div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Name</th><th># of Assigned Packages</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="loading">
                        <td colspan="2">Loading...</td>
                    </tr>
                    <tr v-else v-for="catalog in catalogs" class="clickable-row" @click="viewCatalog(catalog)">
                        <td>{{ catalog.file.split('/')[1] }}</td>
                        <td>{{ plistParse(catalog.content).length }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="modal modal-lg fade" tabindex="-1" role="dialog" id="view-catalog-modal" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content modal-dialog-lg">
              <div class="modal-header">
                <h5 class="modal-title">{{ current_catalog.name }} Catalog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cancelEdits()">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="table-responsive">
                      <table class="table table-striped">
                          <thead>
                              <tr>
                                  <th></th><th>Name</th><th>Display Name</th><th>Version</th><th></th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr v-for="pkg in current_catalog.data">
                                  <td><img :src="getIconPath(pkg.icon_name)" class="package-icon" alt="icon" /></td>
                                  <td>{{ pkg.name }}</td>
                                  <td>{{ pkg.display_name }}</td>
                                  <td>{{ pkg.version }}</td>
                                  <td><button type="button" class="btn btn-sm btn-danger" @click="removeFromCatalog(pkg)">Remove From Catalog</button></td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="cancelEdits()" data-dismiss="modal"><span class="fa fa-times"></span> Cancel</button>
                <button type="button" class="btn btn-success" @click="saveEdits()" v-bind:class="{disabled:!current_catalog.changes_made}"><span class="fa fa-check"></span> Save Changes</button>
              </div>
            </div>
          </div>
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
                packages: [],
                catalogs:[],
                current_catalog: {},
                loading:true
            };
        },

        methods: {
            prepare() {
                this.getPackages();
                this.getCatalogs();
            },

            getPackages(query) {
                axios.get(window.laravel.app_url + '/api/v1/packages-info/content')
                    .then(response => {
                        this.packages = response.data;
                    });
            },

            getIconPath(icon) {
                if(icon != "" && icon != null) {
                    return window.laravel.app_url + "/files/icons/" + icon;
                } else {
                    return window.laravel.app_url + "/images/no-icon.png";
                }
            },

            getCatalogs() {
                this.loading = true;
                axios.get(window.laravel.app_url + "/api/v1/catalogs/content")
                    .then(response => {
                        this.catalogs = response.data;
                        this.loading = false;
                    });
            },

            cancelEdits() {
                if(this.current_catalog.changes_made) {
                    if(confirm("Are you sure?\nYou have unsaved changes that will be lost!")) {
                        this.current_catalog = {};
                    }
                } else {
                    this.current_catalog = {};
                }
            },

            saveEdits() {

            },

            viewCatalog(catalog) {
                var parsed = this.plistParse(catalog.content);
                this.current_catalog = {
                    name: catalog.file.split('/')[1],
                    data: parsed,
                    changes_made: false
                };
                $("#view-catalog-modal").modal();
            },

            removeFromCatalog(pkg) {
                if(confirm("Are you sure?")) {
                    var indexOf = this.current_catalog.data.indexOf(pkg);
                    this.current_catalog.data.splice(indexOf, 1);
                    this.current_catalog.changes_made = true;
                }
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
