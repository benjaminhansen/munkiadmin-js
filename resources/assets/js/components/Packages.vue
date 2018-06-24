<template>
    <div>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <h5 class="card-header card-header-sm">Developers</h5>
                    <div class="card-body">
                        <div class="list-group list-group-sm">
                            <div class="list-group-item" v-if="loading">
                                Loading...
                            </div>
                            <button v-else type="button" class="list-group-item developer" v-for="developer in developers" @click="applyDeveloper(developer)">
                                <span class="fa fa-user"></span> {{ developer }}
                            </button>
                        </div>
                    </div>
                </div>
                <br />
                <div class="card">
                    <h5 class="card-header card-header-sm">Categories</h5>
                    <div class="card-body">
                        <div class="list-group list-group-sm">
                            <div class="list-group-item" v-if="loading">
                                Loading...
                            </div>
                            <button v-else type="button" class="list-group-item category" v-for="category in categories" @click="applyCategory(category)">
                                <span class="fa fa-tag"></span> {{ category }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th></th><th>Name</th><th>Display Name</th><th>Version</th><th>Modified</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="loading">
                                <td colspan="5">Loading Packages...</td>
                            </tr>
                            <tr v-else v-for="pkg in packages" class="clickable-row package" @click="viewPackage(pkg)" :data-category="plistParse(pkg.content).category" :data-developer="plistParse(pkg.content).developer">
                                <td><img :src="getIconPath(plistParse(pkg.content).icon_name)" class="package-icon" alt="icon" /></td>
                                <td>{{ plistParse(pkg.content).name }}</td>
                                <td>{{ plistParse(pkg.content).display_name }}</td>
                                <td>{{ plistParse(pkg.content).version }}</td>
                                <td>{{ dateParse(plistParse(pkg.content)._metadata.creation_date) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal modal-lg fade" tabindex="-1" role="dialog" id="view-package-modal" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content modal-dialog-lg">
              <div class="modal-header">
                <h5 class="modal-title">{{ current_package.name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cancelEdits()">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="cancelEdits()" data-dismiss="modal"><span class="fa fa-times"></span> Cancel</button>
                <button type="button" class="btn btn-success"><span class="fa fa-check"></span> Save Changes</button>
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
                packages:[],
                developer:"",
                category:"",
                current_package:{},
                categories:[],
                developers:[],
                loading:true
            };
        },

        methods: {
            prepare() {
                this.getPackages();
                this.getCategories();
                this.getDevelopers();
            },

            cancelEdits() {
                this.current_package = {};
            },

            applyDeveloper(developer) {
                this.developer = developer;
                if(developer == "All") {
                    $(".package").show();
                } else {
                    $(".package").hide();
                    $(".package[data-developer='"+developer+"']").show();
                }
                this.backToTop();
            },

            applyCategory(category) {
                this.category = category;
                if(category == "All") {
                    $(".package").show();
                } else {
                    $(".package").hide();
                    $(".package[data-category='"+category+"']").show();
                }
                this.backToTop();
            },

            backToTop() {
                $('html,body').animate({
                    scrollTop: 0
                }, "fast");
            },

            getCategories() {
                axios.get(window.laravel.app_url + '/api/v1/categories')
                    .then(response => {
                        if(response.data.success == null || response.data.success != false) {
                            this.categories = response.data;
                        }
                    });
            },

            getDevelopers() {
                axios.get(window.laravel.app_url + '/api/v1/developers')
                    .then(response => {
                        if(response.data.success == null || response.data.success != false) {
                            this.developers = response.data;
                        }
                    });
            },

            getPackages(query) {
                axios.get(window.laravel.app_url + '/api/v1/packages-info/content')
                    .then(response => {
                        if(response.data.success == null || response.data.success != false) {
                            this.packages = response.data;
                            this.loading = false;
                        } else {
                            this.loading = false;
                            alert(response.data.message);
                        }
                    });
            },

            getIconPath(icon) {
                if(icon != "" && icon != null) {
                    return window.laravel.app_url + "/files/icons/" + icon;
                } else {
                    return window.laravel.app_url + "/images/no-icon.png";
                }
            },

            viewPackage(pkg) {
                var contents = this.plistParse(pkg.content);
                this.current_package = contents;
                $("#view-package-modal").modal();
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
