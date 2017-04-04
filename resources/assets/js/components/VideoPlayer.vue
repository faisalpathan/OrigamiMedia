<template>
	
	<video  
		id="video" 
		class="video-js vjs-default-skin vjs-big-play-centered vjs-16-9" 
		controls
		preload="auto" 
		data-setup='{"fluid" : true, "preload": "auto"}'
		v-bind:poster="thumbnailUrl">

		<source v-bind:src="videoUrl" type="video/mp4"> </source>
		
	</video>

</template>

<script>

	import videojs from "video.js";

	export default {

		data () {

			return {

				player:null,
				duration:null
			}
		},

		props: {

			videoUid:null,
			videoUrl:null,
			thumbnailUrl:null,
		},

		methods: {

			// yeh wale function mein check kiya hai ki quarter hit hua kya 
			hasHitQuotaView() {

				 if (!this.duration) {

				 	return false;
				 }

				 return Math.round(this.player.currentTime()) === Math.round((20 * this.duration) / 100) ;
			},

			createView()
			{
				this.$http.post('/videos/' + this.videoUid + '/views');
			}

		},

		ready () {

			this.player = videojs('video')

			//duration liya pure video ka pehle yaha se
			this.player.on('loadedmetadata', () => {

				this.duration = Math.round(this.player.duration());

			})

			//phit har second pe check quarter hit kiya hai kya matlab 10 % hit kiya hai
			//hua to view 
			setInterval( () => {

				if (this.hasHitQuotaView()) {
					this.createView();
				}

			},1000)
		} 

	}
	

</script>