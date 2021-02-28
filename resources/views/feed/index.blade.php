@extends('layouts.appnew')
@section('content') 

<div class="main new-theme feed-page-main">
  <div class="card-header ">
    <div class="titleText">
      <h3 class="mb-0">Message Board</h3>
    </div>
  </div>
  <section class="feed-main-wrap">
    <div class="feed-wrap">
      <div class="create-post-wrap">
        <h2>Choose Online Concierge</h2>
        <div class="write-post">
          <ul class="concierge-list">
            @if(isset($onlineConcierges))
            @foreach($onlineConcierges as $onlineConcierge)
            <li onclick="setConcierge({{ $onlineConcierge['id'] }})" id="conlist" class="active active_{{ $onlineConcierge['id'] }}">{{ $onlineConcierge['name'] }} <span id="online" style="color: green;"><i class="fas fa-circle"></i></span></li>
            @endforeach
            @endif

            @if(isset($offlineConcierges))
            @foreach($offlineConcierges as $offlineConcierge)
            <li>{{ $offlineConcierge['name'] }} <span id="offline"><i class="fas fa-circle"></i></span></li>
            @endforeach
            @endif
          </ul>
        </div>
      </div>
      <div class="create-post-wrap">
        <h2>Create Post</h2>
        <div class="write-post">
          <div class="pro_img" id="default">
            <img src="{{ asset('public/front/images/male.jpg') }}" alt="thum">
          </div>
          <div class="pro_img" id="uploaded" style="display: none;">
            <span id="showimage"></span>
          </div>
          <form method="post" id="upload_status_form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <textarea placeholder="Write something here..." name="description" id="user_status"></textarea>
            <div id="post_image_div"></div>
            <div id="status-error" class="custom-container status-error" style="color:red;"></div>
            <div id="preview_gallery"></div>
            <div class="btn-wrap">
              <label class="custom-file">
                <input type="file" name="user_feed_image[]" id="user_feed_image" class="custom-file-input" onchange="javascript:updateList()" multiple>
                <span class="custom-file-control">Choose file</span>
              </label>
              <button type="submit" class="btn" id="status_update_btn">Post</button>
            </div>
          </form>
        </div>
      </div>
      @foreach($feeds as $key => $feed)
      @if(isset($feed->description) && $feed->properties == '')
      <div class="feed-post" id="feed_div_{{ $feed->feed_id }}">
        <div class="pro-detail">
          <div class="pro_img">
            @if(isset($feed->member_image) && $feed->member_image!='' && file_exists(public_path('front/member_image/').$feed->member_image))
            <img src="{{ asset('public/front/member_image/'.$feed->member_image.'') }}" alt="profile-pic" id="profile_img">
            @else
            <img src="{{ asset('public/front/images/male.jpg') }}" alt="profile-pic" id="profile_img">
            @endif
          </div>
          <div class="pro_name">
            <h3>{!! $feed->first_name !!} {!! $feed->last_name !!}</h3>
            <span class="date-time">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($feed->created_at))->diffForHumans() }}</span>
            @if(isset($appUsersId->id))
            @if($feed->user_id == $appUsersId->id)
            <div class="open-action-box" onclick="openActionBox('{{ $feed->feed_id }}')">
              <span>···</span>
              <div class="action-box action-box_{{ $feed->feed_id }}" style="display: none;">
                <a href="javascript:;" onclick="editPost('{{ $feed->feed_id }}')">Edit</a>
                <a href="javascript:;" onclick="deletePostModal('{{ $feed->feed_id }}')">Delete</a>
              </div>
            </div>
            @endif
            @endif
          </div>
        </div>
        <div class="post_wrap">
          <p>{!! $feed->description !!}</p>
        </div>
        <div class="like_here">
          <div class="like-comment">
            @if(userPostLike($feed->feed_id))
            <span class="icon like_icon_{{ $feed->feed_id }}" onclick="disLikePost('{{ $feed->feed_id }}')">
              <i class="fas fa-heart"></i>
            </span>
            @else
            <span class="icon like_icon_{{ $feed->feed_id }}" onclick="likePost('{{ $feed->feed_id }}')">
              <i class="far fa-heart"></i>
            </span>
            @endif
            <span id="like_count_{{ $feed->feed_id }}">{{ userPostLikeCount($feed->feed_id) }}</span>
          </div>
          <div class="like-comment">
            <span class="icon comment_icon_{{ $feed->feed_id }}" onclick="openCommentBox('{{ $feed->feed_id }}')">
              <i class="far fa-comment-dots"></i>
            </span>
            <span>{{ userPostCommentCount($feed->feed_id) }}</span>
          </div>
        </div>
        <div class="comment_wrap comment-box_{{ $feed->feed_id }}" style="display: none;margin-top: 10px;">
          <div class="comment-wrapper">
            <div class="panel panel-info">
              <div class="panel-body">
                <ul class="media-list_{{ $feed->feed_id }}">
                  @if(userPostComments($feed->feed_id) && count(userPostComments($feed->feed_id))>0)
                  @foreach(userPostComments($feed->feed_id) as $comment)
                  @if(isset($comment->commentOwner))
                  <li class="media" id="comment_li_{{ $comment->id }}">
                    <a href="#" class="pull-left">
                      @if(isset($comment->commentOwner->member_image) && $comment->commentOwner->member_image!='')
                      <img src="{{ asset('public/front/member_image/'.$comment->commentOwner->member_image.'') }}" alt="profile-pic"
                      id="profile_img" width="80" height="80">
                      @else
                      <img src="{{ asset('public/front/images/male.jpg') }}" alt="profile-pic" id="profile_img" width="80"
                      height="80">
                      @endif
                    </a>
                    <div class="media-body">
                      <strong>{{ $comment->commentOwner->first_name }} {{ $comment->commentOwner->last_name }}</strong>
                      <p>{!! $comment->comment !!}</p>
                      <span class="text-muted pull-right">
                        @php
                        $diff = $comment->created_at->diffForHumans();
                        @endphp
                        <small class="text-muted">{{ $diff }}</small>
                      </span>
                    </div>
                    @if(Auth::user() && $comment->commentOwner->id==Auth::user()->id)
                    <div class="open-action-box" onclick="openActionBox('{{ $comment->id }}')">
                      <span>···</span>
                      <div class="action-box action-box_{{ $comment->id }}" style="display: none;">
                        <a href="javascript:;" onclick="deletePostComment('{{ $comment->id }}')">Delete</a>
                      </div>
                    </div>
                    @endif
                  </li>
                  @endif
                  @endforeach
                  @endif
                </ul>
              </div>
            </div>
          </div>
          <form>
            <textarea placeholder="Write your comment here..." id="comment_{{ $feed->feed_id }}"></textarea>
            <div class="comment-error_{{ $feed->feed_id }}" style="color:red;margin-bottom: 10px;"></div>
            <div class="btn-wrap">
              <button class="btn" id="comment_btn" onclick="postComment('{{ $feed->feed_id }}')">Comment</button>
            </div>
          </form>
        </div>
      </div>
      @elseif(isset($feed->description) && isset($feed->properties))
      <div class="feed-post commented" id="feed_div_{{ $feed->feed_id }}">
        <div class="pro-detail">
          <div class="pro_img">
            @if(isset($feed->member_image) && $feed->member_image!='' && file_exists(public_path('front/member_image/').$feed->member_image))
            <img src="{{ asset('public/front/member_image/'.$feed->member_image.'') }}" alt="profile-pic" id="profile_img">
            @else
            <img src="{{ asset('public/front/images/male.jpg') }}" alt="profile-pic" id="profile_img">
            @endif
          </div>
          <div class="pro_name">
            <h3>{!! $feed->first_name !!} {!! $feed->last_name !!}</h3>
            <span class="date-time">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($feed->created_at))->diffForHumans() }}</span>
            @if(isset($appUsersId->id))
            @if($feed->user_id == $appUsersId->id)
            <div class="open-action-box" onclick="openActionBox('{{ $feed->feed_id }}')">
              <span>···</span>
              <div class="action-box action-box_{{ $feed->feed_id }}" style="display: none;">
                {{-- <a href="javascript:;" onclick="editPost('{{ $feed->feed_id }}')">Edit</a> --}}
                <a href="javascript:;" onclick="editPhotoPost('{{ $feed->feed_id }}')">Edit</a>
                <a href="javascript:;" onclick="deletePostModal('{{ $feed->feed_id }}')">Delete</a>
              </div>
            </div>
            @endif
            @endif
          </div>
        </div>
        <div class="post_wrap">
          <p>{!! $feed->description !!}</p>
        </div>
        <div class="post_wrap">
          @php
          $json_decode_images = json_decode($feed->properties);
          @endphp
          @if(!empty($json_decode_images->image))
          @if(count($json_decode_images->image) == 1)
          <div class="single-img">
            @foreach($json_decode_images->image as $json_decode_image)
            @if(isset($json_decode_image))
            <a href="{{ asset('public/front/feed_images/') }}/{{$json_decode_image}}" class="fancybox" rel="single-group{{$feed->id}}{{$feed->description}}">
              <img src="{{ asset('public/front/feed_images/') }}/{{$json_decode_image}}" alt="models-bg">
            </a>
            @endif
            @endforeach
          </div>
          @endif

          @if(count($json_decode_images->image) == 2)
          <div class="double-img">
            @foreach($json_decode_images->image as $json_decode_image)
            @if(isset($json_decode_image))
            <a href="{{ asset('public/front/feed_images/') }}/{{$json_decode_image}}" class="fancybox" rel="double-group{{$feed->id}}{{$feed->description}}">
              <img src="{{ asset('public/front/feed_images/') }}/{{$json_decode_image}}" alt="models-bg">
            </a>
            @endif
            @endforeach
          </div>
          @endif

          @if(count($json_decode_images->image) > 2)
          <div class="multiple-img">
            @foreach($json_decode_images->image as $json_decode_image)
            @if(isset($json_decode_image))
            <a href="{{ asset('public/front/feed_images/') }}/{{$json_decode_image}}" class="fancybox" rel="multiple-group{{$feed->id}}{{$feed->description}}">
              <img src="{{ asset('public/front/feed_images/') }}/{{$json_decode_image}}" alt="models-bg">
            </a>
            @endif
            @endforeach
          </div>
          @endif

          @endif
        </div>
        <div class="like_here">
          <div class="like-comment">
            @if(userPostLike($feed->feed_id))
            <span class="icon like_icon_{{ $feed->feed_id }}" onclick="disLikePost('{{ $feed->feed_id }}')">
              <i class="fas fa-heart"></i>
            </span>
            @else
            <span class="icon like_icon_{{ $feed->feed_id }}" onclick="likePost('{{ $feed->feed_id }}')">
              <i class="far fa-heart"></i>
            </span>
            @endif
            <span id="like_count_{{ $feed->feed_id }}">{{ userPostLikeCount($feed->feed_id) }}</span>
          </div>
          <div class="like-comment">
            <span class="icon comment_icon_{{ $feed->feed_id }}" onclick="openCommentBox('{{ $feed->feed_id }}')">
              <i class="far fa-comment-dots"></i>
            </span>
            <span>{{ userPostCommentCount($feed->feed_id) }}</span>
          </div>
        </div>
        <div class="comment_wrap comment-box_{{ $feed->feed_id }}" style="display: none;margin-top: 10px;">
          <div class="comment-wrapper">
            <div class="panel panel-info">
              <div class="panel-body">
                <ul class="media-list_{{ $feed->feed_id }}">
                  @if(userPostComments($feed->feed_id) && count(userPostComments($feed->feed_id))>0)
                  @foreach(userPostComments($feed->feed_id) as $comment)
                  @if(isset($comment->commentOwner))
                  <li class="media" id="comment_li_{{ $comment->id }}">
                    <a href="#" class="pull-left">
                      @if(isset($comment->commentOwner->member_image) && $comment->commentOwner->member_image!='')
                      <img src="{{ asset('public/front/member_image/'.$comment->commentOwner->member_image.'') }}" alt="profile-pic"
                      id="profile_img" width="80" height="80">
                      @else
                      <img src="{{ asset('public/front/images/male.jpg') }}" alt="profile-pic" id="profile_img" width="80"
                      height="80">
                      @endif
                    </a>
                    <div class="media-body">
                      <strong>{{ $comment->commentOwner->first_name }} {{ $comment->commentOwner->last_name }}</strong>
                      <p>{!! $comment->comment !!}</p>
                      <span class="text-muted pull-right">
                        @php
                        $diff = $comment->created_at->diffForHumans();
                        @endphp
                        <small class="text-muted">{{ $diff }}</small>
                      </span>
                    </div>
                    @if(Auth::user() && $comment->commentOwner->id==Auth::user()->id)
                    <div class="open-action-box" onclick="openActionBox('{{ $comment->id }}')">
                      <span>···</span>
                      <div class="action-box action-box_{{ $comment->id }}" style="display: none;">
                        <a href="javascript:;" onclick="deletePostComment('{{ $comment->id }}')">Delete</a>
                      </div>
                    </div>
                    @endif
                  </li>
                  @endif
                  @endforeach
                  @endif
                </ul>
              </div>
            </div>
          </div>
          <form>
            <textarea placeholder="Write your comment here..." id="comment_{{ $feed->feed_id }}"></textarea>
            <div class="comment-error_{{ $feed->feed_id }}" style="color:red;margin-bottom: 10px;"></div>
            <div class="btn-wrap">
              <button class="btn" id="comment_btn" onclick="postComment('{{ $feed->feed_id }}')">Comment</button>
            </div>
          </form>
        </div>
      </div>
      @else
      <div class="feed-post commented" id="feed_div_{{ $feed->feed_id }}">
        <div class="pro-detail">
          <div class="pro_img">
            @if(isset($feed->member_image) && $feed->member_image!='' && file_exists(public_path('front/member_image/').$feed->member_image))
            <img src="{{ asset('public/front/member_image/'.$feed->member_image.'') }}" alt="profile-pic" id="profile_img">
            @else
            <img src="{{ asset('public/front/images/male.jpg') }}" alt="profile-pic" id="profile_img">
            @endif
          </div>
          <div class="pro_name">
            <h3>{!! $feed->first_name !!} {!! $feed->last_name !!}</h3>
            <span class="date-time">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($feed->created_at))->diffForHumans() }}</span>
            @if(isset($appUsersId->id))
            @if($feed->user_id == $appUsersId->id)
            <div class="open-action-box" onclick="openActionBox('{{ $feed->feed_id }}')">
              <span>···</span>
              <div class="action-box action-box_{{ $feed->feed_id }}" style="display: none;">
                <a href="javascript:;" onclick="editPhotoPost('{{ $feed->feed_id }}')">Edit</a>
                <a href="javascript:;" onclick="deletePostModal('{{ $feed->feed_id }}')">Delete</a>
              </div>
            </div>
            @endif
            @endif
          </div>
        </div>
        <div class="post_wrap">
          @php
          $json_decode_images = json_decode($feed->properties);
          @endphp
          @if(!empty($json_decode_images->image))
          @if(count($json_decode_images->image) == 1)
          <div class="single-img">
            @foreach($json_decode_images->image as $json_decode_image)
            @if(isset($json_decode_image))
            <a href="{{ asset('public/front/feed_images/') }}/{{$json_decode_image}}" class="fancybox" rel="onlysingle-group{{$key}}">
              <img src="{{ asset('public/front/feed_images/') }}/{{$json_decode_image}}" alt="models-bg">
            </a>
            @endif
            @endforeach
          </div>
          @endif

          @if(count($json_decode_images->image) == 2)
          <div class="double-img">
            @foreach($json_decode_images->image as $json_decode_image)
            @if(isset($json_decode_image))
            <a href="{{ asset('public/front/feed_images/') }}/{{$json_decode_image}}" class="fancybox" rel="onlydouble-group{{$key}}">
              <img src="{{ asset('public/front/feed_images/') }}/{{$json_decode_image}}" alt="models-bg">
            </a>
            @endif
            @endforeach
          </div>
          @endif

          @if(count($json_decode_images->image) > 2)
          <div class="multiple-img">
            @foreach($json_decode_images->image as $json_decode_image)
            @if(isset($json_decode_image))
            <a href="{{ asset('public/front/feed_images/') }}/{{$json_decode_image}}" class="fancybox" rel="onlymultiple-group{{$key}}">
              <img src="{{ asset('public/front/feed_images/') }}/{{$json_decode_image}}" alt="models-bg">
              @endif
            </a>
            @endforeach
          </div>
          @endif

          @endif
        </div>
        <div class="like_here">
          <div class="like-comment">
            @if(userPostLike($feed->feed_id))
            <span class="icon like_icon_{{ $feed->feed_id }}" onclick="disLikePost('{{ $feed->feed_id }}')">
              <i class="fas fa-heart"></i>
            </span>
            @else
            <span class="icon like_icon_{{ $feed->feed_id }}" onclick="likePost('{{ $feed->feed_id }}')">
              <i class="far fa-heart"></i>
            </span>
            @endif
            <span id="like_count_{{ $feed->feed_id }}">{{ userPostLikeCount($feed->feed_id) }}</span>
          </div>
          <div class="like-comment">
            <span class="icon comment_icon_{{ $feed->feed_id }}" onclick="openCommentBox('{{ $feed->feed_id }}')">
              <i class="far fa-comment-dots"></i>
            </span>
            <span>{{ userPostCommentCount($feed->feed_id) }}</span>
          </div>
        </div>
        <div class="comment_wrap comment-box_{{ $feed->feed_id }}" style="display: none;margin-top: 10px;">
          <div class="comment-wrapper">
            <div class="panel panel-info">
              <div class="panel-body">
                <ul class="media-list_{{ $feed->feed_id }}">
                  @if(userPostComments($feed->feed_id) && count(userPostComments($feed->feed_id))>0)
                  @foreach(userPostComments($feed->feed_id) as $comment)
                  @if(isset($comment->commentOwner))
                  <li class="media" id="comment_li_{{ $comment->id }}">
                    <a href="#" class="pull-left">
                      @if(isset($comment->commentOwner->member_image) && $comment->commentOwner->member_image!='')
                      <img src="{{ asset('public/front/member_image/'.$comment->commentOwner->member_image.'') }}" alt="profile-pic"
                      id="profile_img" width="80" height="80">
                      @else
                      <img src="{{ asset('public/front/images/male.jpg') }}" alt="profile-pic" id="profile_img" width="80"
                      height="80">
                      @endif
                    </a>
                    <div class="media-body">
                      <strong>{{ $comment->commentOwner->first_name }} {{ $comment->commentOwner->last_name }}</strong>
                      <p>{!! $comment->comment !!}</p>
                      <span class="text-muted pull-right">
                        @php
                        $diff = $comment->created_at->diffForHumans();
                        @endphp
                        <small class="text-muted">{{ $diff }}</small>
                      </span>
                    </div>
                    @if(isset($appUsersId->id))

                    @if($comment->user_id == $appUsersId->id)
                    <div class="open-action-box" onclick="openActionBox('{{ $comment->id }}')">
                      <span>···</span>
                      <div class="action-box action-box_{{ $comment->id }}" style="display: none;">
                        <a href="javascript:;" onclick="deletePostComment('{{ $comment->id }}')">Delete</a>
                      </div>
                    </div>
                    @endif
                    @endif
                  </li>
                  @endif
                  @endforeach
                  @endif
                </ul>
              </div>
            </div>
          </div>
          <form>
            <textarea placeholder="Write your comment here..." id="comment_{{ $feed->feed_id }}"></textarea>
            <div class="comment-error_{{ $feed->feed_id }}" style="color:red;margin-bottom: 10px;"></div>
            <div class="btn-wrap">
              <button class="btn" id="comment_btn" onclick="postComment('{{ $feed->feed_id }}')">Comment</button>
            </div>
          </form>
        </div>
      </div>
      @endif
      @endforeach

      <div id="user_feed">
        {{-- @include('user.feed_part') --}}
      </div>
      <div id="empty-feed" style="text-align: center;margin-top: 20px;"></div>
    </div>
  </section>
</div>
@endsection

@push('js')

<div class="modal fade profile-contact-form" id="editPostCenter" tabindex="-1" role="dialog" aria-labelledby="editPostCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPostCenterTitle">Edit Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-errors"></div>
        <form id="status_form" method="post">
          <div class="custom-container status-edit-error" style="color:red;"></div>
          @if(isset($appUsersId->id))
          <input type="hidden" id="feed_id" name="feed_id" value="{{ $appUsersId->id }}">
          @endif
          <div class="form-item">
            <textarea id="feed_message" name="feed" placeholder="Write something here..."></textarea>
          </div>
          <div id="image_div"></div>
          <br/>
          <div class="form-action">
            <button class="btn" type="button" id="status_edit_btn">Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade profile-contact-form" id="editPhotoCenter" tabindex="-1" role="dialog" aria-labelledby="editPhotoCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPhotoCenterTitle">Edit Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-errors"></div>
        <form id="upload_status_form_demo" enctype="multipart/form-data" method="post">
          {{ csrf_field() }}
          <div class="custom-container status-edit-error" style="color:red;"></div>
          @if(isset($appUsersId->id))
          <input type="hidden" id="feed_id" name="feed_id" value="{{ $appUsersId->id }}">
          @endif
          <input type="hidden" id="simple_id" name="simple_id" value="">
          {{-- <textarea id="feed_message" name="feed" placeholder="Write something here..."></textarea> --}}
          <textarea placeholder="Write something here..." name="description" id="feed_message_id"></textarea>
          <div id="image_div_image"></div>
          <br/>
          <div class="btn-wrap">
            <label class="custom-file">
              <input type="file" name="user_feed_image[]" id="user_feed_image" class="custom-file-input" multiple>
              <span class="custom-file-control">Choose file</span>
            </label>
            <button type="submit" class="btn" id="upload_status">Post</button>
            <div class="btn" id="confirm-btn">Confirm</div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade show" id="deletePostModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete Post</h4>
      </div>
      <div class="modal-body">
        Are you sure you want delete this post ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-small cancle-membership" data-dismiss="modal">Go Back</button>
        <button type="button" class="btn btn-small cancle-membership" id="delete-post-btn">Yes I’m Sure</button>
      </div>
    </div>
  </div>
</div>

<script>

  var config = {
    routes: {
      comment_route: '{{ route('post.comment') }}',
      like_route: '{{ route('like.post') }}',
      dis_like_route: '{{ route('dis.like.post') }}',
      delete_post_route: '{{ route('delete.post') }}',
      delete_post_comment_route: '{{ route('delete.post.comment') }}',
      get_post_route: '{{ route('get.post') }}',
      update_post_route: '{{ route('update.post') }}',
      get_Delete_Image_route: '{{ route('delete.images') }}',
      feed_image_route: '{{ asset('public/front/feed_images/') }}/',
    }
  };
</script>
<script type="text/javascript" src="{{ asset('public/front/js/feed.js') }}"></script>

<link type="text/css" rel="stylesheet" target="_blank" href="//cdn.jsdelivr.net/fancybox/2.1.5/helpers/jquery.fancybox-buttons.css" />

<script type="text/javascript" src="//cdn.jsdelivr.net/fancybox/2.1.5/helpers/jquery.fancybox-buttons.js"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/fancybox/2.1.5/helpers/jquery.fancybox-media.js"></script>

<link type="text/css" rel="stylesheet" target="_blank" href="//cdn.jsdelivr.net/fancybox/2.1.5/helpers/jquery.fancybox-thumbs.css" />

<script type="text/javascript" src="//cdn.jsdelivr.net/fancybox/2.1.5/helpers/jquery.fancybox-thumbs.js"></script>

<link type="text/css" rel="stylesheet" target="_blank" href="//cdn.jsdelivr.net/fancybox/2.1.5/jquery.fancybox.css" />

<script type="text/javascript" src="//cdn.jsdelivr.net/fancybox/2.1.5/jquery.fancybox.js"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/fancybox/2.1.5/jquery.fancybox.pack.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $(".fancybox").fancybox();
    
    updateList = function() {
      var input = document.getElementById('user_feed_image');
      var output = document.getElementById('preview_gallery');
      var children = "";
      for (var i = 0; i < input.files.length; ++i) {
        children += '<li>' + input.files.item(i).name + '</li>';
      }
      output.innerHTML = '<ul>'+children+'</ul>';
    }
  });
  
</script>

<script>
  function setConcierge(concierge_id)
  {
    $('.active').css('color','');
    $('.active_'+concierge_id).css('color','');
    $('.active_'+concierge_id).css('color','#FEA857');

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '{{ route('getconcierges') }}',
      type: 'POST',
      dataType: 'json',
      data: {
        concierge_id: concierge_id,
      },
    })
    .done(function (res) {
      $('#loading').hide();
      if (res.status == true) 
      {
        console.log(res.data);
        $('#default').css('display','none');
        $('#uploaded').css('display','');
        $('#showimage').html('');
        $('#showimage').html('<image src="'+res.image+'">');
      }
      else
      {
        
      }
    });

  }

  $('#upload_status_form').on('submit', function (event) {
    event.preventDefault();
    $('.status-error').html('');
    $('#loading').show();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '{{ route('add.user.status') }}',
      type: 'POST',
      dataType: 'JSON',
      contentType: false,
      cache: false,
      processData: false,
      data: new FormData(this),
    })
    .done(function (res) {
      $('#loading').hide();
      if (res.status == false) {
        var errorString = '<ul>';
        $.each(res.msg, function (key, value) {
          errorString += '<li>' + value + '</li>';
        });
        errorString += '</ul>';
        console.log(res.msg);
        $('.status-error').html('');
        $('.status-error').html('<div class="alert alert-danger">' + errorString + '</div>');
        $('#user_status').focus();

      } else if(res.status == 'nocon') 
      {
        $('#post_image_div').html('');
        $('#post_image_div').html('<div class="alert alert-danger">' + res.msg + '</div>');
      }
      else
      {
        location.reload();
        $('#user_status').val('');
        $('#no-fedd').html('');
        $('#post_image_div').html('');
      }
    });
  });


  $(document).on('click','.deleteImage',function(post_id,image_name){
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: config.routes.get_Delete_Image_route,
      type: 'POST',
      dataType: 'json',
      data: {
        post_id: $(this).data("post_id"),
        image_name: $(this).data("image_name"),
        delete_id: $(this).data("delete_id"),
      },
    }).done(function(res) {
      $('.deletepic'+res.delete).remove();
    });
  });


  $('#upload_status_form_demo').on('submit', function (event) {
    event.preventDefault();
    $('.status-error').html('');
    $('#loading').show();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '{{ route('add.user.status') }}',
      type: 'POST',
      dataType: 'JSON',
      contentType: false,
      cache: false,
      processData: false,
      data: new FormData(this),
    })
    .done(function (res) {
      $('#loading').hide();
      if (res.status == false) {
        var errorString = '<ul>';
        $.each(res.msg, function (key, value) {
          errorString += '<li>' + value + '</li>';
        });
        errorString += '</ul>';
        console.log(res.msg);
        $('.status-error').html('');
        $('.status-error').html('<div class="alert alert-danger">' + errorString + '</div>');
        $('#user_status').focus();

      } else if(res.status == 'nocon') 
      {
        $('#post_image_div').html('');
        $('#post_image_div').html('<div class="alert alert-danger">' + res.msg + '</div>');
      }
      else
      {
        location.reload();
        $('#user_feed').prepend(feed);
        $('#user_status').val('');
        $('#no-fedd').html('');
        $('#post_image_div').html('');
      }
    });
  });

  $('#confirm-btn').click(function(){
    location.reload();
  }); 

</script>

@endpush