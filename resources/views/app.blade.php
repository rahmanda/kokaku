@extends("templates.base")

@section("title")
{{ "Kokaku - Metadata management system" }}@stop

@section("content")
@include("templates.partials.topnav")
<div class="app">
  @include("templates.partials.sidenav")
  <div class="content">
    @include("templates.partials.contentnav")
    <div class="items-wrap">
    @include("templates.partials.itemlist")
    @include("templates.partials.pagination")
    </div>
  </div>
</div>
@include("templates.partials.flash")
@include("templates.partials.tutorialmodal")
@include("templates.partials.settingmodal")
@stop

@section("scripts")
<script src="/vendor/jquery.geturlparam/jquery.geturlparam.min.js"></script>
<script src="/vendor/jquery-ajax-progress/js/jquery.ajax-progress.js"></script>
<script src="/vendor/nanobar/nanobar.min.js" type="text/javascript"></script>
<script src="/vendor/jQuery-File-Upload/js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
<script src="/vendor/jQuery-File-Upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
<script src="/vendor/jQuery-File-Upload/js/jquery.fileupload.js" type="text/javascript"></script>
<script src="/vendor/mustache.js/mustache.js" type="text/javascript"></script>
<script src="/vendor/momentjs/moment.js" type="text/javascript"></script>
@include("templates.partials.mustache")
<script src="/js/kokaku.min.js"></script>
<script type="text/javascript">
  $(function() {
    'use strict';

    var sideNav = new SideNav();

    var navContent = new NavContent();

    var metadatas = new Metadatas();

    var preference = new Preference();

  });
</script>
@stop