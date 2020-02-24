@push('css')
<style>
/* .gallery-item {
       position: relative;
    margin: 1.9rem;
    color: #fff;
    cursor: pointer;

} */
.gallery-item:hover  > .gallery-item-info {
	display: flex;
	justify-content: center;
	align-items: center;
	position: absolute;
	top: 0;
	/* width: 100%; */
	height: 100%;
	color: #fff;
	background-color: rgba(0, 0, 0, 0.3);
}
.gallery-item-info {
	display: none;
}
.gallery-item-info li {
    display: inline-block;
    font-size: 1.7rem; 
    font-weight: 600;
}
.gallery-item-likes {
	margin-right: 2.2rem;
}
.gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;

}
/* .gallery {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(22rem, 1fr));
	flex-wrap: wrap;
	padding-bottom: 3rem;
	
} */
.modal-lg{
	    max-width: 1270px;
}
.post-details{
	    position: relative;
    left: 73%;
    padding: 10px;
    margin-bottom: 36%;
    margin-top: -40%;
}
.profile-image-post{
	    width: 3%;
    height: 3%;
    border-radius: 25px;
}




#demo {
  height:100%;
  position:relative;
  overflow:hidden;
}


.green{
  background-color:#6fb936;
}
        .thumb{
            margin-bottom: 30px;
        }
        
        .page-top{
            margin-top:85px;
        }

   
img.zoom {
    width: 100%;
    height: 200px;
    border-radius:5px;
    object-fit:cover;
    -webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    -o-transition: all .3s ease-in-out;
    -ms-transition: all .3s ease-in-out;
}
        
 
.transition {
    -webkit-transform: scale(1.2); 
    -moz-transform: scale(1.2);
    -o-transform: scale(1.2);
    transform: scale(1.2);
}
    .modal-header {
   
     border-bottom: none;
}
    .modal-title {
        color:#000;
    }
    .modal-footer{
      display:none;  
    }

</style>
@endpush
<div class="container  page-top">
	<div class="row">
		
		@foreach ($user->postUser as $post)
{{-- 
		<div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter irrigation gallery-item">
			<img src="{{ asset('files/'.$post->photoPost[0]->photo) }}" class="img-responsive">
			<div class="gallery-item-info">
				<ul>
					<li class="gallery-item-likes"><i class="fas fa-heart"></i>
					
							{{ $post->countLike($post->id) }}
				
				</li>
					<li class="gallery-item-comments"><i class="fas fa-comment"></i>{{ count($post->commentPost) }} </li>
				</ul>
			</div>
		</div> --}}
				 <div class="col-lg-3 col-md-4 col-xs-6 thumb gallery-item">
					<a href="{{ asset('files/'.$post->photoPost[0]->photo) }}" class="fancybox" rel="ligthbox">
						<img  src="{{ asset('files/'.$post->photoPost[0]->photo) }}" class="zoom img-fluid "  alt="">
					</a>
					<div class="gallery-item-info">
						<ul>
							<li class="gallery-item-likes"><i class="fas fa-heart"></i>
							
									{{ $post->countLike($post->id) }}
						
						</li>
							<li class="gallery-item-comments"><i class="fas fa-comment"></i>{{ count($post->commentPost) }} </li>
						</ul>
					</div>
				</div>
				
			
		{{-- <div class="gallery-item" data-toggle="modal" data-target="#{{ md5($post->id) }}">
			
		<img class="gallery-image"  src="{{ asset('files/'.$post->photoPost[0]->photo) }}" alt="Card image">
			
			
			<div class="gallery-item-info">
				<ul>
					<li class="gallery-item-likes"><i class="fas fa-heart"></i>
					
							{{ $post->countLike($post->id) }}
				
				</li>
					<li class="gallery-item-comments"><i class="fas fa-comment"></i>{{ count($post->commentPost) }} </li>
				</ul>
			</div>
		</div> --}}


		@endforeach
		@if (count($user->postUser) == 0)
			<h2>No Posts Yet</h2>
		@endif
	</div>
</div>
@push('js')
	<script>
	$('.gallery-item-info').width($('.zoom').width());
		$(window).on('resize',function() {
			$('.gallery-item-info').width($('.zoom').width());
		});

	</script>
@endpush
    
