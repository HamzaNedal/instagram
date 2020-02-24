      @php
      $count_carousel = 1;
      $count_comment = 1 ;
    @endphp

    @foreach ($posts as $post)

      @auth('web')
      {{-- {{ dd($posts) }} --}}
        @include('posts.home_with_auth')
        <?php $count_comment++;?>
      @endauth

      @guest('web')
        @include('posts.home_without_auth')
        <?php $count_comment++;?>
      @endguest

     @endforeach
