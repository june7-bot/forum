<template>
    <div>
        <div v-if="signedIn">
             <div class="form-group" style="width: 100%">
                            <textarea name="body"
                                      id="body"
                                      class="form-control"
                                      placeholder="Have something to say?"
                                      rows="5"
                                      required
                                      v-model="body">
                            </textarea>
            </div>
        <button type="submit" class="btn btn-link"  @click="addReply">Post</button>
    </div>
        <p class="text-center" v-else>
            Please <a href="/login">sign in</a> to participate this discussion
        </p>
    </div>
</template>

<script>
import Tribute from "tributejs";

    export default {

        data() {
            return{
                body:''
            }
        },
        computed: {
            signedIn(){
                return window.App.signedIn;
            }
        },

        mounted() {
            let tribute = new Tribute({
                // column to search against in the object (accepts function or string)
                lookup: 'value',
                // column that contains the content to insert by default
                fillAttr: 'value',
                values: function(query, cb) {
                    axios.get('/api/users', {params: {name: query}} )
                        .then(function(response){
                            console.log(response);
                            cb(response.data);
                        });
                },
            });
            tribute.attach(document.querySelectorAll("#body"));
        },

        methods:{
            addReply(){
                axios.post(location.pathname + '/replies', {body: this.body})
                    .catch(error => {
                        flash(error.response.data , 'danger');
                    })
                    .then(({data}) => {
                        this.body = '';
                        flash('Your reply has been posted.');

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>
