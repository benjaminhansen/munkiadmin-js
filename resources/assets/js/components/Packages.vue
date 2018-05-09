<template>
    <div>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <h5 class="card-header">Developers</h5>
                    <div class="card-body">
                        <div class="list-group">
                            <button type="button" class="list-group-item" v-for="developer in developers" @click="applyDeveloper(developer)">
                                <span class="fa fa-user"></span> {{ developer }}
                            </button>
                        </div>
                    </div>
                </div>
                <br />
                <div class="card">
                    <h5 class="card-header">Categories</h5>
                    <div class="card-body">
                        <div class="list-group">
                            <button type="button" class="list-group-item" v-for="category in categories" @click="applyCategory(category)">
                                <span class="fa fa-tag"></span> {{ category }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th></th><th>Name</th><th>Display Name</th><th>Version</th><th>Modified</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="pkg in packages" class="clickable-row" @click="viewPackage(pkg)">
                                <td>icon</td>
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
                categories:[],
                developers:[]
            };
        },

        methods: {
            prepare() {
                this.getPackages();
                this.getCategories();
                this.getDevelopers();
            },

            applyDeveloper(developer) {
                this.developer = developer;
                if(developer == "") {
                    this.getPackages();
                } else {
                    this.getPackages({ type:"developer", value:developer });
                }
            },

            applyCategory(category) {
                this.category = category;
                if(category == "") {
                    this.getPackages();
                } else {
                    this.getPackages({ type:"category", value:category });
                }
            },

            getCategories() {
                axios.get('/api/v1/categories')
                    .then(response => {
                        this.categories = response.data;
                    });
            },

            getDevelopers() {
                axios.get('/api/v1/developers')
                    .then(response => {
                        this.developers = response.data;
                    });
            },

            getPackages(query) {
                axios.get('/api/v1/packages-info/content')
                    .then(response => {
                        this.packages = response.data;
                    });
            },

            viewPackage(pkg) {
                var contents = this.plistParse(pkg.content);

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
