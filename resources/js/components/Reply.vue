<template>
    <div id="'reply-'+id" class="card" style="margin-bottom: 25px">
        <div class="card-header">
            <div class="level">
                <h4>
                    <a :href="'/profiles/'+ data.owner.name"
                    v-text="data.owner.name">
                    </a> said <span v-text="ago"></span>
                </h4>
                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div v-if="editing">
                <form @submit="update">
                    <div class="form-group mb-3">
                        <textarea class="form-control" v-model="body" required> </textarea>
                    </div>
                    <button class="btn btn-sm btn-primary">Update</button>
                    <button class="btn btn-sm btn-link" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>

            <div v-else v-html="body"> </div>

            <div class="card-footer" style="display:flex; justify-content: flex-end" v-if="canUpdate">
                <button class="btn btn-close-white btn-sm text-white" @click="editing = true"> Edit</button>
                <button class="btn btn-close-white btn-sm text-white btn-danger" @click="destroy"> Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Favorite from "./Favorite.vue";
    import moment from 'moment';
    export default {
        props: ['data'],

        components: { Favorite },

        data(){
            return{
                editing: false,
                id: this.data.id,
                body: this.data.body
            };
        },
        computed: {
            ago() {
                return moment(this.data.created_at).fromNow() + '...';
            },

            signedIn(){
                return window.App.signedIn;
            },

            canUpdate(){
               return  this.authorize(user => this.data.user_id == user.id);
            }
        },
        methods:{
            update(){
                axios.patch('/replies/' + this.data.id,{
                    body: this.body
                }).catch(error => {
                    flash(error.response.data, 'danger');
                })

                this.editing = false;

                flash('Updated');
            },

            destroy(){
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id);
            }
        }
    }
</script>
