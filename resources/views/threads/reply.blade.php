
<reply :attributes="{{ $reply }}" inline-template>
    <div id="reply-{{ $reply->id }}" class="card" style="margin-bottom: 25px">
        <div class="card-header">
            <div class="level">
                <h4>
                <a href="{{ route('profile' , $reply->owner ) }}">
                    {{ $reply->owner->name }}
                </a> said {{ $reply->created_at->diffForHumans() }}...
                </h4>
                @auth()
                    <div>
                        <favorite :reply="{{ $reply }}"></favorite>
                    </div>
                @endauth

            </div>
        </div>
            <div class="card-body">

                <div v-if="editing">
                    <div class="form-group mb-3">
                        <textarea class="form-control" v-model="body"> </textarea>
                    </div>
                     <button class="btn btn-sm btn-primary" @click="update">Update</button>
                     <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
                </div>

                <div v-else v-text="body"> </div>

            @can('update' , $reply)
                <div class="card-footer" style="display:flex; justify-content: flex-end" >
                    <button class="btn btn-close-white btn-sm text-white" @click="editing = true"> Edit</button>
                    <button class="btn btn-close-white btn-sm text-white btn-danger" @click="destroy"> Delete</button>
                </div>
            @endcan
        </div>
    </div>

</reply>
