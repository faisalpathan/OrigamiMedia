<template>
		
		<div class="video__voting">

			<a href="#" class="video__voting-button"   v-bind:class="{'video__voting-button--voted': userVote == 'up'}"  @click.prevent="vote('up')"  >
				
				<span class="glyphicon glyphicon-thumbs-up"></span>

			</a>{{ up }} &nbsp;


			<a href="#" class="video__voting-button"  v-bind:class="{'video__voting-button--voted': userVote == 'down'}" @click.prevent="vote('down')"   >
            
				
				<span class="glyphicon glyphicon-thumbs-down"></span>

			</a> {{ down }}

		</div>

</template>


<script>

	export default {

		data () {

			return {

				up:null,
				down:null,
				userVote:null,
				canVote:false
			}

		},

		methods: {

			getVotes() {

				this.$http.get('/videos/' + this.videoUid + '/votes').then( (response) => {

					

					this.up = response.body.up;

					this.down = response.body.down;

					this.userVote = response.body.user_vote;

					this.canVote = response.body.can_vote;

					//console.log(response.body.up);
				});

			},
				/*yeh bolta hai bhai ki agar ek value save hai mere userVote variable mein aur uspe hi click kiya hai bhaisaheb se to wo type ko decrement kardena aur phir jo value hai wo kuch bhi nahi hogi kyuki do baar click kiya usne aur phir wo value function se controller mein pass kar update karneko

				agar tera userVote aya hai aur wo agar up hai toh down ko decrement kar aur agar wo up nahi hai to up ko decrement kar
				phir jo bhi type bacha is condition ke baad kyuki is condition mein ek toh decrement hone hi wala hai aur durse jo set hai abhi type var mein usko increment marna  hai phir function se controller mein pass karde
				*/

			vote (type) {

                if (this.userVote == type) {
                    this[type]--;
                    this.userVote = null;
                    this.deleteVote(type);
                    return;
                }
                if (this.userVote) {
                    this[type == 'up' ? 'down' : 'up']--;
                }
                this[type]++;
                this.userVote = type;
                this.createVote(type);
            },
            deleteVote (type) {
            	console.log('delete' + type);
                this.$http.delete('/videos/' + this.videoUid + '/votes');
            },
            createVote (type) {
            	console.log('create' + type);
                this.$http.post('/videos/' + this.videoUid + '/votes', {
                    type: type
                });
            }
        },	

		props : 
		
		{
			videoUid:null
		},

		ready () {

			this.getVotes()
		}


	}

</script>