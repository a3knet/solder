<template>
    <b-card header="Releases" class="solder-card">
        <table class="table w-100">
            <thead>
            <tr>
                <th>Version</th>
                <th>MD5</th>
                <th>Filesize</th>
                <th>Download</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tfoot v-if="rows.length == 0">
            <tr>
                <td colspan="4" class="text-center">There are no releases, get started by uploading one.</td>
            </tr>
            </tfoot>
            <tbody>
            <tr v-for="release in rows">
                <td>{{ release.version }}</td>
                <td><code>{{ release.md5 }}</code>
                </td>
                <td>{{ release.filesize | prettyBytes }}</td>
                <td>
                    <a :href="release.url">
                        {{ release.filename }}
                    </a>
                </td>
                <td class="text-right">
                    <a href='#' @click="destroy(release)" class="btn btn-small btn-danger">Remove</a>
                </td>
            </tr>
            </tbody>

        </table>
    </b-card>
</template>

<script>
    export default{
        props: ['releases', 'baseurl'],
        data(){
            return{
                rows: []
            }
        },
        mounted() {
            this.rows = this.releases;
        },
        methods: {
            destroy: function(release) {
                axios.delete(this.baseurl + '/releases/' + release.id)
                .then((response) => {
                    this.rows.splice(this.rows.indexOf(release), 1)
                })
                .catch((error) => {
                    console.log(error);
                });
            }
        }
    }
</script>
