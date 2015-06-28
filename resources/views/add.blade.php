@extends("templates.base")

@section("title")
{{ "Add new documents - Kokaku" }}@stop

@section("content")
@include("templates.partials.topnav")
<div class="app">
  @include("templates.partials.sidenav")
  <div class="content">
    @include("templates.partials.contentnav")
    <div class="items-wrap">
    <form class="add-form" method="post">
      <div class="group-input group-1 show"></div>
      <div class="group-input group-2"></div>
      <div class="group-input group-3">
        <div class="upload-group">
          <input type="file" id="fileupload" name="files[]">
          <button class="act-upload"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add file</button>
        </div>
        <div class="list-file">
        </div>
      </div>
    </form>
    </div>
  </div>
</div>
<div id="nanobar"></div>
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
    var statistic = new Statistic();
    var form = new SchemaForm();
    form.init();
    form.setStat(statistic);

    var tab = new ContentTab();
    var upload = new Upload();
    var sideNav = new SideNav();
    var preference = new Preference();

    upload.setForm(form);
  });
</script>
@stop