<header class="top-wrap">
  <div class="brand">
    <h1>Kokaku</h1>
  </div>
  <nav class="state-nav">
    <ul class="nav-list">
      @if($route == "view")
      <li class="act-add pop"><a href="{{ route('addMetadata') }}?tab=1"><i class="fa fa-plus"></i>New</a></li>
      <li class="act-update pop"><a href="#"><i class="fa fa-refresh"></i>Update</a></li>
      @elseif($route == "addMetadata")
      <li class="act-save pop"><a href="#"><i class="fa fa-save"></i>Save</a></li>
      @else
      <li class="act-add pop"><a href="{{ route('addMetadata') }}?tab=1"><i class="fa fa-plus"></i>New</a></li>
      @endif
      <!-- <li class="act-delete pop"><a href="#">Hapus</a></li> -->
    </ul>
  </nav>
  <nav class="top-nav">
    <span class="act-account list">
      <p class="user-name">Rahmanda Wibowo</p>
      <ul id="account-options" class="options">
        <li class="go-setting"><a href="#">Setting</a></li>
        <li class="act-tutorial pop"><a href="#">Tutorial</a></li>
        <li class="act-logout"><a href="#">Logout</a></li>
      </ul>
    </span>
    <span class="act-upload-progress list">
      <p></p>
      <ul class="prog-upload options">
        <span class="bar-prog">
          <span class="bar"></span>
        </span>
      </ul>
    </span>
  </nav>
</header>