<div>

    <x-frontend.navbar :header="$header" :homeTitle="$homeTitle" :menus="$menus" :general="$general" />

        @if ( $page->type == '404' )
        
          <x-frontend.404 :pageTrans="$pageTrans" />
          
        @elseif ( $page->type == 'login' )

          <section>
            <div class="page-header min-vh-100">
              <div class="container">
                <div class="row">
                  <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                    <div class="card card-plain">
                      <div class="card-header pb-0 text-start">
                        <h4 class="font-weight-bolder">{{ __('Sign In') }}</h4>
                        <p class="mb-0">{{ __('Enter your email and password to sign in') }}</p>
                      </div>

                      <div class="card-body">

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                        <form wire:submit.prevent="onLogin">
              
                          <div class="mb-3">
                            <input class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="{{ __('Email') }}" type="email" wire:model="email" required autofocus />
                          </div>
                          <div class="mb-3">
                            <input class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" type="password" wire:model="password" required />
                          </div>
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model="remember_me" id="remember_me">
                            <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                          </div>
                          <div class="text-center">
                            <button class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">
                              <div wire:loading wire:target="onLogin">
                                <x-loading />
                              </div>
                              {{ __('Sign In') }}</button>
                          </div>
                        </form>

                      </div>
                    </div>
                  </div>

                  <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                    <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center">
                      <img src="{{ asset('assets/img/shapes/pattern-lines.svg') }}" alt="pattern-lines" class="position-absolute opacity-4 start-0">
                      <div class="position-relative">
                        <img class="max-width-500 w-100 position-relative z-index-2" src="{{ asset('assets/img/illustrations/chat.png') }}">
                      </div>
                      <h4 class="mt-5 text-white font-weight-bolder">{{ __('Welcome back!') }}</h4>
                      <p class="text-white">{{ __('Login with your email address and password to keep connected with us.') }}</p>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </section>
      
        @else

          <header class="header-2">

            <div class="page-header min-vh-75 relative">
                <div class="img-fluid shadow overlay-preview" style="
                  @if ( $general->overlay_type == 'solid' )

                  background: {{ $general->solid_color }};opacity: {{ $general->opacity }};

                  @elseif( $general->overlay_type == 'gradient' )

                  background: {{ $general->gradient_first_color }};
                  background: -moz-linear-gradient( {{ $general->gradient_position }}, {{ $general->gradient_first_color }}, {{ $general->gradient_second_color }}  );
                  background: -webkit-linear-gradient( {{ $general->gradient_position }}, {{ $general->gradient_first_color }}, {{ $general->gradient_second_color }} );
                  background: linear-gradient( {{ $general->gradient_position }}, {{ $general->gradient_first_color }}, {{ $general->gradient_second_color }} );
                  opacity: {{ $general->opacity }};

                  @endif

                "></div>

              @if ( !empty($general->parallax_image) )
                <img class="position-absolute start-0 top-0 w-100 parallax-image" src="{{ $general->parallax_image }}" alt="Parallax Image" style="filter: blur({{ $general->blur }}px);">
              @else
                <img class="position-absolute start-0 top-0 w-100 parallax-image" src="{{ asset('assets/img/home-background.jpg') }}" alt="Parallax Image" style="filter: blur({{ $general->blur }}px);">
              @endif
              
              <div class="container">
                <div class="row">

                  <div class="col-lg-7 text-center mx-auto">
                    <h1 class="text-white pt-3 mt-n5">{{ __($pageTrans->title) }}</h1>
                    <h2 class="lead text-white letter-normal my-3">{{ __($pageTrans->subtitle) }}</h2>
                  </div>

                  @if ( $advertisement->area1_status == true && $advertisement->area1 != null )
                    <x-frontend.advertisement.area1 :advertisement="$advertisement" />
                  @endif

                  @if ( $page->type == 'downloader' || $page->type == 'home' )

                    <form wire:submit.prevent="onDownload" id="formDownload">

                      <div class="col-lg-8 z-index-2 border-radius-xl mx-auto py-3">

                        <div class="row bg-white shadow border-radius-md py-3 p-2 position-relative">
                          <div class="col-12 col-lg-10 mb-lg-0 mb-2">
                            <div class="input-group">
                              <input type="text" class="form-control form-control-lg" wire:model="link" placeholder="{{ __('Paste the URL here to start downloading...') }}" required>
                            </div>
                          </div>

                          <div class="col-12 col-lg-2 ps-lg-0">
                            <button class="btn bg-gradient-primary w-100 mb-0 h-100 position-relative z-index-2 p-lg-0">
                              <span>
                                <div wire:loading.inline wire:target="onDownload">
                                  <x-loading />
                                </div>
                                <span wire:loading.remove wire:target="onDownload" class="text-capitalize btn-download">{{ __('Download') }}</span>
                              </span>
                            </button>
                          </div>
                        </div>

                      </div>
                    </form>

                    <div class="text-center h-0" wire:loading wire:target="onDownload">
                        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-8 mx-auto">

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                      </div>
                    </div>

                   @endif

                  @if ( $advertisement->area2_status == true && $advertisement->area2 != null )
                    <x-frontend.advertisement.area2 :advertisement="$advertisement" />
                  @endif

                </div>
              </div>

              @if ( $general->wave_animation_status == true)

                <div class="position-absolute w-100 z-index-1 bottom-0">
                  <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 40" preserveAspectRatio="none" shape-rendering="auto">
                    <defs>
                      <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                    </defs>
                    <g class="moving-waves">
                      <use xlink:href="#gentle-wave" x="48" y="-1" fill="rgba(255,255,255,0.40" />
                      <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.35)" />
                      <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.25)" />
                      <use xlink:href="#gentle-wave" x="48" y="8" fill="rgba(255,255,255,0.20)" />
                      <use xlink:href="#gentle-wave" x="48" y="13" fill="rgba(255,255,255,0.15)" />
                      <use xlink:href="#gentle-wave" x="48" y="16" fill="rgba(255,255,255,0.95" />
                    </g>
                  </svg>
                </div>

              @endif

            </div>
          </header>

          @if ( !empty($data) )
          
            <section id="download-box" class="pt-3 pb-4" wire:loading.remove wire:target="onDownload">
              <div class="container">

                <div class="row">
                  <div class="col-lg-9 z-index-2 border-radius-xl mt-n10 mx-auto py-3 blur shadow-blur">
                    <div class="row">

                      <div class="col-md-4 position-relative">

                        <div class="p-3">
                          <div class="card-header p-0 position-relative z-index-1">
                            <a href="javascript:;" class="d-block">

                              @if ( !empty( $data['thumbnail'] ) )

                                <img src="{{ $data['thumbnail'] }}" class="img-fluid border-radius-lg shadow">

                              @else
                                <img src="{{ asset('assets/img/no-thumb.jpg') }}" class="img-fluid border-radius-lg shadow">
                              @endif
                              
                            </a>
                          </div>

                          @if ( !empty( $data['title'] ) )

                            <h6 class="mt-3">{{ $data['title'] }}</h6>

                          @endif

                          @if ( !empty( $data['duration'] ) )
                            <p class="text-sm">{{ __('Duration') }}: {{ $data['duration'] }}</p>
                          @endif
                        </div>

                        <hr class="vertical dark">
                      </div>

                      <div class="col-md-8 position-relative">
                        <div class="p-2">

                          @if ( !empty( $data['links'] ) )

                            <table class="table border-transparent">
                              <tbody>
                                <tr>
                                  <td>

                                    @foreach ($data['links'] as $key => $value)

                                        @switch(true)

                                            @case( !empty( $value['type'] ) && ( $value['type'] == 'mp3' || $value['type'] == 'm4a' || preg_match('/.*kbps.*/', $value['quality'], $matches) ) )

                                                  @if ( $data['source'] == 'SoundCloud' )
                                                    <a class="btn bg-gradient-info" id="downloadInstantly" title="{{ __('Download') }}" data-url="{{ $value['url'] }}" data-title="{{ $data['title'] }}.mp3" onclick="downloadInstantly()" download>
                                                  @else
                                                    <a class="btn bg-gradient-info" href="{{ $value['url'] }}" title="{{ __('Download') }}" target="_blank">
                                                  @endif

                                                  <span class="d-block"><i class="fas fa-headphones"></i></span>

                                                @break

                                            @case( ($data['source'] === 'Youtube' && $value['mute'] === true) || ($value['type'] === "mp4" && $value['mute'] === true) )

                                                <a class="btn bg-gradient-danger" href="{{ $value['url'] }}" title="{{ __('Download') }}" target="_blank">

                                                  <span class="d-block"><i class="fas fa-volume-mute fa-lg"></i></span>

                                                @break

                                            @case( $value['type'] === "jpg" )

                                                <a class="btn bg-gradient-success" href="{{ $value['url'] }}" title="{{ __('Download') }}" target="_blank">

                                                  <span class="d-block"><i class="fas fa-image"></i></span>

                                                @break

                                            @default
                                                <a class="btn bg-gradient-success" href="{{ $value['url'] }}" title="{{ __('Download') }}" target="_blank">

                                                    <span class="d-block"><i class="fas fa-video"></i></span>

                                        @endswitch


                                        @if ( !empty( $value['quality'] ) )

                                          <span class="d-block">{{ $value['quality'] }}</span>
                                        
                                        @endif

                                        @if ( !empty( $value['type'] ) )

                                          <span class="d-block">{{ ($value['type'] == 'progressive') ? 'mp3' : $value['type'] }}</span>
                                        
                                        @endif

                                        @if ( $value['size'] != 0 )
                                          <span class="d-block">({{ $value['size'] }})</span>
                                        @endif
                                        
                                      </a>

                                    @endforeach

                                  </td>
                                </tr>
                              </tbody>
                            </table>

                          @else

                          <div class="alert alert-danger" role="alert">
                              {{ __('No data found!') }}
                          </div>

                          @endif

                        </div>
                      </div>

                    </div>
                  </div>
                </div>

              </div>
            </section>

          @endif

          @if ( $general->supported_sites == true && ( $page->type == 'downloader' || $page->type == 'home' ) )
            <section class="my-3">
              <div class="container">
                <div class="row">
                  <div class="info-horizontal bg-gray-100 border-radius-xl p-4">
                    <h5 class="text-center text-gradient text-dark">{{ __('Supported Resources') }}</h5>
                    <div class="is-divider"></div>
                    <div class="row">
                        @foreach (glob( app_path() . "/Classes/*.php") as $file)
                          @php

                          $name = explode('.', basename($file));

                          $data = '<div class="col">
                                    <div class="card card-plain text-center">
                                        <a href="javascript:;">
                                          <img class="avatar avatar-md shadow" src="'.asset('assets/img/plugins/%s.svg').'">
                                        </a>

                                        <div class="card-body px-0">
                                          <h6 class="card-title">%s</h6>
                                        </div>
                                      </div>
                                    </div>';

                          if (!empty($name[0]) && File::exists( getcwd() . '/assets/img/plugins/' . strtolower($name[0]) . '.svg') ) {

                            printf($data, strtolower($name[0]), $name[0] );

                          };

                          @endphp
                        @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </section>
          @endif

          <section class="my-3">
              <div class="container">
                  <div class="row">
                      <div class="info-horizontal bg-gray-100 border-radius-xl p-5">

                          @if ( $advertisement->area3_status == true && $advertisement->area3 != null )
                            <x-frontend.advertisement.area3 :advertisement="$advertisement" />
                          @endif

                          <div id="page-content">
                            {!! __(GrahamCampbell\Security\Facades\Security::clean($pageTrans->description)) !!}

                            @switch( $page->type )

                                @case('report')
                                      @livewire('frontend.report')
                                    @break

                                @case('contact')
                                      @livewire('frontend.contact')
                                    @break

                                @default
                            @endswitch
   
                          </div>

                          @if ( $general->share_icons_status == true )

                            <div class="social-share text-center">
                              <div class="is-divider"></div>
                              <div class="share-icons relative">

                                  <a href="https://www.facebook.com/sharer.php?u={{ urlencode( url()->full() ) }}"
                                      data-label="Facebook"
                                      rel="noopener noreferrer nofollow"
                                      target="_blank"
                                      class="btn btn-facebook btn-simple rounded p-2">
                                      <i class="fab fa-facebook"></i>
                                  </a>

                                  <a href="https://twitter.com/share?url={{ urlencode( url()->full() ) }}"
                                      rel="noopener noreferrer nofollow"
                                      target="_blank"
                                      class="btn btn-twitter btn-simple rounded p-2">
                                      <i class="fab fa-twitter"></i>
                                  </a>

                                  <a href="https://www.pinterest.com/pin-builder/?url={{ urlencode( url()->full() ) }}&media={{ $page->featured_image }}&description={{ str_replace(' ', '%20', $pageTrans->title) }}"
                                      rel="noopener noreferrer nofollow"
                                      target="_blank"
                                      class="btn btn-pinterest btn-simple rounded p-2">
                                      <i class="fab fa-pinterest"></i>
                                  </a>

                                  <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode( url()->full() ) }}"
                                      rel="noopener noreferrer nofollow"
                                      target="_blank"
                                      class="btn btn-linkedin btn-simple rounded p-2">
                                      <i class="fab fa-linkedin"></i>
                                  </a>

                                  <a href="https://www.reddit.com/submit?url={{ urlencode( url()->full() ) }}&title={{ str_replace(' ', '%20', $pageTrans->title) }}"
                                      rel="noopener noreferrer nofollow"
                                      target="_blank"
                                      class="btn btn-reddit btn-simple rounded p-2">
                                      <i class="fab fa-reddit"></i>
                                  </a>

                                  <a href="https://tumblr.com/widgets/share/tool?canonicalUrl={{ urlencode( url()->full() ) }}"
                                      target="_blank"
                                      class="btn btn-tumblr btn-simple rounded p-2"
                                      rel="noopener noreferrer nofollow">
                                      <i class="fab fa-tumblr"></i>
                                  </a>

                              </div>
                            </div>
                          @endif

                          @if ( $advertisement->area4_status == true && $advertisement->area4 != null )
                            <x-frontend.advertisement.area4 :advertisement="$advertisement" />
                          @endif

                          @if ( $general->author_box_status == true )

                            <hr class="horizontal dark">
                            <div class="card card-profile card-plain mt-4">
                              <div class="row">

                                <div class="col-lg-2">
                                  <a href="javascript:;">
                                    <div class="position-relative">
                                      <div class="blur-shadow-image">
                                        <img class="w-100 rounded-3 shadow-lg" src="{{ $profile->avatar }}">
                                      </div>
                                    </div>
                                  </a>
                                </div>

                                <div class="col-lg-10 ps-0 my-auto">
                                  <div class="card-body text-start py-0">

                                    <div class="p-md-0 pt-3">
                                      <h5 class="font-weight-bolder mb-0">{{ $profile->fullname }}</h5>
                                      <p class="text-uppercase text-sm font-weight-bold mb-2">{{ $profile->position }}</p>
                                    </div>

                                    <p class="mb-4">{{ __($profile->bio) }}</p>

                                    @if ( ($profile->social_status == true) && !empty($profile->user_socials) )

                                      @foreach ($profile->user_socials as $element)

                                        <a class="btn btn-{{ $element->name }} btn-simple mb-0 ps-1 pe-2 py-0" href="{{ $element->url }}" target="blank">
                                          <i class="fab fa-{{ $element->name }} fa-lg" aria-hidden="true"></i>
                                        </a>

                                      @endforeach

                                    @endif

                                  </div>
                                </div>

                              </div>
                            </div>

                          @endif

                      </div>
                  </div>
              </div>
          </section>

        @endif

        <x-frontend.footer :footer="$footer" :general="$general" :socials="$socials" />

        <!-- jQuery -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

        <!-- Popper JS -->
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>

        <!-- Bootstrap JS -->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        
        <!-- Theme JS -->
        <script src="{{ asset('assets/js/main.min.js') }}"></script>

        @if ( $page->type == 'downloader' || $page->type == 'home' )
              <script>
                 (function( $ ) {
                    "use strict";
                    
                          function downloadInstantly() {

                            var filename = jQuery('a#downloadInstantly').data('title');

                            var url = jQuery('a#downloadInstantly').data('url');

                            if (!filename) filename = url.split('\\').pop().split('/').pop();

                              fetch(url, {
                                  headers: new Headers({
                                    'Origin': location.origin
                                  }),
                                  mode: 'cors'
                                })
                                .then(response => response.blob())
                                .then(blob => {
                                  let blobUrl = window.URL.createObjectURL(blob);

                                  const link = document.createElement('a');

                                  link.href = blobUrl;

                                  link.setAttribute(
                                    'download',
                                    filename,
                                  );

                                  document.body.appendChild(link);

                                  link.click();

                                  link.parentNode.removeChild(link);
                                  
                                })
                                .catch(e => console.error(e));
                          };

                })( jQuery );
              </script>
        @endif

        @if ( $general->recaptcha_v3 == true && !empty($api_key->recaptcha_public_api_key ) )
          <script src="https://www.google.com/recaptcha/api.js?render={{ $api_key->recaptcha_public_api_key }}"></script>
        @endif

        @if (Cookie::get('cookies') == null)

          @if ( $notice->status == true )
              <div class="row notice alert {{ $notice->background }}" role="alert">
                
                <div class="col-md-12 col-lg-10 my-auto {{ $notice->align }}">
                  {!! __(GrahamCampbell\Security\Facades\Security::clean($notice->notice)) !!}
                </div>

                <div class="col-md-12 col-lg-2 my-auto p-2">

                  @if ( $notice->button == true)
                    <button id="acceptCookies" target="_blank" class="btn btn-sm bg-white mb-0 text-capitalize"> {{ __('Accept all cookies') }} </button>
                  @endif

                  <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close">x</button>
                </div>

              </div>
              <script>
                 (function( $ ) {
                    "use strict";
             
                        $("#acceptCookies").click(function(){
                            jQuery.ajax({
                                type : 'get',
                                url : '{{ url('/') }}/cookies/accept',
                                success: function(e) {
                                    jQuery('.notice').remove();
                                }
                            });
                        });

                })( jQuery );
              </script>
          @endif

        @endif

        @if ( $advanced->footer_status == true && $advanced->insert_footer != null )
          {!! $advanced->insert_footer !!}
        @endif
</div>
