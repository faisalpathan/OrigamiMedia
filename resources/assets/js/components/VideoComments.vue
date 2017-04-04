<template>
	
<p>{{ comments.length }} {{ comments.length | pluralize 'comment' }}</p>

	<div class="video-comment clearfix" v-if="$root.user.authenticated">
        <textarea placeholder="Say something" class="form-control video-comment__input" v-model="body"></textarea>
        <div class="pull-right">
            <button type="submit" class="btn btn-default" @click.prevent="createComment">Post</button>
        </div>
    </div>

	 <ul class="media-list">
        <li class="media" v-for="comment in comments">
            <div class="media-left">
                <a href="/channel/{{ comment.channel.data.slug }}">
                    <img :src="comment.channel.data.image" alt="{{ comment.channel.data.name }} image" class="media-object img-rounded">
                </a>
            </div>
    
            <div class="media-body">
                <a href="/channel/{{ comment.channel.data.slug }}">{{ comment.channel.data.name }}</a> {{ comment.created_at_human }}
                <p>{{ comment.body }}</p>

            <ul class="list-inline" v-if="$root.user.authenticated">
            	
            	<li>

            		<a href = "#" @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible === comment.id ? 'Cancel' : 'Reply' }}</a>

            	</li>

            	<li>

            		<a href="#" v-if="$root.user.id === comment.user_id" @click.prevent="deleteComment(comment.id)">Delete</a>

            	</li>

            </ul>


            <div class="video-comment clear" v-if="replyFormVisible === comment.id">

            	<textarea class="form-control video-comment__input" v-model="replyBody"></textarea>
            		<div class="pull-right">
            			<button type="submit" class="btn btn-default" @click.prevent="createReply(comment.id)">
            			Reply
            			</button>
            		</div>
            </div>


             <div class="media" v-for="reply in comment.replies.data">
                    <div class="media-left">
                        <a href="/channel/{{ reply.channel.data.slug }}">
                            <img :src="reply.channel.data.image" alt="{{ reply.channel.data.name }} image" class="media-object img-rounded">
                        </a>
                    </div>

                    <div class="media-body">
                        <a href="/channel/{{ reply.channel.data.slug }}">{{ reply.channel.data.name }}</a> {{ reply.created_at_human }}
                        <p>{{ reply.body }}</p>

                        <ul class="list-inline" v-if="$root.user.authenticated">
            	
            				<li>

            					<a href="#" v-if="$root.user.id === reply.user_id" @click.prevent="deleteComment(reply.id)">Delete</a>

            				</li>

            			</ul>

		            </div>
            </div>
 		</li>
 	</ul>
                

</template>

<script type="text/javascript">
	
export default {

	data () {
		return {

			comments : [],
			body:null,
			replyBody:null,
			replyFormVisible : null
		}
	},
	props:
	{
		videoUid: null
	},
	methods : {

		toggleReplyForm (commentId) {

			this.replyBody = null; // kyuki jab reply mein kuch likte hai aur phir koi aur reply pe click    karte hai toh wo same data retain karta hai usko nikal na hai isliye null karneka

			if(this.replyFormVisible === commentId) {
				this.replyFormVisible = null;
				return; // jaise hi submit kiya waise hi wo phirse null hojayega 
			}

			this.replyFormVisible = commentId;

		},

		createReply (commentId) {

			this.$http.post('/videos/'+this.videoUid + '/comments' , {

				body : this.replyBody,
				reply_id : commentId 

			}).then( (response) => {

				this.comments.map((comment , index) => { /*yeh map kya karta hai ki ek loop chalata hai ki usse pehle bhai isme seen kya hai ki jo bhi reply_id hai wo already saved hai tables mein comment mein toh reply id hi comment id hai agar wo null nahi hai simple aur yeh kya bolta hai map ka function ki comments ke array ko search karega pura aur jaise hi jo comment.id mila maltab ki jab apan reply karte hai toh wo rehta hai but hidden rehta hai aur refresh pe aata hai toh uske liye apan check karenge ki commment.id hai wo apna reply commentId hai usse match karra hai kya agar karra hai toh push karneka reply ko sabse last mein.*/
					if(comment.id === commentId) {
						this.comments[index].replies.data.push(response.body.data);
						return;
					}
				});

				this.replyBody = null;
				this.replyFormVisible = null;

			});

		},

		deleteComment (commentId) {

			if(!confirm('Are you sure you want to delete ? ')){
				return;
			}

			
			this.deleteById(commentId);

			this.$http.delete('/videos/' + this.videoUid + '/comments/' + commentId );
		},

		deleteById (commentId) {

			this.comments.map((comment,index) => {
				if(comment.id === commentId) {

					this.comments.splice(index,1);
					return;

				}

				comment.replies.data.map((reply , replyIndex) => {
					if(reply.id === commentId) {
						this.comments[index].replies.data.splice(replyIndex,1);
						return;
					}
				});

			
			});

		},

		createComment () {

			//console.log("send request");
			this.$http.post('/videos/'+this.videoUid + '/comments' , {

				body:this.body

			}).then( (response) => {

				//add comment to the list since it requires refresh to see to make it dynamic we do this
				this.comments.unshift(response.body.data); // yeh unshift sabse aage prepend kardega new data 
				//jo controller se aya hai shaaana hai !!!
				this.body = null;

			});
   
		},

		getComments () {
			this.$http.get('/videos/'+this.videoUid + '/comments').then( (response) => {
				//console.log(response.body.data);
				this.comments = response.body.data;
			});
		}
	},


	ready()
	{
		this.getComments();
	}

}


</script>