<script id="template-input-generic" type="x-tmpl=mustache">
  @{{#hidden}}
  <div class="input input-@{{ class }} hidden">
    <label for="@{{ key }}">@{{ class }}</label>
    <input name="@{{ key }}" type="@{{ type }}">
  </div>
  @{{/hidden}}
  @{{^hidden}}
  <div class="input input-@{{ class }}">
    <label for="@{{ key }}">@{{ class }}</label>
    <input name="@{{ key }}" type="@{{ type }}">
  </div>
  @{{/hidden}}
</script>

<script id="template-input-select" type="x-tmpl=mustache">
  <div class="input input-@{{ class }}">
    <label for="@{{ key }}">@{{ class }}</label>
    <select name="@{{ key }}">
      <option value="">-</option>
      @{{#enum}}
      <option value="@{{ . }}">@{{ . }}</option>
      @{{/enum}}
    </select>
  </div>
</script>

<script id="template-btn-add" type="x-tmpl=mustache">
  <div class="act-input" data-index="@{{ index }}">
    <span class="btn-add add-@{{ key }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Field</span>
  </div>
</script>

<script id="template-metadatas" type="x-tmpl=mustache">
  @{{#meta}}
  <li class="act-edit-item meta">
    <a href="metadata/view/@{{ id }}?tab=1">
    @{{#number}}
    <span class="number">@{{ number }}</span>
    @{{/number}}
    @{{^number}}
    <span class="number">null</span>
    @{{/number}}
    @{{#docType}}
    <span class="main-type">@{{ docType }}</span>
    @{{/docType}}
    @{{^docType}}
    <span class="main-type">null</span>
    @{{/docType}}
    @{{#title}}
    <span class="title">@{{ title }}</span>
    @{{/title}}
    @{{^title}}
    <span class="title">(no title) @{{ originalFilename }}</span>
    @{{/title}}
    @{{#publishedDate}}
    <span class="publishedDate">@{{ publishedDate }}</span>
    @{{/publishedDate}}
    @{{^publishedDate}}
    <span class="publishedDate">null</span>
    @{{/publishedDate}}
    @{{#created_at}}            
    <span class="created-date">@{{#formatDate}}@{{ created_at }}@{{/formatDate}}</span>
    @{{/created_at}}
    @{{^created_at}}
    <span class="created-date">@{{ created_at }}</span>
    @{{/created_at}}
    </a>
  </li>
  @{{/meta}}
</script>

<script id="template-sidenav" type="x-tmpl=mustache">
  @{{#urls}}
  <ul>
    <li class="go-incomplete"><a href="@{{ incomplete }}">Incompleted &nbsp;&nbsp;<span class="count"></span></a></li>
    <li class="go-complete"><a href="@{{ complete }}">Completed &nbsp;&nbsp;<span class="count"></span></a></li>
    <li class="go-all"><a href="@{{ all }}">All &nbsp;&nbsp;<span class="count"></span></a></li>
  </ul>
  @{{/urls}}
</script>

<script id="template-pagination" type="x-tmpl=mustache">
<ul class="control">
  @{{#first_page_url}}
  <li class="act-first available"><a href="@{{first_page_url}}"></a></li>
  <li class="act-previous available"><a href="@{{prev_page_url}}"></a></li>
  @{{/first_page_url}}
  @{{^first_page_url}}
  <li class="act-first"></li>
  <li class="act-previous"></li>
  @{{/first_page_url}}
  @{{#next_page_url}}
  <li class="act-next available"><a href="@{{next_page_url}}"></a></li>
  <li class="act-last available"><a href="@{{last_page_url}}"></a></li>
  @{{/next_page_url}}
  @{{^next_page_url}}
  <li class="act-next"></li>
  <li class="act-last"></li>
  @{{/next_page_url}}
</ul>
<span class="pages-count">Page @{{ current_page }} from @{{ last_page }}</span>
<span class="pages-totalItem">from @{{ from }} to @{{ to }}</span>
</script>